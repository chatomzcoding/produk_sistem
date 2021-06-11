<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Client;
use App\Models\Manajemenproyek;
use App\Models\Pembayaranproyek;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyek     = Proyek::all();
        $client     = Client::all();
        return view('admin.proyek.index', compact('proyek','client'));
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
        if (isset($request->gambar)) {
            $request->validate([
                'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:5000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('gambar');
            
            $gambar = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'img/proyek';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$gambar);
        } else {
            $gambar = NULL;
        }
        
        // simpan client
        Proyek::create([
            'client_id' => $request->client_id,
            'nama_proyek' => $request->nama_proyek,
            'tgl_dimulai' => $request->tgl_dimulai,
            'tgl_berakhir' => $request->tgl_berakhir,
            'status_proyek' => $request->status_proyek,
            'level_proyek' => $request->level_proyek,
            'biaya' => default_nilai($request->biaya),
            'link' => $request->link,
            'gambar' => $gambar,
            'detail_proyek' => $request->detail_proyek,
        ]);

        return redirect()->back()->with('ds','Proyek');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function show($proyek)
    {
        $proyek         = Proyek::find(Crypt::decryptString($proyek));
        $manajemenproyek= DB::table('manajemen_proyek')
                            ->join('anggota','manajemen_proyek.anggota_id','=','anggota.id')
                            ->join('users','anggota.user_id','=','users.id')
                            ->select('manajemen_proyek.*','users.name')
                            ->where('manajemen_proyek.proyek_id',$proyek->id)
                            ->get();
        $manajemenpihaklain= DB::table('manajemen_pihaklain')
                            ->join('client','manajemen_pihaklain.client_id','=','client.id')
                            ->select('manajemen_pihaklain.*','client.nama')
                            ->where('manajemen_pihaklain.proyek_id',$proyek->id)
                            ->get();
        $anggota        = DB::table('anggota')
                            ->join('users','anggota.user_id','=','users.id')
                            ->select('anggota.id','users.name')
                            ->get();
        $pihaklain         = Client::where('level','pihaklain')->get();
        $pembayaran     = Pembayaranproyek::where('proyek_id',$proyek->id)->get();
        return view('admin.proyek.show', compact('proyek','manajemenproyek','anggota','pembayaran','manajemenpihaklain','pihaklain'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyek $proyek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $proyek     = Proyek::find($request->id);
        if (isset($request->gambar)) {
            $request->validate([
                'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:5000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('gambar');
            
            $gambar = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'img/proyek';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$gambar);
            deletefile($tujuan_upload.'/'.$proyek->gambar);
        } else {
            $gambar     = $proyek->gambar;
        }
        
    
        // simpan client
        Proyek::where('id',$proyek->id)->update([
            'client_id' => $request->client_id,
            'nama_proyek' => $request->nama_proyek,
            'tgl_dimulai' => $request->tgl_dimulai,
            'tgl_berakhir' => $request->tgl_berakhir,
            'status_proyek' => $request->status_proyek,
            'level_proyek' => $request->level_proyek,
            'biaya' => default_nilai($request->biaya),
            'link' => $request->link,
            'gambar' => $gambar,
            'detail_proyek' => $request->detail_proyek,
        ]);

        return redirect()->back()->with('du','Proyek');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function destroy($proyek)
    {
        $proyek     = Proyek::find($proyek);

        $tujuan_upload = 'img/proyek';
        deletefile($tujuan_upload.'/'.$proyek->gambar);
        $proyek->delete();

        return redirect()->back()->with('dd','Proyek');
    }
}
