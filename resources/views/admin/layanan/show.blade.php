@extends('layouts.admin')

@section('title')
    ADMIN - Layanan
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Layanan</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('layanan')}}">Daftar Layanan</a></li>
      <li class="breadcrumb-item active">Detail Layanan</li>
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
                {{-- <a href="{{ url('/artikel')}}" class="btn btn-outline-dark btn-flat btn-sm"><i class="fas fa-print"></i> Kembali ke artikel</a> --}}
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                  <section class="row">
                      <div class="col-md-4">
                        <img src="{{ asset('/img/layanan/'.$layanan->poto_layanan)}}" alt="" class="img-fluid">
                      </div>
                      <div class="col-md-8">
                          <table class="table">
                            <tr>
                                <th>Nama Layanan</th>
                                <td>: {{ $layanan->nama_layanan}}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>: {{ $layanan->kategori}}</td>
                            </tr>
                            <tr>
                                <th>Tentang Layanan</th>
                                <td>: {{ $layanan->tentang_layanan}}</td>
                            </tr>
                            <tr>
                                <th>Harga Beli</th>
                                <td>: {{ rupiah($layanan->harga_beli)}}</td>
                            </tr>
                            <tr>
                                <th>Harga Jual</th>
                                <td>: {{ rupiah($layanan->harga_jual)}}</td>
                            </tr>
                            <tr>
                                <th>Link</th>
                                <td>: <a href="{{ $layanan->link}}" target="_blank">{{ $layanan->link}}</a></td>
                            </tr>
                          </table>
                      </div>
                  </section>

                  <section class="row">
                    <div class="col-md-12">
                        <hr>
                        
                <h2>Daftar Client <a href="#" class="btn btn-outline-primary btn-flat btn-sm float-right" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Client Pemesan Layanan </a></h2>
                        <div class="table-responsive">
                          <table id="example1" class="table table-bordered table-striped">
                              <thead class="text-center">
                                  <tr>
                                      <th width="5%">No</th>
                                      <th>Nama Client</th>
                                      <th>Tanggal Pemesanan</th>
                                      <th>Harga</th>
                                      <th>Keterangan</th>
                                      <th>Aksi</th>
                                  </tr>
                              </thead>
                              <tbody class="text-capitalize">
                                  @forelse ($manajemen as $item)
                                      <tr>
                                          <td class="text-center">{{ $loop->iteration}}</td>
                                          <td>{{ $item->nama}}</td>
                                          <td>{{ date_indo($item->tgl_pemesanan)}}</td>
                                          <td>{{ rupiah($item->harga)}}</td>
                                          <td>{{ $item->keterangan}}</td>
                                          <td class="text-center">
                                              <form id="data-{{ $item->id }}" action="{{ url('/manajemenlayanan/'.$item->id)}}" method="post">
                                                  @csrf
                                                  @method('delete')
                                              </form>
                                              {{-- <a href="{{ url('/manajemenlayanan/'.Crypt::encryptString($item->id))}}" class="btn btn-primary btn-sm"><i class="fas fa-file"></i></a> --}}
                                              <button type="button" data-toggle="modal" data-client_id="{{ $item->client_id }}" data-tgl_pemesanan="{{ $item->tgl_pemesanan }}" data-client_id="{{ $item->client_id }}" data-keterangan="{{ $item->keterangan }}" data-harga="{{ $item->harga }}" data-id="{{ $item->id }}" data-target="#ubah" title="" class="btn btn-success btn-sm" data-original-title="Edit Task">
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
                  </section>
              </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h4>Daftar Layanan Monitoring</h4>
                  <a href="" class="btn btn-outline-info btn-flat btn-sm float-right"><i class="fas fa-sync"></i> perbaharui Chat </a>
                </div>
                <div class="card-body">
                    <section>
                      <div class="progress-group">
                          Proggres Monitoring (proses/total)
                          <span class="float-right"><b>{{ $total['proses'] }}</b>/{{ $total['jumlah'] }}</span>
                          <div class="progress progress-sm">
                              @php
                                  $presentase = $total['proses']/$total['jumlah']*100;
                              @endphp
                            <div class="progress-bar bg-primary" style="width: {{ $presentase }}%"></div>
                          </div>
                        </div>
                    </section>
                    <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-striped">
                          <thead class="text-center">
                              <tr>
                                  <th width="5%">No</th>
                                  <th>Aksi</th>
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
                                      <td class="text-center">
                                        <form id="data-{{ $item->id }}" action="{{url('/layananmentoring',$item->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            </form>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm btn-flat">Aksi</button>
                                                <button type="button" class="btn btn-info btn-sm btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                  <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <button type="button" data-toggle="modal" data-status="{{ $item->status }}" data-id="{{ $item->id }}" data-target="#ubahmentoring" title="" class="dropdown-item text-success" data-original-title="Edit Task">
                                                    <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                  <div class="dropdown-divider"></div>
                                                  <button onclick="deleteRow( {{ $item->id }} )" class="dropdown-item text-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                                                </div>
                                            </div>
                                    </td>
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
    {{-- modal --}}
    {{-- modal tambah --}}
    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ url('/manajemenlayanan')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="layanan_id" value="{{ $layanan->id}}">
            <div class="modal-header">
            <h4 class="modal-title">Tambah Layanan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <section class="p-3">
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Nama Client</label>
                        <select name="client_id" id="client_id" class="form-control col-md-8">
                            @foreach ($client as $item)
                                <option value="{{ $item->id}}">{{ $item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal Pemesanan</label>
                        <input type="date" name="tgl_pemesanan" id="tgl_pemesanan" class="form-control col-md-8" placeholder="Nama Layanan" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Harga</label>
                        <input type="text" name="harga" value="{{ $layanan->harga_jual}}" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="4" class="form-control col-md-8" required></textarea>
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
            <form action="{{ route('manajemenlayanan.update','test')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Manajemen Layanan</h4>
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
                                <option value="{{ $item->id}}">{{ $item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Tanggal Pemesanan</label>
                        <input type="date" name="tgl_pemesanan" id="tgl_pemesanan" class="form-control col-md-8" placeholder="Nama Layanan" required>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Harga</label>
                        <input type="text" name="harga" value="{{ $layanan->harga_jual}}" class="form-control col-md-8">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 p-2">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="4" class="form-control col-md-8" required></textarea>
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
    <div class="modal fade" id="ubahmentoring">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ route('layananmentoring.update','test')}}" method="post">
                @csrf
                @method('patch')
            <div class="modal-header">
            <h4 class="modal-title">Edit Layanan Mentoring</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="status" value="selesai">
                <section class="p-3">
                    <p>Ubah Status Menjadi Selesai</p>
                </section>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
            <button type="submit" class="btn btn-success"><i class="fas fa-pen"></i> UBAH STATUS</button>
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
            var tgl_pemesanan = button.data('tgl_pemesanan')
            var client_id = button.data('client_id')
            var keterangan = button.data('keterangan')
            var harga = button.data('harga')
            var id = button.data('id')
    
            var modal = $(this)
    
            modal.find('.modal-body #tgl_pemesanan').val(tgl_pemesanan);
            modal.find('.modal-body #client_id').val(client_id);
            modal.find('.modal-body #keterangan').val(keterangan);
            modal.find('.modal-body #harga').val(harga);
            modal.find('.modal-body #id').val(id);
        })
    </script>
    <script>
        $('#ubahmentoring').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
    
            var modal = $(this)
    
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

