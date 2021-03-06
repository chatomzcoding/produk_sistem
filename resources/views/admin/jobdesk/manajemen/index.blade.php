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
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead class="text-center table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama / Jobdesk</th>
                                <th>Tingkatan</th>
                                <th>Catatan</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($anggota as $item)
                                <tr class="table-secondary">
                                    <td>{{ $no}}</td>
                                    <td colspan="4" class="font-weight-bold">{{ $item->name}}</td>
                                </tr>
                                @foreach (DbSistem::listjobdeskanggota($item->id) as $item2)
                                    <tr>
                                        <td></td>
                                        <td>{{ $item2->nama_jobdesk}}</td>
                                        <td class="text-center">{{ $item2->tingkatan}} <br>
                                            {{-- jika kondisional --}}
                                            <small>
                                                @if ($item2->tingkatan == 'kondisional')
                                                    Periode Pengerjaan <br>
                                                    {{ date_indo($item2->tgl_awal).' - '.date_indo($item2->tgl_akhir)}}
                                                @endif
                                            </small>
                                        </td>
                                        <td>{{ $item2->keterangan_jobdesk}} <br> <small>{{ $item2->catatan}}</small></td>
                                        <td class="text-center">
                                            <form id="data-{{ $item2->idmanajemen }}" action="{{ url('/manajemenjobdesk/'.$item2->idmanajemen)}}" method="post">
                                                @csrf
                                                @method('delete')
                                                </form>
                                            <button type="button" data-toggle="modal" data-anggota_id="{{ $item2->anggota_id }}" data-jobdesk_id="{{ $item2->jobdesk_id }}" data-tingkatan="{{ $item2->tingkatan }}" data-catatan="{{ $item2->catatan }}" data-skala_prioritas="{{ $item2->skala_prioritas }}" data-tgl_awal="{{ $item2->tgl_awal }}" data-tgl_akhir="{{ $item2->tgl_akhir }}" data-id="{{ $item2->idmanajemen }}" data-target="#ubah" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button onclick="deleteRow( {{ $item2->idmanajemen }} )" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                @php
                                    $no++;
                                @endphp
                            @endforeach
                        </tbody>
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
                    <section id="tanggal" style="display: none;">
                        <div class="form-group row">
                            <label for="" class="col-md-4 p-2">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" class="form-control col-md-8">
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-4 p-2">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" class="form-control col-md-8">
                        </div>
                    </section>
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
                    <div class="alert alert-warning">
                        Tanggal Awal dan Tanggal Akhir disesuaikan untuk tingkatan jobdesk kondisional
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" id="tgl_awal" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control col-md-8">
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
            var tgl_awal = button.data('tgl_awal')
            var tgl_akhir = button.data('tgl_akhir')
            var skala_prioritas = button.data('skala_prioritas')
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #jobdesk_id').val(jobdesk_id);
            modal.find('.modal-body #anggota_id').val(anggota_id);
            modal.find('.modal-body #tingkatan').val(tingkatan);
            modal.find('.modal-body #catatan').val(catatan);
            modal.find('.modal-body #tgl_awal').val(tgl_awal);
            modal.find('.modal-body #tgl_akhir').val(tgl_akhir);
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
        $(function () {
            $("#tingkatan").change(function () {
                if ($(this).val() == "kondisional") {
                    $("#tanggal").show();
                } else {
                    $("#tanggal").hide();
                }
            });
        });
    </script>
@endsection

