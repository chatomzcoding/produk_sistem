@extends('layouts.admin')

@section('title')
    ADMIN - Proyek
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Proyek</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Daftar Proyek</li>
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
                <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Proyek </a>
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
                                <th>Nama Proyek</th>
                                <th>Waktu Pelaksanaan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @forelse ($proyek as $item)
                            <tr>
                                    <td class="text-center">{{ $loop->iteration}}</td>
                                    <td class="text-center">
                                        @if (is_null($item->gambar))
                                            <img src="{{ asset('/img/img-proyek.png')}}" alt="{{ $item->photo}}" width="100px">
                                        @else
                                            <img src="{{ asset('/img/proyek/'.$item->gambar)}}" alt="{{ $item->photo}}" width="100px">
                                        @endif
                                    </td>
                                    <td>{{ $item->nama_proyek}}</td>
                                    <td>{{ date_indo($item->tgl_dimulai).' - '.date_indo($item->tgl_berakhir)}}</td>
                                    <td>{{ $item->status_proyek}}</td>
                                    <td class="text-center">
                                        <form id="data-{{ $item->id }}" action="{{ url('/proyek/'.$item->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            </form>
                                        <a href="{{ url('/proyek/'.Crypt::encryptString($item->id))}}" class="btn btn-primary btn-sm"><i class="fas fa-file"></i></a>
                                        <button type="button" data-toggle="modal" data-nama_proyek="{{ $item->nama_proyek }}" data-tgl_dimulai="{{ $item->tgl_dimulai }}" data-tgl_berakhir="{{ $item->tgl_berakhir }}" data-status_proyek="{{ $item->status_proyek }}" data-biaya="{{ $item->biaya }}" data-level_proyek="{{ $item->level_proyek }}" data-link="{{ $item->link }}" data-detail_proyek="{{ $item->detail_proyek }}" data-biaya="{{ $item->biaya }}" data-id="{{ $item->id }}" data-target="#ubah" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
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
            <form action="{{ url('/proyek')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-header">
            <h4 class="modal-title">Tambah Proyek</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Client <span class="text-danger">*</span></label>
                        <select name="client_id" id="client_id" class="form-control col-md-8">
                            @foreach ($client as $item)
                                <option value="{{ $item->id}}">{{ ucwords($item->nama)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Proyek <span class="text-danger">*</span></label>
                        <input type="text" name="nama_proyek" id="nama_proyek" class="form-control col-md-8" placeholder="Nama Proyek" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal awal <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_dimulai" id="tgl_dimulai" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal Berakhir <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_berakhir" id="tgl_berakhir" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Biaya <span class="text-danger">*</span></label>
                        <input type="text" name="biaya" id="rupiah" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Link (opsional)</label>
                        <input type="url" name="link" id="link" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Status Proyek <span class="text-danger">*</span></label>
                        <select name="status_proyek" id="status_proyek" class="form-control col-md-8">
                            @foreach (list_statusproyek() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Level Proyek <span class="text-danger">*</span></label>
                        <select name="level_proyek" id="level_proyek" class="form-control col-md-8">
                            @foreach (list_levelproyek() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Detail Proyek <span class="text-danger">*</span></label>
                        <textarea name="detail_proyek" id="detail_proyek" cols="30" rows="4" class="form-control col-md-8" required></textarea>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Gambar (opsional)</label>
                        <input type="file" name="gambar" class="form-control col-md-8">
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
            <form action="{{ route('proyek.update','test')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Proyek</h4>
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
                                <option value="{{ $item->id}}">{{ ucwords($item->nama)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Proyek</label>
                        <input type="text" name="nama_proyek" id="nama_proyek" class="form-control col-md-8" placeholder="Nama Proyek" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal awal</label>
                        <input type="date" name="tgl_dimulai" id="tgl_dimulai" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal Berakhir</label>
                        <input type="date" name="tgl_berakhir" id="tgl_berakhir" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Biaya</label>
                        <input type="text" name="biaya" id="rupiah" class="form-control col-md-8" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Link (opsional)</label>
                        <input type="url" name="link" id="link" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Status Proyek</label>
                        <select name="status_proyek" id="status_proyek" class="form-control col-md-8">
                            @foreach (list_statusproyek() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Level Proyek</label>
                        <select name="level_proyek" id="level_proyek" class="form-control col-md-8">
                            @foreach (list_levelproyek() as $item)
                                <option value="{{ $item}}">{{ $item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Detail Proyek</label>
                        <textarea name="detail_proyek" id="detail_proyek" cols="30" rows="4" class="form-control col-md-8" required></textarea>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Gambar (upload untuk merubah)</label>
                        <input type="file" name="gambar" class="form-control col-md-8">
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
            var nama_proyek = button.data('nama_proyek')
            var tgl_dimulai = button.data('tgl_dimulai')
            var tgl_berakhir = button.data('tgl_berakhir')
            var biaya = button.data('biaya')
            var level_proyek = button.data('level_proyek')
            var status_proyek = button.data('status_proyek')
            var link = button.data('link')
            var detail_proyek = button.data('detail_proyek')
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #nama_proyek').val(nama_proyek);
            modal.find('.modal-body #tgl_dimulai').val(tgl_dimulai);
            modal.find('.modal-body #tgl_berakhir').val(tgl_berakhir);
            modal.find('.modal-body #rupiah').val(biaya);
            modal.find('.modal-body #level_proyek').val(level_proyek);
            modal.find('.modal-body #status_proyek').val(status_proyek);
            modal.find('.modal-body #link').val(link);
            modal.find('.modal-body #detail_proyek').val(detail_proyek);
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

