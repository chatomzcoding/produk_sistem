@extends('layouts.admin')

@section('title')
    DATA MAGANG
@endsection

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Magang</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
      <li class="breadcrumb-item active">Daftar Pemagang</li>
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
                <h3 class="card-title">List Data Magang Cikara Studio</h3>
              </div>
              <div class="card-body">
                  @include('sistem.notifikasi')
                  <section class="mb-2">
                    <a href="{{ url('statistik/tambahmagang') }}" class="btn btn-primary btn-sm">Tambah Data Baru</a>
                  </section>
                  <div class="row">
                    @foreach ($data as $item)
                      <div class="col-md-3">
                        <div class="card">
                          <img src="https://sistem.zelnara.com/public/img/chatomz/orang/{{ $item->orang->photo }}" class="card-img-top" alt="...">
                          <div class="card-body">
                            <h5 class="card-title text-capitalize"><strong>{{ $item->orang->first_name.' '.$item->orang->last_name }}</strong></h5>
                            <p class="card-text small">
                              ({{ $item->information }}) <br>
                              {{ ucwords($item->orang->place_birth).', '.date_indo($item->orang->date_birth) }} <br>
                              <i>{{ $item->orang->home_address }}</i> <br>
                            </p>
                            {{-- <a href="#" class="btn btn-primary">Detail</a> --}}
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection

