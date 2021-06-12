@extends('layouts.admin')

@section('title')
    Monitoring
@endsection
@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Monitoring</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('daftarjobdesk')}}">Daftar Jobdesk</a></li>
      <li class="breadcrumb-item active">Detail Monitoring</li>
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->
@endsection
@section('content')
    <div class="container-fluid">
        @include('sistem.notifikasi')
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Jobdesk Hari ini</h3>
                {{-- <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Jobdesk </a> --}}
                {{-- <a href="{{ url('/artikel')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-print"></i> Kembali ke artikel</a> --}}
              </div>
              <div class="card-body">
                  @if (count($listjobdesk) > 0)
                    @if (count($jobdesk) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">Nama Jobdesk</th>
                                        <th>Keterangan</th>
                                        <th width="10%">Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-capitalize">
                                    @forelse ($jobdesk as $item)
                                    <tr>
                                            <td class="text-center">{{ $loop->iteration}}</td>
                                            <td>{{ $item->nama_jobdesk}}</td>
                                            <td>{{ $item->keterangan_jobdesk}} <br><small>{{ $item->catatan}}</small></td>
                                            <td class="text-center">{!! status_monitoring($item->status_monitoring)!!}</td>
                                            <td class="text-center" width="10%">
                                                @switch($item->status_monitoring)
                                                    @case('proses')
                                                        <a href="{{ url('/posting/'.Crypt::encryptString($item->id))}}" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i> posting</a>
                                                        @break
                                                    @case('revisi')
                                                    <a href="{{ url('/posting/'.Crypt::encryptString($item->id).'/edit')}}" class="btn btn-danger btn-sm"><i class="fas fa-pen"></i> revisi</a>
                                                        @break
                                                    @case('selesai')
                                                    <span class="badge badge-success">Jobdesk Selesai</span>
                                                        @break
                                                    @default
                                                @endswitch
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="5">tidak ada data</td>
                                        </tr>
                                    @endforelse
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <form action="{{ url('/monitoringjobdesk')}}" method="post">
                                @csrf
                                <input type="hidden" name="anggota_id" value="{{ $anggota->id}}">
                                <input type="hidden" name="tingkatan" value="harian">
                                <button class="btn btn-outline btn-secondary"><i class="fas fa-plus-circle"></i> Ambil Jobdesk Hari ini</button>
                            </form>
                        </div>
                    @endif
                  @else
                     <div class="alert alert-danger">
                        <h5>Maaf! belum ada jobdesk yang diberikan.</h5>
                     </div>
                  @endif
              </div>
            </div>
          </div>
        </div>
        {{-- jobdesk bulanan --}}
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Jobdesk Bulan ini</h3>
              </div>
              <div class="card-body">
                  @if (count($listjobdeskbulanan) > 0)
                    @if (count($jobdeskbulanan) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">Nama Jobdesk</th>
                                        <th>Keterangan</th>
                                        <th width="10%">Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-capitalize">
                                    @forelse ($jobdeskbulanan as $item)
                                    <tr>
                                            <td class="text-center">{{ $loop->iteration}}</td>
                                            <td>{{ $item->nama_jobdesk}}</td>
                                            <td>{{ $item->keterangan_jobdesk}} <br><small>{{ $item->catatan}}</small></td>
                                            <td class="text-center">{!! status_monitoring($item->status_monitoring)!!}</td>
                                            <td class="text-center" width="10%">
                                                @switch($item->status_monitoring)
                                                    @case('proses')
                                                        <a href="{{ url('/posting/'.Crypt::encryptString($item->id))}}" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i> posting</a>
                                                        @break
                                                    @case('revisi')
                                                    <a href="{{ url('/posting/'.Crypt::encryptString($item->id).'/edit')}}" class="btn btn-danger btn-sm"><i class="fas fa-pen"></i> revisi</a>
                                                        @break
                                                    @case('selesai')
                                                    <span class="badge badge-success">Jobdesk Selesai</span>
                                                        @break
                                                    @default
                                                @endswitch
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="5">tidak ada data</td>
                                        </tr>
                                    @endforelse
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <form action="{{ url('/monitoringjobdesk')}}" method="post">
                                @csrf
                                <input type="hidden" name="anggota_id" value="{{ $anggota->id}}">
                                <input type="hidden" name="tingkatan" value="bulanan">
                                <button class="btn btn-outline btn-secondary"><i class="fas fa-plus-circle"></i> Ambil Jobdesk Bulan ini</button>
                            </form>
                        </div>
                    @endif
                  @else
                     <div class="alert alert-danger">
                        <h5>Maaf! belum ada jobdesk yang diberikan.</h5>
                     </div>
                  @endif
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

