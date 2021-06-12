<?php
namespace App\Http\Helpers\Custom;

use App\Models\Monitoringjobdesk;
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
}