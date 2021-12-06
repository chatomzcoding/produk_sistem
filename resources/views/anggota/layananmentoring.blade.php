@extends('layouts.admin')

@section('title')
    ADMIN - Layanan
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Layanan Mentoring</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('daftarlayanan')}}">Daftar Layanan</a></li>
      <li class="breadcrumb-item active">Detail Mentoring</li>
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
                  <h4>Daftar Layanan</h4>
                <a href="{{ url('daftarlayanan') }}" class="btn btn-outline-secondary btn-flat btn-sm"><i class="fas fa-angle-left"></i> Kembali </a>
                <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Mentoring </a>
                <a href="" class="btn btn-outline-info btn-flat btn-sm float-right"><i class="fas fa-sync"></i> perbaharui Chat </a>
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                  @if (count($mentoring) > 0)
                    <section>
                        <div class="progress-group">
                            Proggres Monitoring (selesai/total)
                            <span class="float-right"><b>{{ $total['selesai'] }}</b>/{{ $total['jumlah'] }}</span>
                            <div class="progress progress-sm">
                                @php
                                    $presentase = $total['selesai']/$total['jumlah']*100;
                                @endphp
                            <div class="progress-bar bg-primary" style="width: {{ $presentase }}%"></div>
                            </div>
                        </div>
                    </section>
                  @endif
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama User</th>
                                <th>Mentoring</th>
                                <th>Status</th>
                                <th>Diskusi</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @forelse ($mentoring as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration}}</td>
                                    <td>{{ $item->name}}</td>
                                    <td>{{ $item->nama}}
                                        <div>
                                            <img src="{{ asset('/img/layanan/'.$item->gambar)}}" alt="" width="100px">
                                        </div>
                                        <i class="text-secondary">Catatan : {{ $item->keterangan}}</i>
                                    </td>
                                    <td>
                                        @switch($item->status)
                                            @case('proses')
                                                <span class="badge badge-warning w-100">proses</span>
                                                @break
                                            @case('selesai')
                                                <span class="badge badge-success w-100">selesai</span>
                                                @break
                                            @default
                                                
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        @if (!is_null($item->diskusi))
                                            @php
                                                $diskusi = json_decode($item->diskusi);
                                            @endphp
                                            <div class="direct-chat-messages">
                                            @foreach ($diskusi as $key)
                                            @if ($key->nama == Auth::user()->name)
                                            {{-- chat untuk orang lain --}}
                                            <div class="direct-chat-msg">
                                                <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-left">{{ $key->nama }}</span>
                                                <span class="direct-chat-timestamp float-right">{{ $key->tanggal }}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="{{ asset('img/user/'.$key->photo) }}" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    {{ $key->isi }}
                                                </div>
                                            </div>
                                        @else
                                             <!-- chat untuk saya -->
                                            <div class="direct-chat-msg right">
                                                <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-right">{{ $key->nama }}</span>
                                                <span class="direct-chat-timestamp float-left">{{ $key->tanggal }}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="{{ asset('img/user/'.$key->photo) }}" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    {{ $key->isi }}
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->
                                        @endif
                                            @endforeach
                                            </div>
                                        @endif
                                        <form action="{{ url('layananmentoring') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="hidden" name="nama" value="{{ $user->name }}">
                                            <input type="hidden" name="photo" value="{{ $user->photo }}">
                                            <input type="hidden" name="tanggal" value="{{ tgl_sekarang() }}">
                                            <input type="hidden" name="diskusi" value="TRUE">
                                            <div class="input-group">
                                                <input type="text" name="isi" placeholder="ketik disini ..." class="form-control">
                                                <span class="input-group-append">
                                                  <button type="button" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                                                </span>
                                              </div>
                                        </form>
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

    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ url('/layananmentoring')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="status" value="proses">
                <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="modal-header">
            <h4 class="modal-title">Tambah Layanan Mentoring</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Mentoring</label>
                        <input type="text" name="nama" id="nama" class="form-control col-md-8" placeholder="berikan laporan pengujian/mentoring/masukan dll" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Keterangan (opsional)</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="4" class="form-control col-md-8"></textarea>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Gambar (opsional)</label>
                        <input type="file" name="gambar" class="form-control col-md-8">
                    </div>
                </section>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> KIRIM</button>
            </div>
        </form>
        </div>
        </div>
    </div>
@endsection

@section('script')
    
    <script>
        $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
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

