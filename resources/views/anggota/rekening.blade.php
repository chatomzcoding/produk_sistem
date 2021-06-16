@extends('layouts.admin')

@section('title')
    ADMIN - Rekening
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Rekening</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Daftar Rekening Anggota</li>
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
              <div class="card-header text-right">
                {{-- <h3 class="card-title">Daftar Unit</h3> --}}
                <button class="btn btn-success">{{ rupiah(DbSistem::rekeninganggota($anggota->id,'IDR'))}}</button>
                <button class="btn btn-primary">USD $ {{ DbSistem::rekeninganggota($anggota->id,'USD')}}</button>
                {{-- <a href="{{ url('/artikel')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-print"></i> Kembali ke artikel</a> --}}
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Mata Uang</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @forelse ($rekening as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration}}</td>
                                    <td>{{ $item->created_at}}</td>
                                    <td class="text-center">{{ $item->status}}</td>
                                    <td class="text-center">{{ $item->matauang}}</td>
                                    <td class="text-right">{{ $item->nominal}}</td>
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

