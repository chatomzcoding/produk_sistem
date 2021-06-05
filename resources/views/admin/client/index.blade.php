@extends('layouts.admin')

@section('title')
    ADMIN - Client
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Client</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Daftar Client</li>
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
                <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Client </a>
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
                                <th>Photo</th>
                                <th>Nama</th>
                                <th>No Hp</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @forelse ($client as $item)
                            <tr>
                                    <td class="text-center">{{ $loop->iteration}}</td>
                                    <td class="text-center"><img src="{{ asset('/img/client/'.$item->poto)}}" alt="{{ $item->photo}}" width="100px"></td>
                                    <td>{{ $item->nama}}</td>
                                    <td>{{ $item->no_hp}}</td>
                                    <td>{{ $item->status_client}}</td>
                                    <td class="text-center">
                                        <form id="data-{{ $item->id }}" action="{{ url('/client/'.$item->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            </form>
                                        <button type="button" data-toggle="modal" data-nama="{{ $item->nama }}" data-alamat="{{ $item->alamat }}" data-no_hp="{{ $item->no_hp }}" data-tentang="{{ $item->tentang }}" data-status_client="{{ $item->status_client }}" data-id="{{ $item->id }}" data-target="#ubah" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
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
            </div>
          </div>
        </div>
    </div>
    {{-- modal --}}
    {{-- modal tambah --}}
    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ url('/client')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-header">
            <h4 class="modal-title">Tambah Client</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Client</label>
                        <input type="text" name="nama" id="nama" class="form-control col-md-8" placeholder="Alamat Tinggal" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Alamat Tinggal</label>
                        <input type="text" name="alamat" id="alamat" class="form-control col-md-8" placeholder="Alamat Tinggal" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">No Kontak</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control col-md-8" placeholder="08xxxxxx" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Status Client</label>
                        <select name="status_client" id="status_client" class="form-control col-md-8">
                            @foreach (list_statusclient() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tentang</label>
                        <textarea name="tentang" id="tentang" cols="30" rows="4" class="form-control col-md-8" required></textarea>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Photo</label>
                        <input type="file" name="poto" class="form-control col-md-8" required>
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
            <form action="{{ route('client.update','test')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Client</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" name="id" id="id">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Client</label>
                        <input type="text" name="nama" id="nama" class="form-control col-md-8" placeholder="Alamat Tinggal" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Alamat Tinggal</label>
                        <input type="text" name="alamat" id="alamat" class="form-control col-md-8" placeholder="Alamat Tinggal" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">No Kontak</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control col-md-8" placeholder="08xxxxxx" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Status Client</label>
                        <select name="status_client" id="status_client" class="form-control col-md-8">
                            @foreach (list_statusclient() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tentang</label>
                        <textarea name="tentang" id="tentang" cols="30" rows="4" class="form-control col-md-8" required></textarea>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Photo (upload jika ingin merubah)</label>
                        <input type="file" name="poto" class="form-control col-md-8">
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
            var nama = button.data('nama')
            var no_hp = button.data('no_hp')
            var alamat = button.data('alamat')
            var status_client = button.data('status_client')
            var tentang = button.data('tentang')
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #nama').val(nama);
            modal.find('.modal-body #no_hp').val(no_hp);
            modal.find('.modal-body #alamat').val(alamat);
            modal.find('.modal-body #status_client').val(status_client);
            modal.find('.modal-body #tentang').val(tentang);
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

