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
// daftar list mata uang
if (! function_exists('list_matauang')) {
    function list_matauang()
    {
        $level  = ['USD','IDR'];

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
// daftar kategori layanan
if (! function_exists('list_kategorilayanan')) {
    function list_kategorilayanan()
    {
        $result  = ['produk','jasa'];
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

// daftar status monitoring
if (! function_exists('list_statusmonitoring')) {
    function list_statusmonitoring()
    {
        $result  = ['proses','menunggu','selesai','revisi','gagal'];
        return $result;
    }
}
// status monitoring
if (! function_exists('status_monitoring')) {
    function status_monitoring($status)
    {
        $notif  = NULL;
        switch ($status) {
            case 'proses':
                $notif = "<span class='badge badge-warning'>$status</span>";
                break;
            case 'menunggu':
                $notif = "<span class='badge badge-secondary'>$status</span>";
                break;
            case 'selesai':
                $notif = "<span class='badge badge-success'>$status</span>";
                break;
            case 'revisi':
                $notif = "<span class='badge badge-danger'>$status</span>";
                break;
            
            default:
                # code...
                break;
        }
        return $notif;
    }
}
if (! function_exists('status_proyek')) {
    function status_proyek($status)
    {
        $notif  = NULL;
        switch ($status) {
            case 'berjalan':
                $notif = "<span class='badge badge-warning'>$status</span>";
                break;
            case 'menunggu':
                $notif = "<span class='badge badge-secondary'>$status</span>";
                break;
            case 'selesai':
                $notif = "<span class='badge badge-success'>$status</span>";
                break;
            case 'berhenti':
                $notif = "<span class='badge badge-danger'>$status</span>";
                break;
            
            default:
                # code...
                break;
        }
        return $notif;
    }
}

// dashboard
// daftar skala prioritas
if (! function_exists('dashboard_persentase')) {
    function dashboard_persentase($nilai1,$nilai2)
    {
        $result  = $nilai1/$nilai2 * 100;
        return $result;
    }
}
if (! function_exists('chart_tgljobdeskharian')) {
    function chart_tgljobdeskharian($tglhariini)
    {
        $tanggal = NULL;
        for ($i=1; $i <= $tglhariini; $i++) { 
            $tanggal .= $i.', ';
        }
        return $tanggal;
    }
}

