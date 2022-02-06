@extends('layouts.admin')

@section('title')
    STATISTK - SHUTTERSTOCK
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Shutterstock</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Statistik Shutterstock</li>
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
                <h3 class="card-title">Statistik ShutterStock</h3>
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                  @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <section>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                            
                                        <div class="info-box-content">
                                          <span class="info-box-text">Total Keseluruhan <span class="float-right">({{ $data['total']['akun'] }} akun)</span></span>
                                          <span class="info-box-number">${{ $data['total']['nilai'].' | '.$data['total']['rp']}}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                      </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                            
                                        <div class="info-box-content">
                                          <span class="info-box-text">Total Pencairan <span class="float-right">({{ $data['perhitungan']['akun'] }} akun)</span></span>
                                          <span class="info-box-number">${{ $data['perhitungan']['nilai'].' | '.$data['perhitungan']['rp']}}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                      </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                                        <div class="info-box-content">
                                          <span class="info-box-text">Sisa dari pencairan  <span class="float-right">({{ $data['sisa']['akun'] }} akun)</span></span>
                                          <span class="info-box-number">${{ $data['sisa']['nilai'].' | '.$data['sisa']['rp']}}</span>

                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user"></i></span>
                                        <div class="info-box-content">
                                          <span class="info-box-text">Akun Banned</span>
                                          <span class="info-box-number">{{ $data['akunbanned']}}</span>

                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <p>Pengaturan Dasar</p>
                                    <form action="" method="get">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Nilai 1 Dollar ke Rupiah</label>
                                            <input type="number" name="dr" value="{{ $data['dr'] }}" placeholder="rubah margin rupiah disini" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Batas minimal pencarian</label>
                                            <input type="number" name="batas" value="{{ $data['batas'] }}" placeholder="batas pencarian" class="form-control">
                                        </div>
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> SIMPAN PENGATURAN</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection
@section('script')
    
    <script>
        $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        });
    </script>
@endsection

