<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manajemenlayanan;
use Illuminate\Http\Request;

class ManajemenlayananController extends Controller
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
        Manajemenlayanan::create($request->all());

        return redirect()->back()->with('ds','Manajemen Layanan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manajemenlayanan  $manajemenlayanan
     * @return \Illuminate\Http\Response
     */
    public function show(Manajemenlayanan $manajemenlayanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manajemenlayanan  $manajemenlayanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Manajemenlayanan $manajemenlayanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manajemenlayanan  $manajemenlayanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Manajemenlayanan::where('id',$request->id)->update([
            'tgl_pemesanan' => $request->tgl_pemesanan,
            'client_id' => $request->client_id,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('ds','Manajemen Layanan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manajemenlayanan  $manajemenlayanan
     * @return \Illuminate\Http\Response
     */
    public function destroy($manajemenlayanan)
    {
        Manajemenlayanan::find($manajemenlayanan)->delete();
        return redirect()->back()->with('dd','Manajemen Layanan');
    }
}
