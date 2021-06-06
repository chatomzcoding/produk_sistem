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
if (! function_exists('list_leveluser')) {
    function list_leveluser()
    {
        $level  = ['admin','anggota'];

        return $level;
    }
}
// daftar status anggota cikara
if (! function_exists('list_statusanggota')) {
    function list_statusanggota()
    {
        $level  = ['anggota','magang','member'];
        return $level;
    }
}
// daftar status anggota
if (! function_exists('list_levelproyek')) {
    function list_levelproyek()
    {
        $level  = ['personal','instansi','perusahaan','organisasi'];
        return $level;
    }
}
// daftar status proyek
if (! function_exists('list_statusproyek')) {
    function list_statusproyek()
    {
        $level  = ['berjalan','selesai','berhenti','menunggu'];
        return $level;
    }
}
// daftar tingkatan jobdesk
if (! function_exists('list_tingkatanjobdesk')) {
    function list_tingkatanjobdesk()
    {
        $result  = ['harian','mingguan','bulanan','kondisional'];
        return $result;
    }
}
// daftar skala prioritas
if (! function_exists('list_skalaprioritas')) {
    function list_skalaprioritas()
    {
        $result  = ['normal','penting'];
        return $result;
    }
}

