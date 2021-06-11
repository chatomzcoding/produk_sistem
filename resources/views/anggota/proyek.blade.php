@extends('layouts.admin')

@section('title')
    Daftar Proyek
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
                <h3 class="card-title">Daftar Proyek</h3>
                {{-- <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Jobdesk </a> --}}
                {{-- <a href="{{ url('/artikel')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-print"></i> Kembali ke artikel</a> --}}
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                  <section class="row">
                    <div class="col-md-12">
                        <h4>Proyek yang diikuti</h4>
                        <div class="row">
                            @foreach ($proyek as $item)
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="{{ asset('img/proyek/'.$item->gambar)}}" class="card-img-top p-2" alt="...">
                                        <div class="card-body">
                                        <h5 class="card-title">{{ $item->nama_proyek}}</h5>
                                        <p class="card-text">{{ $item->detail_proyek}}</p>
                                        <span>status proyek {{ $item->status_proyek}}</span><hr>
                                        <a href="{{ url('/detailproyek/'.Crypt::encryptString($item->idproyek))}}" class="btn btn-primary">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h4>Daftar Proyek</h4>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Gambar</th>
                                        <th>Nama Proyek</th>
                                        <th>Waktu Pelaksanaan</th>
                                        <th>Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-capitalize">
                                    @forelse ($proyek as $item)
                                    <tr>
                                            <td class="text-center">{{ $loop->iteration}}</td>
                                            <td class="text-center"><img src="{{ asset('/img/proyek/'.$item->gambar)}}" alt="{{ $item->gambar}}" width="100px"></td>
                                            <td>{{ $item->nama_proyek}}</td>
                                            <td>{{ $item->tgl_dimulai.' - '.$item->tgl_berakhir}}</td>
                                            <td>{{ $item->status_proyek}}</td>
                                            <td><a href="{{ url('/detailproyek/'.Crypt::encryptString($item->idproyek))}}" class="btn btn-primary btn-sm btn-block">Selengkapnya</a></td>
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
                        <label for="" class="col-md-4 p-2">Nama Jobdesk</label>
                        <input type="text" name="nama_jobdesk" id="nama_jobdesk" class="form-control col-md-8" placeholder="Masukkan jobdesk" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Keterangan Jobdesk</label>
                        <textarea name="keterangan_jobdesk" id="keterangan_jobdesk" cols="30" rows="4" class="form-control col-md-8" required></textarea>
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
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #nama_jobdesk').val(nama_jobdesk);
            modal.find('.modal-body #status_jobdesk').val(status_jobdesk);
            modal.find('.modal-body #keterangan_jobdesk').val(keterangan_jobdesk);
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

