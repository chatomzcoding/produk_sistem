@extends('layouts.admin')

@section('title')
    Daftar Proyek - Proyek Detail
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Proyek</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('daftarproyek')}}">Daftar Proyek</a></li>
      <li class="breadcrumb-item active">Detail Proyek</li>
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
                  {{-- <h3 class="card-title">Proyek {{ $proyek->nama_proyek}}</h3> --}}
                  <a href="{{ url('/daftarproyek')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-angle-left"></i> Kembali</a>
                {{-- <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Proyek </a> --}}
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                <div class="row">
                    <div class="col-md-4">
                        <section class="container">
                            @if (is_null($proyek->gambar))
                                <img src="{{ asset('/img/img-proyek.png')}}" alt="" class="img-fluid" width="100%">
                            @else
                                <img src="{{ asset('/img/proyek/'.$proyek->gambar)}}" alt="" class="img-fluid">
                            @endif
                        </section>
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>Nama Proyek</th>
                                        <td class="text-capitalize">: {{ $proyek->nama_proyek}}</td>
                                    </tr>
                                    <tr>
                                        <th>Masa Pelaksanaan</th>
                                        <td>: {{ date_indo($proyek->tgl_dimulai).' - '.date_indo($proyek->tgl_berakhir)}}</td>
                                    </tr>
                                    {{-- <tr>
                                        <th>Biaya</th>
                                        <td>: {{ rupiah($proyek->biaya)}}</td>
                                    </tr> --}}
                                    <tr>
                                        <th>Level Proyek</th>
                                        <td>: {{ $proyek->level_proyek}}</td>
                                    </tr>
                                    <tr>
                                        <th>Detail Proyek</th>
                                        <td>: {{ $proyek->detail_proyek}}</td>
                                    </tr>
                                    <tr>
                                        <th>Link</th>
                                        <td>: <a href="{{ $proyek->link}}" target="_blank">{{ $proyek->link}}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Status Proyek</th>
                                        <td>: {!! status_proyek($proyek->status_proyek)!!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- manajemen proyek --}}
                @if ($anggota->status_anggota == 'anggota')
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <hr>
                            <div class="card">
                                <div class="card-header">
                                    <strong>Manajemen Proyek</strong>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center table-dark">
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Nama Tim</th>
                                                    <th>Batas Pengerjaan</th>
                                                    <th>Catatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($manajemenproyek as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration}}</td>
                                                    <td class="text-capitalize">{{ $item->name}}</td>
                                                    <td>{{ date_indo($item->tgl_berakhir)}}</td>
                                                    <td>{{ $item->catatan}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- end manajemen proyek --}}
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

