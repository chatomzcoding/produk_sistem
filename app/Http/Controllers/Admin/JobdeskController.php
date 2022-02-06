<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jobdesk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class JobdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobdesk    = Jobdesk::all();

        return view('admin.jobdesk.index', compact('jobdesk'));
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
        Jobdesk::create($request->all());

        return redirect()->back()->with('ds','Jobdesk');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobdesk  $jobdesk
     * @return \Illuminate\Http\Response
     */
    public function show($jobdesk)
    {
        $jobdesk        = Jobdesk::find(Crypt::decryptString($jobdesk));
        $manajemen     = DB::table('manajemen_jobdesk')
                            ->join('anggota','manajemen_jobdesk.anggota_id','=','anggota.id')
                            ->join('users','anggota.user_id','=','users.id')
                            ->select('manajemen_jobdesk.*','users.name')
                            ->where('manajemen_jobdesk.jobdesk_id','=',$jobdesk->id)
                            ->get();
        return view('admin.jobdesk.show', compact('jobdesk','manajemen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobdesk  $jobdesk
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobdesk $jobdesk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jobdesk  $jobdesk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Jobdesk::where('id',$request->id)->update([
            'kode' => $request->kode,
            'nama_jobdesk' => $request->nama_jobdesk,
            'status_jobdesk' => $request->status_jobdesk,
            'keterangan_jobdesk' => $request->keterangan_jobdesk,
            'potongan_pengeluaran' => $request->potongan_pengeluaran,
            'potongan_utama' => $request->potongan_utama,
            'matauang' => $request->matauang,
        ]);

        return redirect()->back()->with('du','Jobdesk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobdesk  $jobdesk
     * @return \Illuminate\Http\Response
     */
    public function destroy($jobdesk)
    {
        Jobdesk::find($jobdesk)->delete();

        return redirect()->back()->with('dd','Jobdesk');
    }
}
