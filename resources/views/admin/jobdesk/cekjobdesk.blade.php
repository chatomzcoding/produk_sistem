@extends('layouts.admin')

@section('title')
    Monitoring - Cek proggres
@endsection
@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Monitoring</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('admin/monitoringjobdesk')}}">Monitoring Jobdesk</a></li>
      <li class="breadcrumb-item active">Pengecekan Jobdesk</li>
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Form evaluasi jobdesk</h3>
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                    <section>
                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <tr>
                            <th>Nama Jobdesk</th>
                            <td class="text-capitalize">: {{ $jobdesk->nama_jobdesk}}</td>
                          </tr>
                          <tr>
                            <th>Keterangan</th>
                            <td class="text-capitalize">: {{ $jobdesk->keterangan_jobdesk}} <br>&nbsp; <small>{{ $manajemenjobdesk->catatan}}</small></td>
                          </tr>
                          <tr>
                            <th>Tingkatan</th>
                            <td class="text-uppercase">: {{ $manajemenjobdesk->tingkatan}} <br>&nbsp;  @if ($manajemenjobdesk->tingkatan == 'kondisional')
                                {{ date_indo($manajemenjobdesk->tgl_awal).' - '.date_indo($manajemenjobdesk->tgl_akhir)}}
                            @endif</td>
                          </tr>
                        </table>
                      </div>
                      <hr>
                        <form action="{{ url('/simpanposting')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $monitoring->id}}">
                            <input type="hidden" name="manajemenjobdesk_id" value="{{ $monitoring->manajemenjobdesk_id}}">
                            <div class="alert alert-warning">
                                <p>Form untuk jumlah, link, gambar dan dokumen disesuaikan dengan jobdesk dan digunakan untuk keperluan pencatatan jobdesk yang diselesaikan</p>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4">Jumlah</label>
                                <div class="col-md-8">
                                  : {{ $monitoring->jumlah}}
                                </div>
                                <input type="hidden" name="jumlah" class="form-control col-md-8" value="{{ $monitoring->jumlah}}">
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4">Link</label>
                                <div class="col-md-8">
                                  : <a href="{{ $monitoring->link}}" target="_blank">{{ $monitoring->link}}</a> 
                                </div>
                                <input type="hidden" name="link" class="form-control col-md-8" value="{{ $monitoring->link}}">
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="">Gambar </label>
                                  </div>
                                  <div class="col-md-8">
                                    @if (!is_null($monitoring->gambar))
                                        <img src="{{ asset('img/monitoring/'.$monitoring->gambar)}}" alt="" class="img-fluid">
                                    @else 
                                      <p>: tidak ada gambar</p>
                                    @endif
                                  </div>
                                
                                <input type="hidden" name="gambar" class="form-control col-md-8">
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="">Dokumen</label> <br>
                                </div>
                                <div class="col-md-8">
                                  @if (!is_null($monitoring->dokumen))
                                  <a href="{{ asset('img/monitoring/'.$monitoring->dokumen)}}" target="_blank">lihat dokumen</a>
                                @else
                                    <p>: tidak ada dokumen</p>
                                  @endif
                                </div>
                                <input type="hidden" name="dokumen" class="form-control col-md-8">
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan Jobdesk (Berikan komentar dibawah ini jika diperlukan)</label>
                                <textarea name="keterangan_monitoring" id="keterangan" cols="30" rows="10">{{ $monitoring->keterangan_monitoring}}</textarea>
                            </div>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor 4
                                // instance, using default configuration.
                                CKEDITOR.replace('keterangan', {
                                width: '100%',
                                height: 200
                                });
                            </script>
                            <div class="form-group row">
                              <label for="" class="col-md-4">Beri Status Jobdesk</label>
                              <select name="status_monitoring" id="" class="form-control col-md-8">
                                @foreach (list_statusmonitoring() as $item)
                                  @if ($item <> 'proses' AND $item <> 'menunggu')
                                    <option value="{{ $item}}" @if ($item == $monitoring->status_monitoring)
                                        selected
                                    @endif>{{ $item}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                            {{-- kode untuk pengecekan keuangan --}}
                            @if (!is_null($jobdesk->potongan_pengeluaran) || !is_null($jobdesk->potongan_utama))
                            <input type="hidden" name="anggota_id" value="{{ $anggota->id}}">
                            <input type="hidden" name="keterangan_rekening" value="pemasukan dari jobdesk bulanan {{ $jobdesk->nama_jobdesk}}">
                            <input type="hidden" name="keterangan_rekeningadmin" value="pemasukan dari jobdesk bulanan {{ $jobdesk->nama_jobdesk.' - '.$user->name}}">
                            <input type="hidden" name="status" value="debit">
                            <div class="alert alert-warning">
                              Setelah di konfirmasi (selesai), Maka sistem akan otomatis melakukan perhitungan berdasarkan pengaturan jobdesk (potongan pengeluaran dan potongan utama) <br>
                              dibawah ini perhitungan dari jobdesk tersebut
                            </div>
                            <div class="form-group row">
                              <div class="col-md-4">
                                  <label for="">Mata Uang <strong class="text-danger">*</strong> </label>
                              </div>
                              <div class="col-md-8 p-0">
                                <select name="matauang" id="" class="form-control" required>
                                  <option value="">-- pilih mata uang --</option>
                                  @foreach (list_matauang() as $item)
                                      <option value="{{ $item}}" @if ($jobdesk->matauang == $item)
                                          selected
                                      @endif>{{ $item}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-md-4">
                                  <label for="">Pemotongan Pengeluaran</label> <br>
                              </div>
                              <div class="col-md-8 p-0">
                                <input type="number" name="potongan_pengeluaran" class="form-control" step="any" value="{{ $jobdesk->potongan_pengeluaran}}">
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-md-4">
                                  <label for="">Pemotongan Utama (bagi hasil)</label> <br>
                              </div>
                              <div class="col-md-8 p-0">
                                <input type="number" class="form-control" name="potongan_utama" min="0" max="100" value="{{ $jobdesk->potongan_utama}}">
                                <small>hasil dikali persentase</small>
                              </div>
                            </div>
                            @endif
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i> KONFIRMASI JOBDESK</button>
                            </div>
                        </form>
                    </section>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection

