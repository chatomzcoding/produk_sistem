@extends('layouts.admin')

@section('title')
    ADMIN - Anggota
@endsection
@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Anggota</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Daftar Anggota</li>
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
                <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Anggota </a>
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
                                <th>Jabatan</th>
                                <th>No Hp</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @forelse ($anggota as $item)
                            <tr>
                                    <td class="text-center">{{ $loop->iteration}}</td>
                                    <td class="text-center"><img src="{{ asset('/img/user/'.$item->photo)}}" alt="{{ $item->photo}}" width="100px"></td>
                                    <td>{{ $item->name}}</td>
                                    <td>{{ $item->jabatan}}</td>
                                    <td>{{ $item->no_hp}}</td>
                                    <td>{{ $item->status_anggota}}</td>
                                    <td class="text-center">
                                        <form id="data-{{ $item->id }}" action="{{ url('/anggota/'.$item->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            </form>
                                        <button type="button" data-toggle="modal" data-alamat="{{ $item->alamat }}" data-no_hp="{{ $item->no_hp }}" data-email="{{ $item->email }}" data-jabatan="{{ $item->jabatan }}" data-keterangan="{{ $item->keterangan }}" data-status_anggota="{{ $item->status_anggota }}" data-user_id="{{ $item->user_id }}" data-id="{{ $item->id }}" data-target="#ubah" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
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
            <form action="{{ url('/anggota')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-header">
            <h4 class="modal-title">Tambah Anggota</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">User</label>
                        <select name="user_id" id="user_id" class="form-control col-md-8">
                            @foreach ($user as $item)
                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
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
                        <label for="" class="col-md-4 p-2">email</label>
                        <input type="email" name="email" id="email" class="form-control col-md-8" placeholder="Alamat Email" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Status Anggota</label>
                        <select name="status_anggota" id="status_anggota" class="form-control col-md-8">
                            @foreach (list_statusanggota() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control col-md-8" required>
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
            <form action="{{ route('anggota.update','test')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Anggota</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" name="id" id="id">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">User</label>
                        <select name="user_id" id="user_id" class="form-control col-md-8">
                            @foreach ($user as $item)
                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
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
                        <label for="" class="col-md-4 p-2">email</label>
                        <input type="email" name="email" id="email" class="form-control col-md-8" placeholder="Alamat Email" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Status Anggota</label>
                        <select name="status_anggota" id="status_anggota" class="form-control col-md-8">
                            @foreach (list_statusanggota() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control col-md-8" required>
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
            var alamat = button.data('alamat')
            var no_hp = button.data('no_hp')
            var email = button.data('email')
            var jabatan = button.data('jabatan')
            var status_anggota = button.data('status_anggota')
            var keterangan = button.data('keterangan')
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #alamat').val(alamat);
            modal.find('.modal-body #no_hp').val(no_hp);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #jabatan').val(jabatan);
            modal.find('.modal-body #status_anggota').val(status_anggota);
            modal.find('.modal-body #keterangan').val(keterangan);
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

