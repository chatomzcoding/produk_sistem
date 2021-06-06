<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jobdesk;
use App\Models\Manajemenjobdesk;
use Illuminate\Http\Request;
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
        Manajemenjobdesk::create($request->all());

        return redirect()->back()->with('ds','Manajemen Jobdesk');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manajemenjobdesk  $manajemenjobdesk
     * @return \Illuminate\Http\Response
     */
    public function show(Manajemenjobdesk $manajemenjobdesk)
    {
        //
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
