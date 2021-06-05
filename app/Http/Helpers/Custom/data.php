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

// cek photo null apa tidak
if (! function_exists('list_leveluser()')) {
    function list_leveluser()
    {
        $level  = ['admin','anggota'];

        return $level;
    }
}
// cek photo null apa tidak
if (! function_exists('list_statusanggota()')) {
    function list_statusanggota()
    {
        $level  = ['anggota','magang','member'];
        return $level;
    }
}

