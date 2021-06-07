@extends('layouts.admin')

@section('title')
    ADMIN - Proyek Detail
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Proyek</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('proyek')}}">Daftar Proyek</a></li>
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
                  <a href="{{ url('/proyek')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-angle-left"></i> Kembali</a>
                {{-- <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Proyek </a> --}}
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
                <div class="row">
                    <div class="col-md-4">
                        <section class="container">
                            <img src="{{ asset('/img/proyek/'.$proyek->gambar)}}" alt="" class="img-fluid">
                        </section>
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>Nama Proyek</th>
                                        <td>: {{ $proyek->nama_proyek}}</td>
                                    </tr>
                                    <tr>
                                        <th>Masa Pelaksanaan</th>
                                        <td>: {{ date_indo($proyek->tgl_dimulai).' - '.date_indo($proyek->tgl_berakhir)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Biaya</th>
                                        <td>: {{ rupiah($proyek->biaya)}}</td>
                                    </tr>
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
                                        <td>: {{ $proyek->status_proyek}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- manajemen proyek --}}
                <div class="row mt-2">
                    <div class="col-md-12">
                        <hr>
                        <div class="card">
                            <div class="card-header">
                                <strong>Manajemen Proyek</strong>
                                <a href="#" class="btn btn-outline-primary btn-flat btn-sm float-right" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Tim </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Nama Tim</th>
                                                <th>Catatan</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($manajemenproyek as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration}}</td>
                                                <td>{{ $item->name}}</td>
                                                <td>{{ $item->catatan}}</td>
                                                <td class="text-center">
                                                    <form id="data2-{{ $item->id }}" action="{{ url('/manajemenproyek/'.$item->id)}}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        </form>
                                                    <button type="button" data-toggle="modal" data-anggota_id="{{ $item->anggota_id }}" data-catatan="{{ $item->catatan }}" data-id="{{ $item->id }}" data-target="#ubah" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button onclick="deleteRow2( {{ $item->id }} )" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end manajemen proyek --}}
                {{-- pembayaran proyek --}}
                <div class="row mt-2">
                    <div class="col-md-12">
                        <hr>
                        <div class="card">
                            <div class="card-header">
                                <strong>Pembayaran Proyek</strong>
                                <a href="#" class="btn btn-outline-primary btn-flat btn-sm float-right" data-toggle="modal" data-target="#tambahpembayaran"><i class="fas fa-plus"></i> Tambah Pembayaran </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Aksi</th>
                                                <th>Tanggal Pembayaran</th>
                                                <th>Nama Pembayaran</th>
                                                <th>Bukti Pembayaran</th>
                                                <th>Keterangan</th>
                                                <th>Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalpembayaran = 0;
                                            @endphp
                                            @foreach ($pembayaran as $item)
                                            @php
                                                $totalpembayaran = $totalpembayaran + $item->nominal;
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration}}</td>
                                                <td class="text-center">
                                                    <form id="data-{{ $item->id }}" action="{{ url('/pembayaranproyek/'.$item->id)}}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        </form>
                                                    <button type="button" data-toggle="modal" data-tgl_pembayaran="{{ $item->tgl_pembayaran }}" data-nama_pembayaran="{{ $item->nama_pembayaran }}" data-nominal="{{ $item->nominal }}" data-keterangan_pembayaran="{{ $item->keterangan_pembayaran }}" data-id="{{ $item->id }}" data-target="#ubahpembayaran" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button onclick="deleteRow( {{ $item->id }} )" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                                </td>
                                                <td>{{ date_indo($item->tgl_pembayaran)}}</td>
                                                <td>{{ $item->nama_pembayaran}}</td>
                                                <td>
                                                    @if (is_null($item->bukti_pembayaran))
                                                        bukti tidak diupload
                                                        @else
                                                        <a href="{{ asset('/img/proyek/'.$item->bukti_pembayaran)}}" target="_blank">{{ $item->bukti_pembayaran}}</a>
                                                        @endif
                                                        
                                                    </td>
                                                <td>{{ $item->keterangan_pembayaran}}</td>
                                                <td class="text-right">{{ norupiah($item->nominal)}}</td>
                                            </tr>
                                            @endforeach
                                            @if (count($pembayaran) > 0)
                                                <tr>
                                                    <th colspan="6" class="text-right">Total Pembayaran</th>
                                                    <td class="text-right">{{ norupiah($totalpembayaran)}}</td>
                                                </tr>
                                                {{-- kode sisa pembayaran yaitu biaya dikurangi total pembayaran --}}
                                                @php
                                                    $sisapembayaran = $proyek->biaya - $totalpembayaran;
                                                @endphp
                                                <tr class="table-secondary font-weight-bold">
                                                    <th colspan="6" class="text-right">Sisa Pembayaran</th>
                                                    <td class="text-right">{{ norupiah($sisapembayaran)}}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end pembayaran proyek --}}
              </div>
            </div>
          </div>
        </div>
    </div>
    {{-- modal --}}
    {{-- modal tambah manajemen proyek--}}
    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ url('/manajemenproyek')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="proyek_id" value="{{ $proyek->id}}">
            <div class="modal-header">
            <h4 class="modal-title">Tambah Proyek</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Anggota</label>
                        <select name="anggota_id" id="anggota_id" class="form-control col-md-8">
                            @foreach ($anggota as $item)
                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Catatan</label>
                        <textarea name="catatan" id="catatan" cols="30" rows="3" class="form-control col-md-8" required></textarea>
                    </div>
                </section>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> SIMPAN</button>
            </div>
        </form>
        </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modal edit manajemen proyek--}}
    <div class="modal fade" id="ubah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ route('manajemenproyek.update','test')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Manajemen Proyek</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" name="id" id="id">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Anggota</label>
                        <select name="anggota_id" id="anggota_id" class="form-control col-md-8">
                            @foreach ($anggota as $item)
                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Catatan</label>
                        <textarea name="catatan" id="catatan" cols="30" rows="3" class="form-control col-md-8" required></textarea>
                    </div>
                </section>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
            <button type="submit" class="btn btn-success"><i class="fas fa-pen"></i> SIMPAN PERUBAHAN</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    {{-- modal tambah manajemen proyek--}}
    <div class="modal fade" id="tambahpembayaran">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ url('/pembayaranproyek')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="proyek_id" value="{{ $proyek->id}}">
            <div class="modal-header">
            <h4 class="modal-title">Tambah Pembayaran Proyek</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Pembayaran</label>
                        <input type="text" name="nama_pembayaran" id="nama_pembayaran" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal Pembayaran</label>
                        <input type="date" name="tgl_pembayaran" id="tgl_pembayaran" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nominal Pembayaran</label>
                        <input type="text" name="nominal" id="rupiah" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Bukti Pembayaran (opsional)</label>
                        <input type="file" name="bukti_pembayaran" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Keterangan</label>
                        <textarea name="keterangan_pembayaran" id="keterangan_pembayaran" cols="30" rows="3" class="form-control col-md-8" required></textarea>
                    </div>
                </section>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> SIMPAN</button>
            </div>
        </form>
        </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modal edit manajemen proyek--}}
    <div class="modal fade" id="ubahpembayaran">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ route('pembayaranproyek.update','test')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Pembayaran Proyek</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" name="id" id="id">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Pembayaran</label>
                        <input type="text" name="nama_pembayaran" id="nama_pembayaran" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal Pembayaran</label>
                        <input type="date" name="tgl_pembayaran" id="tgl_pembayaran" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nominal Pembayaran</label>
                        <input type="text" name="nominal" id="rupiah" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Bukti Pembayaran (opsional)</label>
                        <input type="file" name="bukti_pembayaran" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Keterangan</label>
                        <textarea name="keterangan_pembayaran" id="keterangan_pembayaran" cols="30" rows="3" class="form-control col-md-8" required></textarea>
                    </div>
                </section>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
            <button type="submit" class="btn btn-success"><i class="fas fa-pen"></i> SIMPAN PERUBAHAN</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    <!-- /.modal -->

@endsection
@section('script')
    
    <script>
        $('#ubah').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var anggota_id = button.data('anggota_id')
            var catatan = button.data('catatan')
           
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #anggota_id').val(anggota_id);
            modal.find('.modal-body #catatan').val(catatan);
          
            modal.find('.modal-body #id').val(id);
        });

        $('#ubahpembayaran').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var nama_pembayaran = button.data('nama_pembayaran')
            var keterangan_pembayaran = button.data('keterangan_pembayaran')
            var tgl_pembayaran = button.data('tgl_pembayaran')
            var nominal = button.data('nominal')
           
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #nama_pembayaran').val(nama_pembayaran);
            modal.find('.modal-body #keterangan_pembayaran').val(keterangan_pembayaran);
            modal.find('.modal-body #tgl_pembayaran').val(tgl_pembayaran);
            modal.find('.modal-body #rupiah').val(nominal);
          
            modal.find('.modal-body #id').val(id);
        })
    </script>
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

