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
    public function halaman($page)
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
                // $pkl        = DB::table('monitoring_jobdesk')
                //                 ->join('manajemen_jobdesk','monitoring_jobdesk.manajemenjobdesk_id','=','manajemen_jobdesk.id')
                //                 ->join('jobdesk','manajemen_jobdesk.jobdesk_id','=','jobdesk.id')
                //                 ->select('monitoring_jobdesk.manajemenjobdesk_id','monitoring_jobdesk.jumlah')
                //                 ->where('jobdesk.kode','s-shutterstock')
                //                 ->where('monitoring_jobdesk.jumlah','<=',$batas)
                //                 ->orderby('jumlah','DESC')
                //                 ->get();
                // $akunbawah = [];
                // foreach ($pkl as $key) {
                //     if (!isset($akunbawah[$key->manajemenjobdesk_id])) {
                //         $akunbawah[$key->manajemenjobdesk_id] = $key;
                //     }
                // }
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
            
            default:
                # code...
                break;
        }
    }
}
