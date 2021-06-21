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
      <li class="breadcrumb-item"><a href="{{ url('jobdesk')}}">Daftar Jobdesk</a></li>
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
                        <table class="table">
                            <tr>
                                <th width="20%">Nama Anggota</th>
                                <th>: {{ $user->name}}</th>
                            </tr>
                            <tr>
                                <th>Nama Jobdesk</th>
                                <th>: {{ $jobdesk->nama_jobdesk}}</th>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <th>: {{ $jobdesk->keterangan_jobdesk}} <br> &nbsp; <small>{{$manajemen->catatan}}</small></th>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <th>: {{ $total}}</th>
                            </tr>
                        </table>
                    </section>
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Status Monitoring</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @forelse ($monitoring as $item)
                            <tr>
                                    <td class="text-center">{{ $loop->iteration}}</td>
                                    <td>{{ $item->created_at}}</td>
                                    <td>{!! $item->keterangan_monitoring!!}</td>
                                    <td>{{ $item->jumlah}}</td>


                                        @switch($item->status_monitoring)
                                        @case('proses')
                                            <td>
                                                <span class="badge badge-warning w-100">DALAM PROSES PENGERJAAN</span>
                                            </td>
                                            <td><a href="{{ url('admin/cekjobdesk/'.Crypt::encryptString($item->id))}}"  target="_blank" class="btn btn-danger btn-sm">batalkan</a></td>
                                            @break
                                        @case('selesai')
                                            <td>
                                                <span class="badge badge-success w-100">JOBDESK SELESAI</span>
                                            </td>
                                            <td></td>
                                            @break
                                        @case('revisi')
                                            <td>
                                                <span class="badge badge-danger w-100">PROSES REVISI</span>
                                            </td>
                                            <td></td>
                                            @break
                                        @case('menunggu')
                                            <td>
                                                <span class="badge badge-secondary w-100">MENUNGGU PENGECEKAN</span>
                                            </td>
                                            <td><a href="{{ url('admin/cekjobdesk/'.Crypt::encryptString($item->id))}}" target="_blank" class="btn btn-success btn-sm">cek proggres</a></td>
                                            @break
                                        @default
                                    @endswitch
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

