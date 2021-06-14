@extends('layouts.admin')

@section('title')
    Monitoring
@endsection
@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Monitoring</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('monitoringjobdesk')}}">Monitoring Jobdesk</a></li>
      <li class="breadcrumb-item active">Posting Jobdesk</li>
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
                <h3 class="card-title">Form untuk posting jobdesk</h3>
                {{-- <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Jobdesk </a> --}}
                {{-- <a href="{{ url('/artikel')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-print"></i> Kembali ke artikel</a> --}}
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                    <section>
                        <form action="{{ url('/simpanposting')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $monitoring->id}}">
                            <input type="hidden" name="manajemenjobdesk_id" value="{{ $monitoring->manajemenjobdesk_id}}">
                            <input type="hidden" name="status_monitoring" value="menunggu">
                            <div class="alert alert-warning">
                                <p>Form untuk jumlah, link, gambar dan dokumen disesuaikan dengan jobdesk dan digunakan untuk keperluan pencatatan jobdesk yang diselesaikan</p>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4">Jumlah (opsional)</label>
                                <input type="number" name="jumlah" class="form-control col-md-8" step="any">
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4">Link (opsional)</label>
                                <input type="url" name="link" class="form-control col-md-8">
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4">Gambar (opsional)</label>
                                <input type="file" name="gambar" class="form-control col-md-8">
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4">Dokumen (opsional)</label>
                                <input type="file" name="dokumen" class="form-control col-md-8">
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan Jobdesk (lengkapi keperluan posting di dalam keterangan)</label>
                                <textarea name="keterangan_monitoring" id="keterangan" cols="30" rows="10" required>-- isi disini --</textarea>
                            </div>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor 4
                                // instance, using default configuration.
                                CKEDITOR.replace('keterangan', {
                                width: '100%',
                                height: 200
                                });
                            </script>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i> POSTING SEKARANG</button>
                            </div>
                        </form>
                    </section>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection

