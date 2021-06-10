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
      <li class="breadcrumb-item"><a href="{{ url('layanan')}}">Daftar Layanan</a></li>
      <li class="breadcrumb-item active">Detail Layanan</li>
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
                {{-- <h3 class="card-title">Daftar Unit</h3> --}}
                {{-- <a href="{{ url('/artikel')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-print"></i> Kembali ke artikel</a> --}}
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                  <section class="row">
                      <div class="col-md-4">
                        <img src="{{ asset('/img/layanan/'.$layanan->poto_layanan)}}" alt="" class="img-fluid">
                      </div>
                      <div class="col-md-8">
                          <table class="table">
                            <tr>
                                <th>Nama Layanan</th>
                                <td>: {{ $layanan->nama_layanan}}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>: {{ $layanan->kategori}}</td>
                            </tr>
                            <tr>
                                <th>Tentang Layanan</th>
                                <td>: {{ $layanan->tentang_layanan}}</td>
                            </tr>
                            <tr>
                                <th>Harga Beli</th>
                                <td>: {{ rupiah($layanan->harga_beli)}}</td>
                            </tr>
                            <tr>
                                <th>Harga Jual</th>
                                <td>: {{ rupiah($layanan->harga_jual)}}</td>
                            </tr>
                            <tr>
                                <th>Link</th>
                                <td>: <a href="{{ $layanan->link}}" target="_blank">{{ $layanan->link}}</a></td>
                            </tr>
                          </table>
                      </div>
                  </section>

                  <section class="row">
                    <div class="col-md-12">
                        <hr>
                        
                <h2>Daftar Client <a href="#" class="btn btn-outline-primary btn-flat btn-sm float-right" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Client Pemesan Layanan </a></h2>
                        <div class="table-responsive">
                          <table id="example1" class="table table-bordered table-striped">
                              <thead class="text-center">
                                  <tr>
                                      <th width="5%">No</th>
                                      <th>Nama Client</th>
                                      <th>Tanggal Pemesanan</th>
                                      <th>Harga</th>
                                      <th>Keterangan</th>
                                      <th>Aksi</th>
                                  </tr>
                              </thead>
                              <tbody class="text-capitalize">
                                  @forelse ($manajemen as $item)
                                      <tr>
                                          <td class="text-center">{{ $loop->iteration}}</td>
                                          <td>{{ $item->nama}}</td>
                                          <td>{{ date_indo($item->tgl_pemesanan)}}</td>
                                          <td>{{ rupiah($item->harga)}}</td>
                                          <td>{{ $item->keterangan}}</td>
                                          <td class="text-center">
                                              <form id="data-{{ $item->id }}" action="{{ url('/manajemenlayanan/'.$item->id)}}" method="post">
                                                  @csrf
                                                  @method('delete')
                                              </form>
                                              {{-- <a href="{{ url('/manajemenlayanan/'.Crypt::encryptString($item->id))}}" class="btn btn-primary btn-sm"><i class="fas fa-file"></i></a> --}}
                                              <button type="button" data-toggle="modal" data-client_id="{{ $item->client_id }}" data-tgl_pemesanan="{{ $item->tgl_pemesanan }}" data-client_id="{{ $item->client_id }}" data-keterangan="{{ $item->keterangan }}" data-harga="{{ $item->harga }}" data-id="{{ $item->id }}" data-target="#ubah" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
                                                  <i class="fa fa-edit"></i>
                                              </button>
                                              <button onclick="deleteRow( {{ $item->id }} )" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                          </td>
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
    {{-- modal --}}
    {{-- modal tambah --}}
    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ url('/manajemenlayanan')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="layanan_id" value="{{ $layanan->id}}">
            <div class="modal-header">
            <h4 class="modal-title">Tambah Layanan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Client</label>
                        <select name="client_id" id="client_id" class="form-control col-md-8">
                            @foreach ($client as $item)
                                <option value="{{ $item->id}}">{{ $item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal Pemesanan</label>
                        <input type="date" name="tgl_pemesanan" id="tgl_pemesanan" class="form-control col-md-8" placeholder="Nama Layanan" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Harga</label>
                        <input type="text" name="harga" value="{{ $layanan->harga_jual}}" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="4" class="form-control col-md-8" required></textarea>
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

    {{-- modal edit --}}
    <div class="modal fade" id="ubah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ route('manajemenlayanan.update','test')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Manajemen Layanan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" name="id" id="id">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Client</label>
                        <select name="client_id" id="client_id" class="form-control col-md-8">
                            @foreach ($client as $item)
                                <option value="{{ $item->id}}">{{ $item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal Pemesanan</label>
                        <input type="date" name="tgl_pemesanan" id="tgl_pemesanan" class="form-control col-md-8" placeholder="Nama Layanan" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Harga</label>
                        <input type="text" name="harga" value="{{ $layanan->harga_jual}}" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="4" class="form-control col-md-8" required></textarea>
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
            var tgl_pemesanan = button.data('tgl_pemesanan')
            var client_id = button.data('client_id')
            var keterangan = button.data('keterangan')
            var harga = button.data('harga')
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #tgl_pemesanan').val(tgl_pemesanan);
            modal.find('.modal-body #client_id').val(client_id);
            modal.find('.modal-body #keterangan').val(keterangan);
            modal.find('.modal-body #harga').val(harga);
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

