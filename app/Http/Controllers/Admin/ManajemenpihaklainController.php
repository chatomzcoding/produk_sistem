<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manajemenpihaklain;
use Illuminate\Http\Request;

class ManajemenpihaklainController extends Controller
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
        Manajemenpihaklain::create($request->all());

        return redirect()->back()->with('ds','Manajemen Pihak Lain');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manajemenpihaklain  $manajemenpihaklain
     * @return \Illuminate\Http\Response
     */
    public function show(Manajemenpihaklain $manajemenpihaklain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manajemenpihaklain  $manajemenpihaklain
     * @return \Illuminate\Http\Response
     */
    public function edit(Manajemenpihaklain $manajemenpihaklain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manajemenpihaklain  $manajemenpihaklain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Manajemenpihaklain::where('id',$request->id)->update([
            'client_id' => $request->client_id,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('du','Manajemen Pihak Lain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manajemenpihaklain  $manajemenpihaklain
     * @return \Illuminate\Http\Response
     */
    public function destroy($manajemenpihaklain)
    {
        Manajemenpihaklain::find($manajemenpihaklain)->delete();
       
        return redirect()->back()->with('dd','Manajemen Pihak Lain');
    }
}
