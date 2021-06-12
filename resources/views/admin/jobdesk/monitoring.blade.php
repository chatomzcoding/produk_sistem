@extends('layouts.admin')

@section('title')
    ADMIN - Monitoring Jobdesk
@endsection
@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Monitoring</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Daftar Monitoring Jobdesk</li>
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
              <div class="card-header bg-primary text-white">
                <h3 class="card-title">Monitoring Jobdesk Tanggal {{ date_indo(tgl_sekarang())}}</h3>
                {{-- <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Jobdesk </a> --}}
                {{-- <a href="{{ url('/artikel')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-print"></i> Kembali ke artikel</a> --}}
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama / Jobdesk</th>
                                <th width="20%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($anggota as $item)
                                {{-- cek apakah anggota ini punya jobdesk --}}
                                @if (DbSistem::countData('manajemen_jobdesk',['anggota_id',$item->id]) > 0)
                                    <tr>
                                        <td class="text-center">{{ $no}}</td>
                                        <td colspan="4">{{ $item->name}}</td>
                                    </tr>
                                    {{-- tampilkan jobdsek dibawah nama --}}
                                    @forelse (DbSistem::listjobdeskanggotahariini($item->id) as $item2)
                                        <tr>
                                            <th></th>
                                            <th>- {{ $item2->nama_jobdesk}} <br> &nbsp;&nbsp;<small>{{ $item2->keterangan_jobdesk}}</small></th>
                                                @switch($item2->status_monitoring)
                                                    @case('proses')
                                                        <td>
                                                            <span class="badge badge-warning w-100">DALAM PROSES PENGERJAAN</span>
                                                        </td>
                                                        <td></td>
                                                        @break
                                                    @case('selesai')
                                                        <td>
                                                            <span class="badge badge-success w-100">JOBDESK SELESAI</span>
                                                        </td>
                                                        <td></td>
                                                        @break
                                                    @case('revisi')
                                                        <td>
                                                            <span class="badge badge-danger w-100">PROSES REVISI</span>
                                                        </td>
                                                        <td></td>
                                                        @break
                                                    @case('menunggu')
                                                        <td>
                                                            <span class="badge badge-secondary w-100">MENUNGGU PENGECEKAN</span>
                                                        </td>
                                                        <td><a href="{{ url('admin/cekjobdesk/'.Crypt::encryptString($item2->id))}}" class="btn btn-success btn-sm">cek proggres</a></td>
                                                        @break
                                                    @default
                                                @endswitch
                                        </tr>
                                    @empty
                                        <tr>
                                            <th class="text-danger text-center" colspan="4">Belum mengambil jobdesk hari ini</th>
                                        </tr>
                                    @endforelse

                                    @php
                                        $no++;
                                    @endphp
                                @endif
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
        {{-- bulanan --}}
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title">Monitoring Jobdesk Bulanan {{ bulan_indo()}}</h3>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama / Jobdesk</th>
                                <th width="20%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($anggota as $item)
                                {{-- cek apakah anggota ini punya jobdesk --}}
                                @if (DbSistem::countData('manajemen_jobdesk',['anggota_id',$item->id]) > 0)
                                    <tr>
                                        <td class="text-center">{{ $no}}</td>
                                        <td colspan="4">{{ $item->name}}</td>
                                    </tr>
                                    {{-- tampilkan jobdsek dibawah nama --}}
                                    @forelse (DbSistem::listjobdeskanggotabulanini($item->id) as $item2)
                                        <tr>
                                            <th></th>
                                            <th>- {{ $item2->nama_jobdesk}} <br> &nbsp;&nbsp;<small>{{ $item2->keterangan_jobdesk}}</small></th>
                                                @switch($item2->status_monitoring)
                                                    @case('proses')
                                                        <td>
                                                            <span class="badge badge-warning w-100">DALAM PROSES PENGERJAAN</span>
                                                        </td>
                                                        <td></td>
                                                        @break
                                                    @case('selesai')
                                                        <td>
                                                            <span class="badge badge-success w-100">JOBDESK SELESAI</span>
                                                        </td>
                                                        <td></td>
                                                        @break
                                                    @case('revisi')
                                                        <td>
                                                            <span class="badge badge-danger w-100">PROSES REVISI</span>
                                                        </td>
                                                        <td></td>
                                                        @break
                                                    @case('menunggu')
                                                        <td>
                                                            <span class="badge badge-secondary w-100">MENUNGGU PENGECEKAN</span>
                                                        </td>
                                                        <td><a href="{{ url('admin/cekjobdesk/'.Crypt::encryptString($item2->id))}}" class="btn btn-success btn-sm">cek proggres</a></td>
                                                        @break
                                                    @default
                                                @endswitch
                                        </tr>
                                    @empty
                                        <tr>
                                            <th class="text-danger text-center" colspan="4">Belum mengambil jobdesk hari ini</th>
                                        </tr>
                                    @endforelse

                                    @php
                                        $no++;
                                    @endphp
                                @endif
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

