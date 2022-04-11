<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Daftar Paket</title>
  </head>
  <body>
    <main class="container-fluid">
        <header>
            <h3>DAFTAR PAKET LEBARAN</h3>
        </header>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                          Daftar Barang yang akan dibeli
                        </div>
                        <div class="card-body">
                            <header class="mb-2">
                                <a href="" data-toggle="modal" data-target="#tambah" class="btn btn-primary btn-sm">tambah barang</a>
                            </header>
                            <section class="row">
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($paket as $item)
                                @php
                                    $total = $total + $item->harga
                                @endphp
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="{{ asset('img/paket/'.$item->gambar) }}" class="card-img-top" alt="gambar">
                                        <div class="card-body">
                                          <h5 class="card-title">{{ $item->nama }}</h5>
                                          <p>{{ $item->kategori }}</p>
                                          <a href="{{ url('paket?s=nonpaket&id='.$item->id) }}" class="btn btn-primary">Pindahkan</a>
                                        </div>
                                      </div>
                                </div>
                                @endforeach
                                <div class="col-md-12 p-2">
                                    <div class="bg-info text-right text-white p-2">
                                       <p>{{ rupiah($total) }}</p>
                                    </div>
                                </div>
                            </section>
                        </div>
                      </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                          Daftar Barang referensi tidak dibeli
                        </div>
                        <div class="card-body">
                            <section class="row">
                                @foreach ($nonpaket as $item)
                                <div class="card" style="width: 18rem;">
                                    <img src="{{ asset('img/paket/'.$item->gambar) }}" class="card-img-top" alt="gambar">
                                    <div class="card-body">
                                      <h5 class="card-title">{{ $item->nama }}</h5>
                                      <p>{{ $item->kategori }}</p>
                                      <a href="{{ url('paket?s=paket&id='.$item->id) }}" class="btn btn-primary">Pindahkan</a>
                                    </div>
                                  </div>
                                @endforeach
                            </section>
                        </div>
                      </div>
                </div>
            </div>
        </section>
    </main>

  <!-- Modal -->
  <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <form action="{{ url('paket') }}" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                @csrf
                <section>
                    <div class="form-group">
                        <label for="">Nama Barang</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="text" name="harga" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="kategori" id="" class="form-control">
                            <option value="kaleng">Kaleng</option>
                            <option value="minuman">Minuman</option>
                            <option value="snack">Snack</option>
                            <option value="bahan pokok">Bahan Pokok</option>
                            <option value="Pendukung">Pendukung</option>
                            <option value="Manisan">Manisan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">gambar</label>
                        <input type="file" name="gambar" class="form-control" required>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </div>
        </form>
      </div>
    </div>
  </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>