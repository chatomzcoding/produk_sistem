<?php
namespace App\Http\Helpers\Custom;

use App\Models\Manajemenjobdesk;
use App\Models\Monitoringjobdesk;
use App\Models\Rekening;
use Illuminate\Support\Facades\DB;

class DbSistem {

    public static function countGroupId($id) {
        $jumlah = DB::table('members')->where('group_id', $id)->count();
        return $jumlah;
    }

    public static function showtableid($table,$id)
    {
        $data = DB::table($table)->where('id',$id)->first();
        return $data;
    }

    // total data tabel
    public static function countData($table=null,$where=null)
    {
        $total = null;
        if (!is_null($table)) {
            if (!is_null($where) AND is_array($where)) {
                if (count($where) == 2) {
                    $total = DB::table($table)
                    ->where($where[0],$where[1])
                    ->count();
                }
            } else {
                $total = DB::table($table)
                ->count();
            }
            return $total;
        }
    }

    // tampil data table
    public static function showtable($table=null,$where=null)
    {
        if (!is_null($where) AND is_array($where)) {
            $show = DB::table($table)
            ->where($where[0],$where[1])
            ->get();
        } else {
            $show = DB::table($table)
            ->get();
        }
        return $show;
    }
    // tampil data table
    public static function showtablefirst($table,$where=null)
    {
        if (!is_null($where) AND is_array($where)) {
            $show = DB::table($table)
            ->where($where[0],$where[1])
            ->first();
        } else {
            $show = DB::table($table)
            ->first();
        }
        return $show;
    }

    // khusus untuk sistm cikara
    // harian
    public static function listjobdeskanggotahariini($anggota)
    {
        $data = DB::table('monitoring_jobdesk')
                ->join('manajemen_jobdesk','monitoring_jobdesk.manajemenjobdesk_id','=','manajemen_jobdesk.id')
                ->join('jobdesk','manajemen_jobdesk.jobdesk_id','=','jobdesk.id')
                ->where('manajemen_jobdesk.anggota_id',$anggota)
                ->where('manajemen_jobdesk.tingkatan','harian')
                ->whereDate('monitoring_jobdesk.created_at',tgl_sekarang())
                ->select('monitoring_jobdesk.*','jobdesk.nama_jobdesk','jobdesk.keterangan_jobdesk')
                ->get();
        return $data;
    }
    // bulanan
    public static function listjobdeskanggotabulanini($anggota)
    {
        $data = DB::table('monitoring_jobdesk')
                ->join('manajemen_jobdesk','monitoring_jobdesk.manajemenjobdesk_id','=','manajemen_jobdesk.id')
                ->join('jobdesk','manajemen_jobdesk.jobdesk_id','=','jobdesk.id')
                ->where('manajemen_jobdesk.anggota_id',$anggota)
                ->where('manajemen_jobdesk.tingkatan','bulanan')
                ->whereMonth('monitoring_jobdesk.created_at',ambil_bulan())
                ->select('monitoring_jobdesk.*','jobdesk.nama_jobdesk','jobdesk.keterangan_jobdesk')
                ->get();
        return $data;
    }
    // kondisional
    public static function listjobdeskanggotakondisional($anggota)
    {
        $data = DB::table('monitoring_jobdesk')
                ->join('manajemen_jobdesk','monitoring_jobdesk.manajemenjobdesk_id','=','manajemen_jobdesk.id')
                ->join('jobdesk','manajemen_jobdesk.jobdesk_id','=','jobdesk.id')
                ->where('manajemen_jobdesk.anggota_id',$anggota)
                ->where('manajemen_jobdesk.tingkatan','kondisional')
                ->where('manajemen_jobdesk.tgl_awal','<=',tgl_sekarang())
                ->where('manajemen_jobdesk.tgl_akhir','>=',tgl_sekarang())
                ->select('monitoring_jobdesk.*','jobdesk.nama_jobdesk','jobdesk.keterangan_jobdesk','manajemen_jobdesk.tgl_awal','manajemen_jobdesk.tgl_akhir')
                ->get();
        return $data;
    }

    public static function listjobdeskanggota($anggota)
    {
        $data = DB::table('manajemen_jobdesk')
                ->join('jobdesk','manajemen_jobdesk.jobdesk_id','=','jobdesk.id')
                ->where('manajemen_jobdesk.anggota_id',$anggota)
                ->select('jobdesk.*','manajemen_jobdesk.*','manajemen_jobdesk.id as idmanajemen')
                ->get();
        return $data;
    }

    // cek rekening anggota
    public static function rekeninganggota($anggota,$matauang)
    {
        $jumlah     = 0;
        // cek ke table rekening
        $jumlah   = Rekening::where('anggota_id',$anggota)->where('matauang',$matauang)->sum('nominal');
       
        return $jumlah;
    }

    // dashboard anggota
    public static function dashbord_monitoring($anggota,$sesi)
    {
        $tglhariini     = ambil_tgl();
        $jumlah         = NULL;
        for ($i=1; $i <= $tglhariini; $i++) { 
            $data = DB::table('monitoring_jobdesk')
                    ->join('manajemen_jobdesk','monitoring_jobdesk.manajemenjobdesk_id','=','manajemen_jobdesk.id')
                    ->where('manajemen_jobdesk.anggota_id',$anggota)
                    ->where('manajemen_jobdesk.tingkatan','harian')
                    ->where('monitoring_jobdesk.status_monitoring',$sesi)
                    ->whereMonth('monitoring_jobdesk.created_at',ambil_bulan())
                    ->whereDay('monitoring_jobdesk.created_at',$i)
                    ->count();
            $jumlah     .= $data.',';
        }
        return $jumlah;
    }
    // nilai monitoring sebelumnya
    public static function nilai_sebelumnya($manajemenjobdesk_id,$id)
    {
        $nilai  = 0;
        $manajemenjobdesk = Monitoringjobdesk::where('id','<>',$id)->where('jumlah','<>',NULL)->where('manajemenjobdesk_id',$manajemenjobdesk_id)->latest()->first();
        if ($manajemenjobdesk) {
            $nilai = $manajemenjobdesk->jumlah;
        }
        return $nilai;
    }
}