<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manajemenproyek;
use Illuminate\Http\Request;

class ManajemenproyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        Manajemenproyek::create($request->all());

        return redirect()->back()->with('ds','Manajemen Proyek');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manajemenproyek  $manajemenproyek
     * @return \Illuminate\Http\Response
     */
    public function show(Manajemenproyek $manajemenproyek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manajemenproyek  $manajemenproyek
     * @return \Illuminate\Http\Response
     */
    public function edit(Manajemenproyek $manajemenproyek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manajemenproyek  $manajemenproyek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Manajemenproyek::where('id',$request->id)->update([
            'anggota_id' => $request->anggota_id,
            'catatan' => $request->catatan,
            'tgl_berakhir' => $request->tgl_berakhir,
            'pendapatan' => $request->pendapatan,
        ]);

        return redirect()->back()->with('du','Manajemen Proyek');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manajemenproyek  $manajemenproyek
     * @return \Illuminate\Http\Response
     */
    public function destroy($manajemenproyek)
    {
        Manajemenproyek::find($manajemenproyek)->delete();

        return redirect()->back()->with('dd','Manajemen Proyek');
    }
}
