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
                  <h4>Daftar Layanan Mentoring {{ $layanan->nama_layanan }} (Status Proses)</h4>
                <a href="{{ url('daftarlayanan') }}" class="btn btn-outline-secondary btn-flat btn-sm"><i class="fas fa-angle-left"></i> Kembali </a>
                <a href="#" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah</a>
                <a href="" class="btn btn-outline-info btn-flat btn-sm float-right"><i class="fas fa-sync"></i> perbaharui Chat </a>
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                  @if (count($mentoring) > 0)
                    <section class="mb-3">
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
                        <hr>
                    </section>
                  @endif
                            @forelse ($mentoring as $item)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="media">
                                                <img src="{{ asset('img/user/'.$item->photo) }}" class="align-self-start mr-3" alt="..." width="50px">
                                                <div class="media-body">
                                                  <h6 class="mt-0">{{ $item->name}} 
                                                    @if ($item->name == $user->name)
                                                        <button type="button" data-toggle="modal" data-nama="{{ $item->nama }}" data-link="{{ $item->link }}" data-keterangan="{{ $item->keterangan }}"  data-id="{{ $item->id }}" data-target="#ubah" title="" class="btn btn-success btn-sm float-right" data-original-title="Edit Task">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    @endif
                                                </h6><hr>
                                                  <h5 class="text-capitalize">{{ $item->nama }}</h5>
                                                  @if (!is_null($item->keterangan))
                                                  <i class="text-secondary">Catatan : {{ $item->keterangan}}</i> <br>
                                                  @endif
                                                  @if (!is_null($item->gambar))
                                                  <p>
                                                      <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                          <i class="fas fa-image"></i> Lihat Gambar
                                                      </button>
                                                    </p>
                                                    <div class="collapse" id="collapseExample">
                                                        <div class="card card-body">
                                                            <a href="{{ asset('/img/layanan/'.$item->gambar)}}" target="_blank">
                                                                <img src="{{ asset('/img/layanan/'.$item->gambar)}}" alt="" class="img-fluid">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if (!is_null($item->link))
                                                    link : <a href="{{ $item->link }}" target="_blank">referensi mentoring</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 border p-2">
                                            @if (!is_null($item->diskusi))
                                            @php
                                                $diskusi = json_decode($item->diskusi);
                                            @endphp
                                            <div class="direct-chat-messages">
                                            @foreach ($diskusi as $key)
                                            @if ($key->nama == Auth::user()->name)
                                            <div class="direct-chat-msg">
                                                <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-left">{{ $key->nama }}</span>
                                                <span class="direct-chat-timestamp float-right small">{{ date_indo($key->tanggal).' '.$key->jam }}</span>
                                                </div>
                                                <img class="direct-chat-img" src="{{ asset('img/user/'.$key->photo) }}" alt="message user image">
                                                <div class="direct-chat-text small text-left">
                                                    {{ $key->isi }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="direct-chat-msg right">
                                                <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-right">{{ $key->nama }}</span>
                                                <span class="direct-chat-timestamp float-left small">{{ date_indo($key->tanggal).' '.$key->jam }}</span>
                                                </div>
                                                <img class="direct-chat-img" src="{{ asset('img/user/'.$key->photo) }}" alt="message user image">
                                                <div class="direct-chat-text small text-left">
                                                    {{ $key->isi }}
                                                </div>
                                            </div>
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
                                            <input type="hidden" name="jam" value="{{ jam_sekarang() }}">
                                            <input type="hidden" name="diskusi" value="TRUE">
                                            <div class="input-group">
                                                <input type="text" name="isi" placeholder="ketik disini ..." class="form-control form-control-sm">
                                                <span class="input-group-append">
                                                  <button type="submit"  class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i></button>
                                                </span>
                                              </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                              <div class="text-center">
                                -- belum ada data --
                              </div>
                            @endforelse
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
                        <label for="" class="col-md-4 p-2">Judul Mentoring</label>
                        <input type="text" name="nama" id="nama" class="form-control col-md-8" placeholder="berikan laporan pengujian/mentoring/masukan dll" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Link (opsional)</label>
                        <input type="url" name="link" id="link" class="form-control col-md-8" placeholder="masukkan tambahan link video, website dll">
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

    <div class="modal fade" id="ubah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ route('layananmentoring.update','test')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ubah" value="TRUE">
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Layanan Mentoring</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" name="id" id="id">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Judul Mentoring</label>
                        <input type="text" name="nama" id="nama" class="form-control col-md-8" placeholder="berikan laporan pengujian/mentoring/masukan dll" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Link (opsional)</label>
                        <input type="url" name="link" id="link" class="form-control col-md-8" placeholder="masukkan tambahan link video, website dll">
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
            <button type="submit" class="btn btn-success"><i class="fas fa-pen"></i> SIMPAN PERUBAHAN</button>
            </div>
            </form>
        </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $('#ubah').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var nama = button.data('nama')
        var link = button.data('link')
        var keterangan = button.data('keterangan')
        var id = button.data('id')

        var modal = $(this)

        modal.find('.modal-body #nama').val(nama);
        modal.find('.modal-body #link').val(link);
        modal.find('.modal-body #keterangan').val(keterangan);
        modal.find('.modal-body #id').val(id);
    })
</script>
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

