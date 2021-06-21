@extends('layouts.admin')

@section('title')
    ADMIN - Jobdesk
@endsection
@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Jobdesk</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('daftarjobdesk')}}">Daftar Jobdesk</a></li>
      <li class="breadcrumb-item active">Monitoring</li>
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
                <h3 class="card-title">Monitoring Jobdesk</h3>
                {{-- <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Jobdesk </a> --}}
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                    <section>
                        <table class="table table-striped">
                            <tr>
                                <th width="20%">Nama Jobdesk</th>
                                <th class="text-capitalize">: {{ $jobdesk->nama_jobdesk}}</th>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <th class="text-capitalize">: {{ $jobdesk->keterangan_jobdesk}} <br> &nbsp; <small>{{$manajemen->catatan}}</small></th>
                            </tr>
                            <tr>
                                <th>Total Jumlah</th>
                                <th class="text-capitalize">: {{ $total}}</th>
                            </tr>
                        </table>
                    </section>
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead class="text-center table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Status Monitoring</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @forelse ($monitoring as $item)
                            <tr class=" @if ($item->created_at->format('d') <> ambil_tgl()) table-secondary @endif">
                                    <td class="text-center">{{ $loop->iteration}}</td>
                                    <td>{{ date_indo($item->created_at->format('Y-m-d'))}}</td>
                                    <td>{!! $item->keterangan_monitoring!!}</td>
                                    <td class="text-center">{{ $item->jumlah}}</td>
                                    <td class="text-center">
                                        @if ($item->created_at->format('d') == ambil_tgl())
                                            @switch($item->status_monitoring)
                                                @case('proses')
                                                    <a href="{{ url('/posting/'.Crypt::encryptString($item->id))}}" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i> posting</a>
                                                    @break
                                                @case('revisi')
                                                <a href="{{ url('/posting/'.Crypt::encryptString($item->id).'/edit')}}" class="btn btn-danger btn-sm"><i class="fas fa-pen"></i> revisi</a>
                                                    @break
                                                @case('menunggu')
                                                <a href="{{ url('/posting/'.Crypt::encryptString($item->id).'/edit')}}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                                    @break
                                                @case('selesai')
                                                <span class="badge badge-success">Jobdesk Selesai</span>
                                                    @break
                                                @case('gagal')
                                                <span class="badge badge-danger">Jobdesk Gagal</span>
                                                    @break
                                                @default
                                            @endswitch
                                        @else
                                            @switch($item->status_monitoring)
                                                @case('revisi')
                                                <a href="{{ url('/posting/'.Crypt::encryptString($item->id).'/edit')}}" class="btn btn-danger btn-sm"><i class="fas fa-pen"></i> revisi</a>
                                                    @break
                                                @case('menunggu')
                                                <a href="{{ url('/posting/'.Crypt::encryptString($item->id).'/edit')}}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                                    @break
                                                @case('selesai')
                                                <span class="badge badge-success">Jobdesk Selesai</span>
                                                    @break
                                                @case('proses')
                                                <span class="badge badge-danger">waktu habis</span>
                                                    @break
                                                @case('gagal')
                                                <span class="badge badge-danger">Maaf gagal</span>
                                                    @break
                                                @default

                                            @endswitch
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">tidak ada data</td>
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

