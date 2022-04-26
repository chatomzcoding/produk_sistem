@extends('layouts.admin')

@section('title')
    DATA MAGANG
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Magang</h1>
    <p>Tambah Pemagang Baru</p>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Tambah Pemagang</li>
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
                  <a href="{{ url('statistik/magang') }}" class="btn btn-secondary btn-sm">Kembali</a>
              </div>
              <div class="card-body">
                <form method="post" action="{{ url('/simpanmagang')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 p-4">
                            <div class="row mb-2">
                                  <label for="inlineinput" class="col-md-4 col-form-label">Nama Awal <strong class="text-danger">*</strong></label>
                                  <div class="col-8">
                                      <input type="text" class="form-control" name="first_name" value="{{ old('first_name')}}" id="inlineinput" required>
                                  </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inlineinput" class="col-md-4 col-form-label">Nama Akhir</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name')}}" id="inlineinput">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inlineinput" class="col-md-4 col-form-label">Alamat Rumah</label>
                                <div class="col-8">
                                    <textarea name="home_address" id="" cols="3 0" row mb-2s="3" class="form-control">{{ old('home_address')}}</textarea>
                              </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inlineinput" class="col-md-4 col-form-label">Tempat Lahir</label>
                                <div class="col-8">
                                    <input type="text" name="place_birth" class="form-control" id="inlineinput"  value="{{ old('place_birth')}}">
                              </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inlineinput" class="col-md-4 col-form-label">Tanggal Lahir</label>
                                <div class="col-8">
                                    <input type="date" name="date_birth" class="form-control" id="inlineinput" value="{{ old('date_birth')}}">
                              </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inlineinput" class="col-md-4 col-form-label">Pekerjaan</label>
                                <div class="col-8">
                                    <input type="text" name="job_status" class="form-control"  value="{{ old('job_status')}}">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6 p-4">
                            <div class="row mb-2">
                                <label for="inlineinput" class="col-md-4 col-form-label">Jenis Kelamin</label>
                                <div class="col-8">
                                    <select name="gender" id="" class="form-control">
                                        <option value="laki-laki">Laki - laki</option>
                                        <option value="perempuan">Perempuan</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                              </div>
                            </div>
                            <input type="hidden" name="nasionality" value="indonesia">
                            <div class="row mb-2">
                                <label for="inlineinput" class="col-md-4 col-form-label">Agama</label>
                                <div class="col-8">
                                    <select name="religion" id="" class="form-control">
                                        @foreach (kingdom_agama() as $item)
                                        <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                                        @endforeach
                                    </select>
                              </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inlineinput" class="col-md-4 col-form-label">Golongan Darah</label>
                                <div class="col-8">
                                    <select name="blood_type" id="" class="form-control">
                                        @foreach (kingdom_goldar() as $item)
                                          <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                                        @endforeach
                                    </select>
                              </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inlineinput" class="col-md-4 col-form-label">Asal Sekolah</label>
                                <div class="col-8">
                                    <input type="text" name="note" class="form-control" id="inlineinput" value="{{ old('note')}}">
                              </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inlineinput" class="col-md-4 col-form-label">Photo</label>
                                  <div class="col-8">
                                      <input type="file" name="photo">
                                  </div>
                            </div>
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> SIMPAN</button>
                            </div>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection

