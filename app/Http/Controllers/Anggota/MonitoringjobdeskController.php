<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Manajemenjobdesk;
use App\Models\Monitoringjobdesk;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class MonitoringjobdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota    = Anggota::where('user_id',Auth::user()->id)->first();
        $jobdesk    = DB::table('monitoring_jobdesk')
                        ->join('manajemen_jobdesk','monitoring_jobdesk.manajemenjobdesk_id','=','manajemen_jobdesk.id')
                        ->join('jobdesk','manajemen_jobdesk.jobdesk_id','=','jobdesk.id')
                        ->where('manajemen_jobdesk.anggota_id',$anggota->id)
                        ->where('manajemen_jobdesk.tingkatan','harian')
                        ->where('manajemen_jobdesk.skala_prioritas','<>','sembunyikan')
                        ->whereDate('monitoring_jobdesk.created_at',tgl_sekarang())
                        ->select('monitoring_jobdesk.*','jobdesk.nama_jobdesk','jobdesk.keterangan_jobdesk','manajemen_jobdesk.catatan')
                        ->orderBy('monitoring_jobdesk.jumlah','ASC')
                        ->get();
        $jobdeskbulanan    = DB::table('monitoring_jobdesk')
                        ->join('manajemen_jobdesk','monitoring_jobdesk.manajemenjobdesk_id','=','manajemen_jobdesk.id')
                        ->join('jobdesk','manajemen_jobdesk.jobdesk_id','=','jobdesk.id')
                        ->where('manajemen_jobdesk.anggota_id',$anggota->id)
                        ->where('manajemen_jobdesk.tingkatan','bulanan')
                        ->whereMonth('monitoring_jobdesk.created_at',ambil_bulan())
                        ->select('monitoring_jobdesk.*','jobdesk.nama_jobdesk','jobdesk.keterangan_jobdesk','manajemen_jobdesk.catatan')
                        ->get();
        $jobdeskondisional    = DB::table('monitoring_jobdesk')
                                ->join('manajemen_jobdesk','monitoring_jobdesk.manajemenjobdesk_id','=','manajemen_jobdesk.id')
                                ->join('jobdesk','manajemen_jobdesk.jobdesk_id','=','jobdesk.id')
                                ->where('manajemen_jobdesk.anggota_id',$anggota->id)
                                ->where('manajemen_jobdesk.tingkatan','kondisional')
                                ->where('manajemen_jobdesk.tgl_awal','<=',tgl_sekarang())
                                ->where('manajemen_jobdesk.tgl_akhir','>=',tgl_sekarang())
                                // ->where('monitoring_jobdesk.status_monitoring','<>','selesai')
                                ->select('monitoring_jobdesk.*','jobdesk.nama_jobdesk','jobdesk.keterangan_jobdesk','manajemen_jobdesk.catatan','manajemen_jobdesk.tgl_awal','manajemen_jobdesk.tgl_akhir')
                                ->get();
        $listjobdesk = Manajemenjobdesk::where('anggota_id',$anggota->id)->where('tingkatan','harian')->where('skala_prioritas','<>','sembunyikan')->get();
        $listjobdeskbulanan = Manajemenjobdesk::where('anggota_id',$anggota->id)->where('tingkatan','bulanan')->get();
        $listjobdeskondisional = Manajemenjobdesk::where('anggota_id',$anggota->id)->where('tingkatan','kondisional')->where('manajemen_jobdesk.tgl_awal','<=',tgl_sekarang())->where('manajemen_jobdesk.tgl_akhir','>=',tgl_sekarang())->get();
        return view('anggota.monitoring.index', compact('jobdesk','listjobdesk','anggota','jobdeskbulanan','listjobdeskbulanan','jobdeskondisional','listjobdeskondisional'));
    }

    public function posting($id)
    {
        $monitoring = Monitoringjobdesk::find(Crypt::decryptString($id));

        return view('anggota.monitoring.posting', compact('monitoring'));
    }
    public function postingedit($id)
    {
        $monitoring = Monitoringjobdesk::find(Crypt::decryptString($id));

        return view('anggota.monitoring.postingedit', compact('monitoring'));
    }

    public function simpanposting(Request $request)
    {
        $monitoringjobdesk  = Monitoringjobdesk::find($request->id);
        if (isset($request->gambar)) {
            $request->validate([
                'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:5000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('gambar');
            
            $gambar = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'img/monitoring';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$gambar);
            deletefile($tujuan_upload.'/'.$monitoringjobdesk->gambar);
        } else {
            $gambar     = $monitoringjobdesk->gambar;
        }
        if (isset($request->dokumen)) {
            $request->validate([
                'dokumen' => 'required|file|mimes:pdf|max:5000',
            ]);
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('dokumen');
            
            $dokumen = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'img/monitoring';
            // isi dengan nama folder tempat kemana file diupload
            $file->move($tujuan_upload,$dokumen);
            deletefile($tujuan_upload.'/'.$monitoringjobdesk->dokumen);
        } else {
            $dokumen     = $monitoringjobdesk->dokumen;
        }
        
    
        Monitoringjobdesk::where('id',$request->id)->update([
            'status_monitoring' => $request->status_monitoring,
            'jumlah' => $request->jumlah,
            'link' => $request->link,
            'keterangan_monitoring' => $request->keterangan_monitoring,
            'gambar' => $gambar,
            'dokumen' => $dokumen,
        ]);

        // pengecekan
        if (Auth::user()->level == 'admin') {
            // jika adanya perhitungan keuangan
            if (isset($request->anggota_id) AND $request->status_monitoring == 'selesai' AND $request->jumlah > 0) {
                $nominal    = $request->jumlah;
                // cek potongan_pengeluaran
                if (isset($request->potongan_pengeluaran)) {
                    $nominal    = $nominal - $request->potongan_pengeluaran;
                }
                // cek potongan_utama
                if (isset($request->potongan_utama)) {
                    $potongan   = $nominal * ($request->potongan_utama/100);
                    $nominal    = $nominal - $potongan;
                    // simpan ke rekening cikara studio
                    $admin      = Anggota::where('user_id',1)->first();
                    Rekening::create([
                        'anggota_id' => $admin->id,
                        'status' => $request->status,
                        'matauang' => $request->matauang,
                        'keterangan_rekening' => $request->keterangan_rekeningadmin,
                        'nominal' => $potongan,
                    ]);
                }
                // simpan ke rekening anggota
                Rekening::create([
                    'anggota_id' => $request->anggota_id,
                    'status' => $request->status,
                    'matauang' => $request->matauang,
                    'keterangan_rekening' => $request->keterangan_rekening,
                    'nominal' => $nominal,
                ]);
            }
            return redirect('admin/monitoringjobdesk')->with('success','Jobdesk sudah konfirmasi');
        } else {
            return redirect('monitoringjobdesk')->with('success','Jobdesk sudah diposting');
        }
        

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
        $manajemenjobdesk   = Manajemenjobdesk::where('tingkatan',$request->tingkatan)->where('anggota_id',$request->anggota_id)->get();

        foreach ($manajemenjobdesk as $item) {
            // cek jika sudah ditambahkan sebelumnya
            $cek    = Monitoringjobdesk::where('manajemenjobdesk_id',$item->id)->whereDate('created_at',tgl_sekarang())->first();
            if (!$cek) {
                // simpan monitoring
                Monitoringjobdesk::create([
                    'manajemenjobdesk_id' => $item->id,
                    'keterangan_monitoring' => 'tambahkan keterangan',
                    'status_monitoring' => 'proses',
                ]);
            }
        }

        return redirect()->back()->with('success','Jobdesk berhasil diambil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monitoringjobdesk  $monitoringjobdesk
     * @return \Illuminate\Http\Response
     */
    public function show(Monitoringjobdesk $monitoringjobdesk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Monitoringjobdesk  $monitoringjobdesk
     * @return \Illuminate\Http\Response
     */
    public function edit(Monitoringjobdesk $monitoringjobdesk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Monitoringjobdesk  $monitoringjobdesk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Monitoringjobdesk $monitoringjobdesk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monitoringjobdesk  $monitoringjobdesk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Monitoringjobdesk $monitoringjobdesk)
    {
        //
    }
}
