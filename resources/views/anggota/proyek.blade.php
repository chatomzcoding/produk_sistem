@extends('layouts.admin')

@section('title')
    Daftar Proyek
@endsection
@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Proyek</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Daftar Proyek</li>
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->
@endsection
@section('content')
    <div class="container-fluid">
        @include('sistem.notifikasi')
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Proyek yang dikerjakan</h3>
              </div>
              <div class="card-body">
                  <section class="row">
                    <div class="col-md-12">
                        <div class="row">
                            @foreach ($proyek as $item)

                                <div class="col-md-4 card-group">
                                    <div class="card mb-3">
                                        <div class="row no-gutters">
                                          <div class="col-md-4 p-2">
                                            @if (is_null($item->gambar))
                                                <img src="{{ asset('/img/img-proyek.png')}}" class="card-img">
                                            @else
                                                <img src="{{ asset('/img/proyek/'.$item->gambar)}}" class="card-img rounded">
                                            @endif
                                          </div>
                                          <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title text-capitalize"><a href="{{ url('detailproyek/'.Crypt::encryptString($item->id)) }}">{{ $item->nama_proyek}}</a></h5>
                                                <p class="card-text text-justify small">{{ $item->detail_proyek}}</p><hr>
                                              <p class="card-text"><small class="text-muted">status proyek {!! status_proyek($item->status_proyek)!!}</small></p>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                  </section>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Proyek Lainnya</h3>
                {{-- <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Jobdesk </a> --}}
                {{-- <a href="{{ url('/artikel')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-print"></i> Kembali ke artikel</a> --}}
              </div>
              <div class="card-body">
                  <section class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Proyek</th>
                                        <th>Waktu Pelaksanaan</th>
                                        <th>Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-capitalize">
                                    @forelse ($daftarproyek as $item)
                                    <tr>
                                            <td class="text-center">{{ $loop->iteration}}</td>
                                            <td>{{ $item->nama_proyek}}</td>
                                            <td>{{ date_indo($item->tgl_dimulai).' - '.date_indo($item->tgl_berakhir)}}</td>
                                            <td class="text-center">{!! status_proyek($item->status_proyek)!!}</td>
                                            <td><a href="{{ url('/detailproyek/'.Crypt::encryptString($item->id))}}" class="btn btn-primary btn-sm btn-block">Selengkapnya</a></td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="6">tidak ada data</td>
                                        </tr>
                                    @endforelse
                            </table>
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

