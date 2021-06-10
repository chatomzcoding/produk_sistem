<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Layanan;
use App\Models\Manajemenlayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $layanan    = Layanan::all();

        return view('admin.layanan.index', compact('layanan'));
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
            'poto_layanan' => 'required|file|image|mimes:jpeg,png,jpg|max:5000',
        ]);
        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('poto_layanan');
        
        $poto_layanan = time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'img/layanan';
        // isi dengan nama folder tempat kemana file diupload
        $file->move($tujuan_upload,$poto_layanan);
    
        // simpan client
        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'harga_beli' => default_nilai($request->harga_beli),
            'harga_jual' => default_nilai($request->harga_jual),
            'kategori' => $request->kategori,
            'link' => $request->link,
            'poto_layanan' => $poto_layanan,
            'tentang_layanan' => $request->tentang_layanan,
        ]);

        return redirect()->back()->with('ds','Layanan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function show($layanan)
    {
        $layanan    = Layanan::find(Crypt::decryptString($layanan));
        $manajemen  = DB::table('manajemen_layanan')
                        ->join('client','manajemen_layanan.client_id','=','client.id')
                        ->select('manajemen_layanan.*','client.nama')
                        ->where('manajemen_layanan.layanan_id',$layanan->id)
                        ->orderBy('manajemen_layanan.tgl_pemesanan','desc')
                        ->get();
        $client     = Client::all();
        return view('admin.layanan.show', compact('layanan','manajemen','client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Layanan $layanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $layanan    = Layanan::find($request->id);
        if (isset($request->poto_layanan)) {
            $request->validate([
                'poto_layanan' => 'required|file|image|mimes:jpeg,png,jpg|max:5000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('poto_layanan');
            
            $poto_layanan = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'img/layanan';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$poto_layanan);
            deletefile($tujuan_upload.'/'.$layanan->poto_layanan);
        } else {
            $poto_layanan = $layanan->poto_layanan;
        }
        
    
        // simpan client
        Layanan::where('id',$request->id)->update([
            'nama_layanan' => $request->nama_layanan,
            'harga_beli' => default_nilai($request->harga_beli),
            'harga_jual' => default_nilai($request->harga_jual),
            'kategori' => $request->kategori,
            'link' => $request->link,
            'poto_layanan' => $poto_layanan,
            'tentang_layanan' => $request->tentang_layanan,
        ]);

        return redirect()->back()->with('du','Layanan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function destroy($layanan)
    {
        $layanan = Layanan::find($layanan);
        deletefile('img/layanan/'.$layanan->poto_layanan);
        $layanan->delete();
        return redirect()->back()->with('dd','Layanan');
    }
}
