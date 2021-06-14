@extends('layouts.admin')

@section('title')
    ADMIN - Layanan
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Layanan</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Daftar Layanan</li>
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
                  <h4>Daftar Layanan</h4>
                {{-- <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Layanan </a> --}}
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Gambar</th>
                                <th>Nama Layanan</th>
                                <th>Harga Jual</th>
                                <th>Kategori</th>
                                <th>Tentang Layanan</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @forelse ($layanan as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration}}</td>
                                    <td><img src="{{ asset('/img/layanan/'.$item->poto_layanan)}}" alt="" width="100px"></td>
                                    <td>{{ $item->nama_layanan}}</td>
                                    <td>{{ rupiah($item->harga_jual)}}</td>
                                    <td>{{ $item->kategori}}</td>
                                    <td>{{ $item->tentang_layanan}}</td>
                                    {{-- <td class="text-center">
                                        <a href="{{ url('/layanan/'.Crypt::encryptString($item->id))}}" class="btn btn-primary btn-sm"><i class="fas fa-file"></i></a>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="7">tidak ada data</td>
                                </tr>
                            @endforelse
                    </table>
                </div>
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

