<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Visitor::all();
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
        // save visitor ketika ada middleware ini
        // get informasi visitor
        $ipaddress      = get_client_ip_2();
        $browser        = get_client_browser();
        // $ipaddress      = $request->ip;
        // $browser        = $request->browser;
        $tglvisitor     = tgl_sekarang();

        
        // cek visitor
        $cekvisitor = Visitor::where([['tgl_visitor',$tglvisitor],['ip_address',$ipaddress]])->first();
        if ($cekvisitor) {
            // jika visitor ada, maka hits ditambahkan 1 lalu di update

            $hits   = $cekvisitor->hits + 1;
            Visitor::where('id',$cekvisitor->id)->update([
                'hits' => $hits
                ]);
            
            return response()->json([
                'message' => 'update success'
            ]);
        } else {
            // jika tidak ada maka visitor ditambahkan baru
            Visitor::create([
                'ip_address' => $ipaddress,
                'browser' => $browser,
                'hits' => 1,
                'tgl_visitor' => $tglvisitor,
            ]);

            return response()->json([
                'message' => 'create success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visitor $visitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {
        //
    }
}
