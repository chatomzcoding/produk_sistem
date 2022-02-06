<?php

namespace App\Http\Controllers;

use App\Models\Jobdesk;
use App\Models\Manajemenjobdesk;
use App\Models\Monitoringjobdesk;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function halaman($page)
    {
        switch ($page) {
            case 'shutterstock':
                $dr = (isset($_GET['dr'])) ? $_GET['dr'] : 15000 ;
                $batas = (isset($_GET['batas'])) ? $_GET['batas'] : 35 ;
                $jobdesk    = Jobdesk::where('kode','s-shutterstock')->first();
                $manajemenjobdesk   = Manajemenjobdesk::where('jobdesk_id',$jobdesk->id)->get();
                $total      = 0;
                $perhitungan= 0;
                $akun       = [];
                foreach ($manajemenjobdesk as $item) {
                    $monitoring     = Monitoringjobdesk::where('manajemenjobdesk_id',$item->id)->orderBy('id','DESC')->first();
                    if ($monitoring) {
                        $akun[]     = $monitoring;
                        $jumlah     = $monitoring->jumlah;
                        if ($jumlah >= $batas) {
                            $perhitungan = $perhitungan + $jumlah; 
                        }
                        $total  = $total + $jumlah;
                    }
                }     
                $totalrp            = $total * $dr;
                $perhitunganrp      = $perhitungan * $dr;
                $sisa               = $total - $perhitungan;
                $sisarp             = $sisa * $dr;
                $data       = [
                    'total' => [
                        'nilai' => $total,
                        'rp' => rupiah($totalrp),
                    ],
                    'perhitungan' => [
                        'nilai' => $perhitungan,
                        'rp' => rupiah($perhitunganrp),
                    ],
                    'sisa' => [
                        'nilai' => $sisa,
                        'rp' => rupiah($sisarp),
                    ],
                    'dr' => $dr,
                    'batas' => $batas,
                    'akun' => $akun,
                    'totalakun' => count($akun)
                ];
                return view('sistem.statistik.shutterstock', compact('data'));
                break;
            
            default:
                # code...
                break;
        }
    }
}
