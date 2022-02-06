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
                $akuncair   = 0;
                $akunbanned = 0;
                foreach ($manajemenjobdesk as $item) {
                    $monitoring     = Monitoringjobdesk::where('manajemenjobdesk_id',$item->id)->orderBy('id','DESC')->first();
                    if ($monitoring) {
                        $akun[]     = $monitoring;
                        $jumlah     = $monitoring->jumlah;
                        if ($jumlah >= $batas) {
                            $akuncair       = $akuncair + 1;
                            $perhitungan = $perhitungan + $jumlah; 
                        }
                        if ($jumlah == 0) {
                            $akunbanned = $akunbanned + 1;
                        }
                        $total  = $total + $jumlah;
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
