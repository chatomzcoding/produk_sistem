@extends('layouts.admin')

@section('title')
    STATISTK - SHUTTERSTOCK
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Shutterstock</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Statistik Shutterstock</li>
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                @if ($user->level == 'pkl')
                <h3 class="card-title">Statistik ShutterStock</h3>
                    
                @else
                <a href="#" data-toggle="modal" data-target="#tambah" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Akun</a>
                    
                @endif
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
                <section>
                  @if ($user->level <> 'pkl')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                            
                                        <div class="info-box-content">
                                          <span class="info-box-text">Total Keseluruhan <span class="float-right">({{ $data['total']['akun'] }} akun)</span></span>
                                          <span class="info-box-number">${{ $data['total']['nilai'].' | '.$data['total']['rp']}}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                      </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                            
                                        <div class="info-box-content">
                                          <span class="info-box-text">Total Pencairan <span class="float-right">({{ $data['perhitungan']['akun'] }} akun)</span></span>
                                          <span class="info-box-number">${{ $data['perhitungan']['nilai'].' | '.$data['perhitungan']['rp']}}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                      </div>
                                </div>
                              
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                                        <div class="info-box-content">
                                          <span class="info-box-text">Sisa dari pencairan  <span class="float-right">({{ $data['sisa']['akun'] }} akun)</span></span>
                                          <span class="info-box-number">${{ $data['sisa']['nilai'].' | '.$data['sisa']['rp']}}</span>

                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user"></i></span>
                                        <div class="info-box-content">
                                          <span class="info-box-text">Akun Banned</span>
                                          <span class="info-box-number">{{ $data['akunbanned']}}</span>

                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body p-2">
                                    <form action="" method="get">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Nilai 1 Dollar ke Rupiah</label>
                                            <input type="number" name="dr" value="{{ $data['dr'] }}" placeholder="rubah margin rupiah disini" class="form-control">
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-md-4">Batas minimal pencarian</label>
                                            <input type="number" name="batas" value="{{ $data['batas'] }}" placeholder="batas pencarian" class="form-control col-md-4">
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> UPDATE</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  @endif

                    {{-- data akun --}}
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-header bg-secondary">
                            @if ($user->level <> 'pkl')
                              <strong>Akun Dibawah Pencairan</strong>
                            @else
                              <strong>Daftar Akun</strong>
                            @endif
                          </div>
                          <div class="card-body">
                            <div class="table-responsive">
                              <table class="table table-striped" id="example1">
                                <thead>
                                  <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Nama Akun</th>
                                    <th width="15%">Gambar</th>
                                    <th>Keterangan</th>
                                    @if ($user->level <> 'pkl')
                                    <th>Riwayat</th>
                                      <th width="5%">Jumlah</th>
                                    @endif
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($data['akun']['bawah'] as $item)
                                    @php
                                          $banned = TRUE;
                                          $manajemen    = DbSistem::showtablefirst('manajemen_jobdesk',['id',$item->manajemenjobdesk_id]);
                                          if ($manajemen) {
                                            $catatan = $manajemen->catatan;
                                            $riwayat      = DbSistem::showtable('monitoring_jobdesk',['manajemenjobdesk_id',$item->manajemenjobdesk_id]);
                                          } else {
                                            $riwayat      = NULL;
                                            $catatan      = $item->catatan;
                                          }
                                          $nama         = strtolower(substr($catatan,5,strlen($catatan)));
                                          $pembayaran   = DbSistem::showtablefirst('pembayaran_proyek',['nama_pembayaran',$nama]);
                                          if ($pembayaran) {
                                            $ket = explode('||',$pembayaran->keterangan_pembayaran);
                                            if (in_array('banned',$ket)) {
                                              $banned = FALSE;
                                            }
                                            if (in_array('ditunda',$ket) AND Auth::user()->level == 'pkl') {
                                              $banned = FALSE;
                                            }
                                          }
                                      @endphp
                                      @if ($banned)
                                        <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $nama}}</td>
                                          <td> 
                                            @if ($pembayaran)
                                              @if (is_null($pembayaran->bukti_pembayaran))
                                                bukti tidak diupload
                                              @else
                                                <a href="{{ asset('/img/proyek/'.$pembayaran->bukti_pembayaran)}}" target="_blank"><img src="{{ asset('/img/proyek/'.$pembayaran->bukti_pembayaran)}}" alt="" width="100px"></a>
                                              @endif
                                            @endif
                                          </td>
                                          <td>
                                            @if ($pembayaran)
                                              @if ($user->level <> 'pkl')
                                                @for ($i = 0; $i < count($ket); $i++)
                                                    {{ $ket[$i] }} <br>
                                                @endfor
                                              @else
                                                  {{ end($ket) }}
                                              @endif
                                            @endif
                                          </td>
                                          @if ($user->level <> 'pkl')
                                          <td>
                                            @if (!is_null($riwayat))
                                              @forelse ($riwayat as $j)
                                                @if (is_null($j->jumlah))
                                                    (belum diisi) ||
                                                @else
                                                  {{ $j->jumlah }} ||
                                                @endif
                                              @empty
                                              @endforelse
                                            @endif
                                          </td>
                                          <td>
                                            @isset($item->jumlah)
                                              ${{ $item->jumlah }}
                                            @endisset
                                          </td>
                                          @endif
                                        </tr>
                                      @endif
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @if ($user->level <> 'pkl')
                      <div class="row">
                        <div class="col-md-12">
                          <div class="card">
                            <div class="card-header bg-success">
                              <strong>Akun Diatas Pencairan</strong>
                            </div>
                            <div class="card-body">
                              <div class="table-responsive">
                                <table class="table table-striped"  id="example2">
                                  <thead>
                                    <tr>
                                      <th width="5%">No</th>
                                      <th width="20%">Nama Akun</th>
                                      <th width="15%">Gambar</th>
                                      <th>Keterangan</th>
                                      <th width="5%">Jumlah</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($data['akun']['atas'] as $item)
                                        @php
                                            $manajemen  = DbSistem::showtablefirst('manajemen_jobdesk',['id',$item->manajemenjobdesk_id]);
                                            $nama       = strtolower(substr($manajemen->catatan,5,strlen($manajemen->catatan)));
                                            $pembayaran  = DbSistem::showtablefirst('pembayaran_proyek',['nama_pembayaran',$nama]);
                                        @endphp
                                        <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $nama }}</td>
                                          <td> 
                                            @if ($pembayaran)
                                              @if (is_null($pembayaran->bukti_pembayaran))
                                                bukti tidak diupload
                                              @else
                                                <a href="{{ asset('/img/proyek/'.$pembayaran->bukti_pembayaran)}}" target="_blank"><img src="{{ asset('/img/proyek/'.$pembayaran->bukti_pembayaran)}}" alt="" width="100px"></a>
                                              @endif
                                            @endif
                                          </td>
                                          <td>
                                            @if ($pembayaran)
                                              @php
                                                  $ket = explode('||',$pembayaran->keterangan_pembayaran)
                                              @endphp
                                              @for ($i = 0; $i < count($ket); $i++)
                                                  {{ $ket[$i] }} <br>
                                              @endfor
                                            @endif
                                          </td>
                                          <td>
                                            @if ($user->level <> 'pkl')
                                            ${{ $item->jumlah }}
                                            @endif
                                          </td>

                                        </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif
                </section>
              </div>
            </div>
          </div>
        </div>
    </div>
    @if ($user->level <> 'pkl')
      <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ url('/manajemenjobdesk')}}" method="post">
                @csrf
                <input type="hidden" name="anggota_id" value="{{ $user->anggota->id }}">
                <input type="hidden" name="jobdesk_id" value="{{ $jobdesk->id }}">
                <input type="hidden" name="tingkatan" value="harian">
                <input type="hidden" name="skala_prioritas" value="normal">
            <div class="modal-header">
            <h4 class="modal-title">Tambah AKun Shutter</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Akun</label>
                        <input type="text" name="catatan" class="form-control col-md-8" value="akun " required>
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
    @endif
@endsection
@section('script')
    
    <script>
        $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#example2").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        // $('#example2').DataTable({
        //     "paging": true,
        //     "lengthChange": false,
        //     "searching": false,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": false,
        //     "responsive": true,
        // });
        });
    </script>
@endsection

