<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Layananmentoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LayananmentoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $layanan    = Layanan::find($_GET['id']);
        $mentoring  = DB::table('layanan_monitoring')
                        ->join('users','layanan_monitoring.user_id','=','users.id')
                        ->select('layanan_monitoring.*','users.name')
                        ->where('layanan_monitoring.layanan_id',$layanan->id)
                        ->orderByDesc('layanan_monitoring.id')
                        ->get();
        $user       = Auth::user();
        $total      = [
            'proses' => Layananmentoring::where('layanan_id',$layanan->id)->where('status','proses')->count(),
            'jumlah' => count($mentoring),
        ];

        return view('anggota.layananmentoring', compact('layanan','mentoring','user','total'));

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
        if (isset($request->diskusi)) {
            $layanan    = Layananmentoring::find($request->id);
            $diskusi    = [
                [
                    'nama' => $request->nama,
                    'isi' => $request->isi,
                    'photo' => $request->photo,
                    'tanggal' => $request->tanggal,

                ]
            ];
            if (!is_null($layanan->diskusi)) {
                $ddiskusi   = json_decode($layanan->diskusi,TRUE);
                $diskusi    = array_merge($ddiskusi,$diskusi);
            }
            Layananmentoring::where('id',$request->id)->update([
                'diskusi' => json_encode($diskusi)
            ]);

            return redirect()->back()->with('ds','Diskusi');
        }
        if (isset($request->gambar)) {
            $request->validate([
                'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:5000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('gambar');
            
            $gambar = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'public/img/layanan';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$gambar);
        } else {
            $gambar   = NULL;
        }
    
        // simpan client
        Layananmentoring::create([
            'layanan_id' => $request->layanan_id,
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'gambar' => $gambar,
        ]);

        return redirect()->back()->with('ds','Mentoring');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Layananmentoring  $layananmentoring
     * @return \Illuminate\Http\Response
     */
    public function show(Layananmentoring $layananmentoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Layananmentoring  $layananmentoring
     * @return \Illuminate\Http\Response
     */
    public function edit(Layananmentoring $layananmentoring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Layananmentoring  $layananmentoring
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Layananmentoring::where('id',$request->id)->update([
            'status' => $request->status
        ]);

        return back()->with('du','Diskusi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Layananmentoring  $layananmentoring
     * @return \Illuminate\Http\Response
     */
    public function destroy(Layananmentoring $layananmentoring)
    {
        //
    }
}
