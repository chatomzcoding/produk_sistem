@extends('layouts.admin')

@section('title')
    ADMIN - Jobdesk
@endsection
@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Jobdesk</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Daftar Jobdesk</li>
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
                <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Jobdesk </a>
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
                                <th>Nama Jobdesk</th>
                                <th>Keterangan</th>
                                <th>Pemotongan Biaya</th>
                                <th>Bagi Hasil (%)</th>
                                <th>Mata Uang</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @forelse ($jobdesk as $item)
                            <tr>
                                    <td class="text-center">{{ $loop->iteration}}</td>
                                    <td>{{ $item->nama_jobdesk}}</td>
                                    <td>{{ $item->keterangan_jobdesk}}</td>
                                    <td>{{ $item->potongan_pengeluaran}}</td>
                                    <td>{{ $item->potongan_utama}}
                                        @if (!is_null($item->potongan_utama))
                                            %
                                        @endif
                                        </td>
                                    <td class="text-center">{{ $item->matauang}}</td>
                                    <td class="text-center">{{ $item->status_jobdesk}}</td>
                                    <td class="text-center">
                                        <form id="data-{{ $item->id }}" action="{{ url('/jobdesk/'.$item->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            </form>
                                        <a href="{{ url('/jobdesk',Crypt::encryptString($item->id))}}" class="btn btn-primary btn-sm"><i class="fas fa-file"></i></a>
                                        <button type="button" data-toggle="modal" data-nama_jobdesk="{{ $item->nama_jobdesk }}" data-keterangan_jobdesk="{{ $item->keterangan_jobdesk }}" data-status_jobdesk="{{ $item->status_jobdesk }}"  data-potongan_pengeluaran="{{ $item->potongan_pengeluaran }}"  data-potongan_utama="{{ $item->potongan_utama }}"  data-matauang="{{ $item->matauang }}" data-id="{{ $item->id }}" data-target="#ubah" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button onclick="deleteRow( {{ $item->id }} )" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    </td>
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
    {{-- modal --}}
    {{-- modal tambah --}}
    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ url('/jobdesk')}}" method="post">
                @csrf
            <div class="modal-header">
            <h4 class="modal-title">Tambah Jobdesk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Jobdesk <strong class="text-danger">*</strong></label>
                        <input type="text" name="nama_jobdesk" id="nama_jobdesk" class="form-control col-md-8" placeholder="Masukkan jobdesk" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Keterangan Jobdesk <strong class="text-danger">*</strong></label>
                        <textarea name="keterangan_jobdesk" id="keterangan_jobdesk" cols="30" rows="4" class="form-control col-md-8" placeholder="penjelasan singkat tentang jobdesk" required></textarea>
                    </div>
                    <section class="alert alert-success">
                        Form Perhitungan Keuangan Jobdesk (opsional) <br>
                        isi untuk masuk ke perhitungan deposit anggota
                    </section>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Potongan Pengeluaran</label>
                        <div class="col-md-8 p-0">
                            <input type="number" name="potongan_pengeluaran" id="potongan_pengeluaran" class="form-control">
                            <small>(bila kosong tidak akan dikenai biaya pengeluaran)</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Pembagian penghasilan </label>
                        <div class="col-md-8 p-0">
                            <input type="number" name="potongan_utama" id="potongan_utama" min="0" max="100" class="form-control">
                            <small>(bentuk persentase 0-100 % )</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Mata Uang</label>
                        <div class="col-md-8 p-0">
                            <select name="matauang" id="" class="form-control">
                                @foreach (list_matauang() as $item)
                                    <option value="{{ $item}}">{{ $item}}</option>
                                @endforeach
                            </select>
                            <small>(keperluan konvert ke deposit)</small>
                        </div>
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
            <form action="{{ route('jobdesk.update','test')}}" method="post">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Jobdesk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" name="id" id="id">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Jobdesk</label>
                        <input type="text" name="nama_jobdesk" id="nama_jobdesk" class="form-control col-md-8" placeholder="Masukkan jobdesk" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Status Jobdesk</label>
                        <select name="status_jobdesk" id="status_jobdesk" class="form-control col-md-8">
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Keterangan Jobdesk</label>
                        <textarea name="keterangan_jobdesk" id="keterangan_jobdesk" cols="30" rows="4" class="form-control col-md-8" required></textarea>
                    </div>
                    <section class="alert alert-success">
                        Form Perhitungan Keuangan Jobdesk (opsional) <br>
                        isi untuk masuk ke perhitungan deposit anggota
                    </section>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Potongan Pengeluaran</label>
                        <div class="col-md-8 p-0">
                            <input type="number" name="potongan_pengeluaran" id="potongan_pengeluaran" class="form-control">
                            <small>(bila kosong tidak akan dikenai biaya pengeluaran)</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Pembagian penghasilan </label>
                        <div class="col-md-8 p-0">
                            <input type="number" name="potongan_utama" id="potongan_utama" min="0" max="100" class="form-control">
                            <small>(bentuk persentase 0-100 % )</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Mata Uang</label>
                        <div class="col-md-8 p-0">
                            <select name="matauang" id="matauang" class="form-control">
                                @foreach (list_matauang() as $item)
                                    <option value="{{ $item}}">{{ $item}}</option>
                                @endforeach
                            </select>
                            <small>(keperluan konvert ke deposit)</small>
                        </div>
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
            var nama_jobdesk = button.data('nama_jobdesk')
            var status_jobdesk = button.data('status_jobdesk')
            var keterangan_jobdesk = button.data('keterangan_jobdesk')
            var potongan_pengeluaran = button.data('potongan_pengeluaran')
            var potongan_utama = button.data('potongan_utama')
            var matauang = button.data('matauang')
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #nama_jobdesk').val(nama_jobdesk);
            modal.find('.modal-body #status_jobdesk').val(status_jobdesk);
            modal.find('.modal-body #keterangan_jobdesk').val(keterangan_jobdesk);
            modal.find('.modal-body #potongan_pengeluaran').val(potongan_pengeluaran);
            modal.find('.modal-body #potongan_utama').val(potongan_utama);
            modal.find('.modal-body #matauang').val(matauang);
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

