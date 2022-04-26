<?php

namespace App\Http\Controllers;

use App\Models\Jobdesk;
use App\Models\Manajemenjobdesk;
use App\Models\Monitoringjobdesk;
use App\Models\Pembayaranproyek;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function halaman($page, Request $request)
    {
        switch ($page) {
            case 'shutterstock':
                $proyek     = Proyek::where('nama_proyek','shutter')->first();
                $user       = Auth::user();
                $dr = (isset($_GET['dr'])) ? $_GET['dr'] : 15000 ;
                $batas = (isset($_GET['batas'])) ? $_GET['batas'] : $proyek->biaya ;
                $jobdesk    = Jobdesk::where('kode','s-shutterstock')->first();
                $manajemenjobdesk   = Manajemenjobdesk::where('jobdesk_id',$jobdesk->id)->get();
                $total      = 0;
                $perhitungan= 0;
                $akunatas   = [];
                $akunbawah  = [];
                $akuncair   = 0;
                $akunbanned = 0;
                $totalakun  = 0;
                foreach ($manajemenjobdesk as $item) {
                    $monitoring     = Monitoringjobdesk::where('manajemenjobdesk_id',$item->id)->where('jumlah','<>',NULL)->orderBy('id','DESC')->first();
                    if ($monitoring) {
                        $totalakun  = $totalakun + 1;
                        $jumlah     = $monitoring->jumlah;
                        $nama           = strtolower(substr($item->catatan,5,strlen($item->catatan)));
                        $pembayaran     = Pembayaranproyek::where('nama_pembayaran',$nama)->first();
                        if ($pembayaran) {
                            $ket            = explode('||',$pembayaran->keterangan_pembayaran);
                            if (in_array('banned',$ket)) {
                                $akunbanned = $akunbanned + 1;
                            } else {
                                if ($jumlah >= $batas) {
                                    $akuncair       = $akuncair + 1;
                                    $perhitungan = $perhitungan + $jumlah; 
                                    $akunatas[]     = $monitoring;
                                } else {
                                    $akunbawah[]    = $monitoring;
                                }
                                $total  = $total + $jumlah;
                            }
                        }
                    }
                }     
                $totalrp            = $total * $dr;
                $perhitunganrp      = $perhitungan * $dr;
                $sisa               = $total - $perhitungan;
                $sisarp             = $sisa * $dr;
                $totalakun          = count($manajemenjobdesk);
                $akunsisa           = $totalakun - $akuncair;
                
                $data       = [
                    'total' => [
                        'nilai' => $total,
                        'rp' => rupiah($totalrp),
                        'akun' => $totalakun,
                    ],
                    'perhitungan' => [
                        'nilai' => $perhitungan,
                        'rp' => rupiah($perhitunganrp),
                        'akun' => $akuncair
                    ],
                    'sisa' => [
                        'nilai' => $sisa,
                        'rp' => rupiah($sisarp),
                        'akun' => $akunsisa,
                    ],
                    'dr' => $dr,
                    'batas' => $batas,
                    'akunbanned' => $akunbanned,
                    'totalakun' => $totalakun,
                    'akun' => [
                        'atas' => $akunatas,
                        'bawah' => $akunbawah,
                    ]
                ];
                return view('sistem.statistik.shutterstock', compact('data','user'));
                break;
            
            case 'magang':
                if ($request->session()->has('listmagang')) {
                    $data = $request->session()->get('listmagang');
                } else {
                    $data = datajson('https://sistem.zelnara.com/api/cikarastudio?s=magang');
                    $data = json_decode($data);
                    $request->session()->put('listmagang',$data);
                }
                
                return view('sistem.statistik.magang', compact('data'));
                break;
            case 'tambahmagang':
                return view('sistem.statistik.tambahmagang');
                break;
            default:
                # code...
                break;
        }
    }

    public function simpanmagang(Request $request)
    {
        $file = base64_encode($request->photo);
        $file = base64_decode($file);
        dd([$file,$request->photo]);
        if (isset($request->photo)) {
            // validation form photo
            $request->validate([
                'photo' => 'required|file|image|mimes:jpeg,png,jpg|max:1000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('photo');
            
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'public/img/magang';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$nama_file);
            $nama_file = 'https://sistem.cikarastudio.com/public/img/magang/'.$nama_file;
        } else {
            $nama_file = NULL;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sistem.zelnara.com/api/simpanmagang',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => "photo=".$nama_file."&first_name=".$request->first_name."&last_name=".$request->last_name."&place_birth=".$request->place_birth."&date_birth=".$request->date_birth."&gender=".$request->gender."&home_address=".$request->home_address."&religion=".$request->religion."&blood_type=".$request->blood_type."&job_status=".$request->job_status."&note=".$request->note,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        $request->session()->forget('listmagang');

        return redirect('statistik/magang')->with('ds','Orang');
        
    }
}
