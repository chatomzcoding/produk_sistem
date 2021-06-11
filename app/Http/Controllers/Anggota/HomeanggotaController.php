<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeanggotaController extends Controller
{
    public function jobdesk()
    {
        $user       = Auth::user();
        $anggota    = Anggota::where('user_id',$user->id)->first();
        $jobdesk    = DB::table('manajemen_jobdesk')
                        ->join('jobdesk','manajemen_jobdesk.jobdesk_id','=','jobdesk.id')
                        ->where('manajemen_jobdesk.anggota_id',$anggota->id)
                        ->select('manajemen_jobdesk.*','jobdesk.*','manajemen_jobdesk.id as idmanajemen')
                        ->get();
        return view('anggota.jobdesk', compact('jobdesk'));
    }
}
