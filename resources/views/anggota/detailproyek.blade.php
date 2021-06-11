@extends('layouts.admin')

@section('title')
    Daftar Proyek - Proyek Detail
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Proyek</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('daftarproyek')}}">Daftar Proyek</a></li>
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
                  <a href="{{ url('/daftarproyek')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-angle-left"></i> Kembali</a>
                {{-- <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Proyek </a> --}}
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
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
                                    {{-- <tr>
                                        <th>Biaya</th>
                                        <td>: {{ rupiah($proyek->biaya)}}</td>
                                    </tr> --}}
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
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Nama Tim</th>
                                                <th>Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($manajemenproyek as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration}}</td>
                                                <td>{{ $item->name}}</td>
                                                <td>{{ $item->catatan}}</td>
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

