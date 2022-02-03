<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Jobdesk;
use App\Models\Manajemenjobdesk;
use App\Models\Manajemenproyek;
use App\Models\Monitoringjobdesk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ManajemenjobdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobdesk    = Jobdesk::where('status_jobdesk','aktif')->get();
        $anggota        = DB::table('anggota')
        ->join('users','anggota.user_id','=','users.id')
        ->select('anggota.id','users.name')
        ->get();
        $manajemen  = DB::table('manajemen_jobdesk')
                        ->join('jobdesk','manajemen_jobdesk.jobdesk_id','=','jobdesk.id')
                        ->join('anggota','manajemen_jobdesk.anggota_id','=','anggota.id')
                        ->join('users','anggota.user_id','=','users.id')
                        ->select('manajemen_jobdesk.*','jobdesk.nama_jobdesk','users.name')
                        ->get();
        return view('admin.jobdesk.manajemen.index', compact('jobdesk','manajemen','anggota'));
    }

    public function monitoring()
    {
        $anggota    = DB::table('anggota')
                    ->join('users','anggota.user_id','=','users.id')
                    ->select('users.name','anggota.id')
                    ->get();
        return view('admin.jobdesk.monitoring', compact('anggota'));
    }
    public function cekjobdesk($id)
    {
        $monitoring         = Monitoringjobdesk::find(Crypt::decryptString($id));
        $manajemenjobdesk   = Manajemenjobdesk::find($monitoring->manajemenjobdesk_id);
        $jobdesk            = Jobdesk::find($manajemenjobdesk->jobdesk_id);
        $anggota            = Anggota::find($manajemenjobdesk->anggota_id);
        $user               = User::find($anggota->user_id);
        return view('admin.jobdesk.cekjobdesk', compact('monitoring','jobdesk','anggota','user','manajemenjobdesk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // pengecekan jika anggota dan jobdesk sama (duplikat)
        $cek    = Manajemenjobdesk::where('anggota_id',$request->anggota_id)->where('jobdesk_id',$request->jobdesk_id)->where('catatan',$request->catatan)->first();
        if ($cek) {
            $anggota    = Anggota::find($cek->anggota_id);
            $user       = User::find($anggota->user_id);
            $jobdesk    = Jobdesk::find($cek->jobdesk_id);
            $nama       = ucwords($user->name);
            return redirect()->back()->with('danger',$nama." sudah memiliki jobdesk '".$jobdesk->nama_jobdesk."'");
        } else {
            Manajemenjobdesk::create($request->all());
    
            return redirect()->back()->with('ds','Manajemen Jobdesk');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manajemenjobdesk  $manajemenjobdesk
     * @return \Illuminate\Http\Response
     */
    public function show($manajemenjobdesk)
    {
        $monitoring     = Monitoringjobdesk::where('manajemenjobdesk_id',Crypt::decryptString($manajemenjobdesk))->orderBy('id','DESC')->get();
        $manajemen      = Manajemenjobdesk::find(Crypt::decryptString($manajemenjobdesk));
        $jobdesk        = Jobdesk::find($manajemen->jobdesk_id);
        $user           = DB::table('anggota')
                            ->join('users','anggota.user_id','=','users.id')
                            ->select('users.name')
                            ->where('anggota.id',$manajemen->anggota_id)
                            ->first();
        $total          = Monitoringjobdesk::where('manajemenjobdesk_id',Crypt::decryptString($manajemenjobdesk))->sum('jumlah');
        return view('admin.jobdesk.manajemen.show', compact('monitoring','manajemen','jobdesk','user','total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manajemenjobdesk  $manajemenjobdesk
     * @return \Illuminate\Http\Response
     */
    public function edit(Manajemenjobdesk $manajemenjobdesk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manajemenjobdesk  $manajemenjobdesk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Manajemenjobdesk::where('id',$request->id)->update([
            'jobdesk_id' => $request->jobdesk_id,
            'anggota_id' => $request->anggota_id,
            'tingkatan' => $request->tingkatan,
            'catatan' => $request->catatan,
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir,
            'skala_prioritas' => $request->skala_prioritas,
        ]);

        return redirect()->back()->with('ds','Manajemen Jobdesk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manajemenjobdesk  $manajemenjobdesk
     * @return \Illuminate\Http\Response
     */
    public function destroy($manajemenjobdesk)
    {
        Manajemenjobdesk::find($manajemenjobdesk)->delete();
       
        return redirect()->back()->with('dd','Manajemen Jobdesk');
    }
}
