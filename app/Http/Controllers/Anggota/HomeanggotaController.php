<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Pembayaranproyek;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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
    public function proyek()
    {
        $user       = Auth::user();
        $anggota    = Anggota::where('user_id',$user->id)->first();
        $proyek    = DB::table('manajemen_proyek')
                        ->join('anggota','manajemen_proyek.anggota_id','=','anggota.id')
                        ->join('proyek','manajemen_proyek.proyek_id','=','proyek.id')
                        ->where('manajemen_proyek.anggota_id',$anggota->id)
                        ->select('manajemen_proyek.*','proyek.*','proyek.id as idproyek')
                        ->get();
        $daftarproyek   = Proyek::all();
        return view('anggota.proyek', compact('proyek','daftarproyek'));
    }

    public function detailproyek($id)
    {
        $proyek         = Proyek::find(Crypt::decryptString($id));
        $manajemenproyek= DB::table('manajemen_proyek')
                            ->join('anggota','manajemen_proyek.anggota_id','=','anggota.id')
                            ->join('users','anggota.user_id','=','users.id')
                            ->select('manajemen_proyek.*','users.name')
                            ->where('manajemen_proyek.proyek_id',$proyek->id)
                            ->get();
        $anggota        = DB::table('anggota')
                            ->join('users','anggota.user_id','=','users.id')
                            ->select('anggota.id','users.name')
                            ->get();
        $pembayaran     = Pembayaranproyek::where('proyek_id',$proyek->id)->get();
        return view('anggota.detailproyek', compact('proyek','manajemenproyek','anggota','pembayaran'));
    }
}
