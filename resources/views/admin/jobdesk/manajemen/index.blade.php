@extends('layouts.admin')

@section('title')
    ADMIN - Manajemen Jobdesk
@endsection
@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Manajemen Jobdesk</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Daftar Manajemen Jobdesk</li>
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
                <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Manajemen Jobdesk </a>
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
                                <th>Nama Anggota</th>
                                <th>Jobdesk</th>
                                <th>Tingkatan</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @forelse ($manajemen as $item)
                            <tr>
                                    <td class="text-center">{{ $loop->iteration}}</td>
                                    <td>{{ $item->name}}</td>
                                    <td>{{ $item->nama_jobdesk}}</td>
                                    <td class="text-center">{{ $item->tingkatan}}</td>
                                    <td>{{ $item->catatan}}</td>
                                    <td class="text-center">
                                        <form id="data-{{ $item->id }}" action="{{ url('/jobdesk/'.$item->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            </form>
                                        <button type="button" data-toggle="modal" data-anggota_id="{{ $item->anggota_id }}" data-jobdesk_id="{{ $item->jobdesk_id }}" data-tingkatan="{{ $item->tingkatan }}" data-catatan="{{ $item->catatan }}" data-skala_prioritas="{{ $item->skala_prioritas }}" data-id="{{ $item->id }}" data-target="#ubah" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
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
            <form action="{{ url('/manajemenjobdesk')}}" method="post">
                @csrf
            <div class="modal-header">
            <h4 class="modal-title">Tambah Manajemen Jobdesk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Anggota</label>
                        <select name="anggota_id" id="anggota_id" class="form-control col-md-8" required>
                            @foreach ($anggota as $item)
                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Jobdesk</label>
                        <select name="jobdesk_id" id="jobdesk_id" class="form-control col-md-8" required>
                            @foreach ($jobdesk as $item)
                                <option value="{{ $item->id}}">{{ $item->nama_jobdesk}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tingkatan Jobdesk</label>
                        <select name="tingkatan" id="tingkatan" class="form-control col-md-8" required>
                            @foreach (list_tingkatanjobdesk() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Skala Priotitas</label>
                        <select name="skala_prioritas" id="skala_prioritas" class="form-control col-md-8" required>
                            @foreach (list_skalaprioritas() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Catatan</label>
                        <textarea name="catatan" id="catatan" cols="30" rows="5" class="form-control col-md-8" required></textarea>
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
            <form action="{{ route('manajemenjobdesk.update','test')}}" method="post">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Manajemen Jobdesk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" name="id" id="id">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Anggota</label>
                        <select name="anggota_id" id="anggota_id" class="form-control col-md-8" required>
                            @foreach ($anggota as $item)
                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Jobdesk</label>
                        <select name="jobdesk_id" id="jobdesk_id" class="form-control col-md-8" required>
                            @foreach ($jobdesk as $item)
                                <option value="{{ $item->id}}">{{ $item->nama_jobdesk}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tingkatan Jobdesk</label>
                        <select name="tingkatan" id="tingkatan" class="form-control col-md-8" required>
                            @foreach (list_tingkatanjobdesk() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Skala Priotitas</label>
                        <select name="skala_prioritas" id="skala_prioritas" class="form-control col-md-8" required>
                            @foreach (list_skalaprioritas() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Catatan</label>
                        <textarea name="catatan" id="catatan" cols="30" rows="5" class="form-control col-md-8" required></textarea>
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
            var jobdesk_id = button.data('jobdesk_id')
            var anggota_id = button.data('anggota_id')
            var tingkatan = button.data('tingkatan')
            var catatan = button.data('catatan')
            var skala_prioritas = button.data('skala_prioritas')
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #jobdesk_id').val(jobdesk_id);
            modal.find('.modal-body #anggota_id').val(anggota_id);
            modal.find('.modal-body #tingkatan').val(tingkatan);
            modal.find('.modal-body #catatan').val(catatan);
            modal.find('.modal-body #skala_prioritas').val(skala_prioritas);
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

