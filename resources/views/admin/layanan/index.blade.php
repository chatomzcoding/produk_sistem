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
                {{-- <h3 class="card-title">Daftar Unit</h3> --}}
                <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Layanan </a>
                {{-- <a href="{{ url('/artikel')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-print"></i> Kembali ke artikel</a> --}}
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
                                <th>Aksi</th>
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
                                    <td class="text-center">
                                        <form id="data-{{ $item->id }}" action="{{ url('/layanan/'.$item->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <a href="{{ url('/layanan/'.Crypt::encryptString($item->id))}}" class="btn btn-primary btn-sm"><i class="fas fa-file"></i></a>
                                        <button type="button" data-toggle="modal" data-nama_layanan="{{ $item->nama_layanan }}" data-tentang_layanan="{{ $item->tentang_layanan }}" data-harga_beli="{{ $item->harga_beli }}" data-harga_jual="{{ $item->harga_jual }}" data-kategori="{{ $item->kategori }}" data-link="{{ $item->link }}" data-id="{{ $item->id }}" data-target="#ubah" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button onclick="deleteRow( {{ $item->id }} )" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    </td>
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
    {{-- modal --}}
    {{-- modal tambah --}}
    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ url('/layanan')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-header">
            <h4 class="modal-title">Tambah Layanan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Layanan</label>
                        <input type="text" name="nama_layanan" id="nama_layanan" class="form-control col-md-8" placeholder="Nama Layanan" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Harga Beli</label>
                        <input type="text" name="harga_beli" id="rupiah" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Harga Jual</label>
                        <input type="text" name="harga_jual" id="rupiah1" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Link (opsional)</label>
                        <input type="url" name="link" id="link" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control col-md-8">
                            @foreach (list_kategorilayanan() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tentang Layanan</label>
                        <textarea name="tentang_layanan" id="tentang_layanan" cols="30" rows="4" class="form-control col-md-8" required></textarea>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Gambar Layanan</label>
                        <input type="file" name="poto_layanan" class="form-control col-md-8" required>
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
            <form action="{{ route('layanan.update','test')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Layanan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" name="id" id="id">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Layanan</label>
                        <input type="text" name="nama_layanan" id="nama_layanan" class="form-control col-md-8" placeholder="Nama Layanan" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Harga Beli</label>
                        <input type="text" name="harga_beli" id="rupiah" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Harga Jual</label>
                        <input type="text" name="harga_jual" id="rupiah1" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Link (opsional)</label>
                        <input type="url" name="link" id="link" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control col-md-8">
                            @foreach (list_kategorilayanan() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tentang Layanan</label>
                        <textarea name="tentang_layanan" id="tentang_layanan" cols="30" rows="4" class="form-control col-md-8" required></textarea>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Gambar Layanan</label>
                        <input type="file" name="poto_layanan" class="form-control col-md-8">
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
            var nama_layanan = button.data('nama_layanan')
            var tentang_layanan = button.data('tentang_layanan')
            var poto_layanan = button.data('poto_layanan')
            var harga_beli = button.data('harga_beli')
            var harga_jual = button.data('harga_jual')
            var kategori = button.data('kategori')
            var link = button.data('link')
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #nama_layanan').val(nama_layanan);
            modal.find('.modal-body #tentang_layanan').val(tentang_layanan);
            modal.find('.modal-body #poto_layanan').val(poto_layanan);
            modal.find('.modal-body #rupiah').val(harga_beli);
            modal.find('.modal-body #rupiah1').val(harga_jual);
            modal.find('.modal-body #kategori').val(kategori);
            modal.find('.modal-body #link').val(link);
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

