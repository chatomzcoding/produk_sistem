<?php 

// cek photo null apa tidak
if (! function_exists('orang_photo')) {
    function orang_photo($photo)
    {
        $nama_file     = 'orang.png';
        if (!is_null($photo)) {
            $nama_file = $photo;
        }
        return $nama_file;
    }
}

// daftar list level user
if (! function_exists('list_leveluser()')) {
    function list_leveluser()
    {
        $level  = ['admin','anggota'];

        return $level;
    }
}
// daftar status anggota cikara
if (! function_exists('list_statusanggota()')) {
    function list_statusanggota()
    {
        $level  = ['anggota','magang','member'];
        return $level;
    }
}
// daftar status anggota
if (! function_exists('list_statusclient()')) {
    function list_statusclient()
    {
        $level  = ['personal','instansi','perusahaan','organisasi'];
        return $level;
    }
}

