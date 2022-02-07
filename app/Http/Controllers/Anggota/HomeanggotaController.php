<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Client;
use App\Models\Jobdesk;
use App\Models\Layanan;
use App\Models\Manajemenjobdesk;
use App\Models\Monitoringjobdesk;
use App\Models\Pembayaranproyek;
use App\Models\Proyek;
use App\Models\Rekening;
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

    public function manajemenjobdesk($manajemenjobdesk)
    {
        $monitoring     = Monitoringjobdesk::where('manajemenjobdesk_id',Crypt::decryptString($manajemenjobdesk))->orderBy('id','DESC')->get();
        $manajemen      = Manajemenjobdesk::find(Crypt::decryptString($manajemenjobdesk));
        $jobdesk        = Jobdesk::find($manajemen->jobdesk_id);
        $user           = DB::table('anggota')
                            ->join('users','anggota.user_id','=','users.id')
                            ->select('users.name')
                            ->where('anggota.id',$manajemen->anggota_id)
                            ->first();
        $total          = Monitoringjobdesk::where('manajemenjobdesk_id',Crypt::decryptString($manajemenjobdesk))->orderBy('id','DESC')->sum('jumlah');
        return view('anggota.manajemenjobdesk', compact('monitoring','manajemen','jobdesk','user','total'));
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
                        ->orderByDesc('manajemen_proyek.id')
                        ->get();
        $daftarproyek   = Proyek::all();
        return view('anggota.proyek', compact('proyek','daftarproyek'));
    }

    public function layanan()
    {
        $layanan    = Layanan::all();

        return view('anggota.daftarlayanan', compact('layanan'));
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
        $manajemenpihaklain= DB::table('manajemen_pihaklain')
                            ->join('client','manajemen_pihaklain.client_id','=','client.id')
                            ->select('manajemen_pihaklain.*','client.nama')
                            ->where('manajemen_pihaklain.proyek_id',$proyek->id)
                            ->get();
        $anggota        = DB::table('anggota')
                            ->join('users','anggota.user_id','=','users.id')
                            ->select('anggota.id','users.name')
                            ->get();
        $pihaklain         = Client::where('level','pihaklain')->get();
        $pembayaran     = Pembayaranproyek::where('proyek_id',$proyek->id)->orderBy('id','DESC')->get();
        return view('anggota.detailproyek', compact('proyek','manajemenproyek','anggota','pembayaran','manajemenpihaklain','pihaklain'));
    }

    public function rekeninganggota()
    {
        $anggota    = Anggota::where('user_id',Auth::user()->id)->first();
        $rekening   = Rekening::where('anggota_id',$anggota->id)->orderBy('id','DESC')->get();

        return view('anggota.rekening', compact('rekening','anggota'));
    }
}
