<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaranproyek;
use Illuminate\Http\Request;

class PembayaranproyekController extends Controller
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
        if (isset($request->bukti_pembayaran)) {
            $request->validate([
                'bukti_pembayaran' => 'required|file|image|mimes:jpeg,png,jpg|max:2000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('bukti_pembayaran');
            
            $bukti_pembayaran = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'public/img/proyek';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$bukti_pembayaran);
            # code...
        } else {
            $bukti_pembayaran = NULL;
        }
    
        // simpan client
        Pembayaranproyek::create([
            'proyek_id' => $request->proyek_id,
            'nama_pembayaran' => $request->nama_pembayaran,
            'tgl_pembayaran' => $request->tgl_pembayaran,
            'nominal' => default_nilai($request->nominal),
            'bukti_pembayaran' => $bukti_pembayaran,
            'keterangan_pembayaran' => $request->keterangan_pembayaran,
        ]);

        return redirect()->back()->with('ds','Pembayaran Proyek');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaranproyek  $pembayaranproyek
     * @return \Illuminate\Http\Response
     */
    public function show(Pembayaranproyek $pembayaranproyek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaranproyek  $pembayaranproyek
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembayaranproyek $pembayaranproyek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembayaranproyek  $pembayaranproyek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pembayaranproyek   = Pembayaranproyek::find($request->id);
        if (isset($request->bukti_pembayaran)) {
            $request->validate([
                'bukti_pembayaran' => 'required|file|image|mimes:jpeg,png,jpg|max:2000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('bukti_pembayaran');
            
            $bukti_pembayaran = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'public/img/proyek';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$bukti_pembayaran);
            deletefile($tujuan_upload.'/'.$pembayaranproyek->bukti_pembayaran);
        } else {
            $bukti_pembayaran = $pembayaranproyek->bukti_pembayaran;
        }
    
        // simpan client
        Pembayaranproyek::where('id',$request->id)->update([
            'nama_pembayaran' => $request->nama_pembayaran,
            'tgl_pembayaran' => $request->tgl_pembayaran,
            'nominal' => default_nilai($request->nominal),
            'bukti_pembayaran' => $bukti_pembayaran,
            'keterangan_pembayaran' => $request->keterangan_pembayaran,
        ]);

        return redirect()->back()->with('du','Pembayaran Proyek');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaranproyek  $pembayaranproyek
     * @return \Illuminate\Http\Response
     */
    public function destroy($pembayaranproyek)
    {
        $pembayaranproyek   = Pembayaranproyek::find($pembayaranproyek);
        deletefile('img/proyek/'.$pembayaranproyek->bukti_pembayaran);
        $pembayaranproyek->delete();
        return redirect()->back()->with('dd','Pembayaran Proyek');
    }
}
