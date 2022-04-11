<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $s      = (isset($_GET['s'])) ? $_GET['s'] : 'index' ;
        $jumlah = (isset($_GET['jumlah'])) ? $_GET['jumlah'] : 10 ;
        if ($s <> 'index') {
            if ($s == 'paket') {
                Paket::where('id',$_GET['id'])->update([
                    'status' => 'aktif'
                ]);
            } else {
                Paket::where('id',$_GET['id'])->update([
                    'status' => 'tidak aktif'
                ]);
            }
            
        }
        $paket  = Paket::where('status','aktif')->get();
        $totalpaket     = Paket::where('status','aktif')->sum('harga');
        $nonpaket  = Paket::where('status','tidak aktif')->get();
        $totalnonpaket     = Paket::where('status','tidak aktif')->sum('harga');
        $total      = $jumlah * $totalpaket;
        $total = [
            'paket' => $totalpaket,
            'nonpaket' => $totalnonpaket,
            'total' => $total,
        ];
        return view('paket', compact('paket','nonpaket','total','jumlah'));
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
            $request->validate([
                'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:5000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('gambar');
            
            $gambar = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'public/img/paket';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$gambar);
        
        // simpan client
        Paket::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'gambar' => $gambar,
        ]);

        return back()->with('ds','Paket');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function show(Paket $paket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function edit(Paket $paket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paket $paket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paket $paket)
    {
        deletefile('public/img/paket/'.$paket->gambar);
        $paket->delete();
        return back()->with('dd','Paket');
    }
}
