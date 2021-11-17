<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client     = Client::where('level','client')->get();
        return view('admin.client.index', compact('client'));
    }

    public function pihaklain()
    {
        $pihaklain     = Client::where('level','pihaklain')->get();
        return view('admin.pihaklain.index', compact('pihaklain'));
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
        if (isset($request->poto)) {
            $request->validate([
                'poto' => 'required|file|image|mimes:jpeg,png,jpg|max:2000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('poto');
            
            $poto = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'public/img/client';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$poto);
        } else {
            $poto   = NULL;
        }
    
        // simpan client
        Client::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'poto' => $poto,
            'tentang' => $request->tentang,
            'level' => $request->level,
        ]);

        return redirect()->back()->with('ds','Client');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $client     = Client::find($request->id);
        if (isset($request->poto)) {
            $request->validate([
                'poto' => 'required|file|image|mimes:jpeg,png,jpg|max:2000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('poto');
            
            $poto = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'public/img/client';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$poto);
            deletefile($tujuan_upload.'/'.$client->poto);    

        } else {
            $poto   = $client->poto;
        }
        
        // simpan client
        Client::where('id',$client->id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'tentang' => $request->tentang,
            'poto' => $poto,
        ]);

        return redirect()->back()->with('du','Client');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($client)
    {
        $client     = Client::find($client);

        deletefile('img/client/'.$client->poto);
        $client->delete();

        return redirect()->back()->with('dd','Client');
    }
}
