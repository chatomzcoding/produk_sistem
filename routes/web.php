<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// HOMEPAGE
Route::get('/', function(){
    return redirect('/login');
});
Route::get('/register', function(){
    return redirect('/');
});

/*
-------------------------------------------------------------------------------------------------
*/

// PERCOBAAN LIVEWIRE
// Route::get('/example',[Example::class, 'render'])->name('example');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {


    // Route::get('member', Members::class)->name('member'); //Tambahkan routing ini

    // Umum
    Route::get('/dashboard', 'App\Http\Controllers\HomeController@index')->name('dashboard');

    // Route Admin & Chatomz
    Route::middleware(['admin'])->group(function () {
        // simpan route admin dibawah ini
        Route::resource('anggota', 'App\Http\Controllers\Admin\AnggotaController');
        Route::resource('jobdesk', 'App\Http\Controllers\Admin\JobdeskController');
        Route::resource('manajemenjobdesk', 'App\Http\Controllers\Admin\ManajemenjobdeskController');
        Route::resource('client', 'App\Http\Controllers\Admin\ClientController');
        Route::resource('proyek', 'App\Http\Controllers\Admin\ProyekController');
        Route::resource('layanan', 'App\Http\Controllers\Admin\LayananController');
        Route::resource('rekening', 'App\Http\Controllers\Admin\RekeningController');
        Route::resource('manajemenproyek', 'App\Http\Controllers\Admin\ManajemenproyekController');
        Route::resource('manajemenpihaklain', 'App\Http\Controllers\Admin\ManajemenpihaklainController');
        Route::resource('pembayaranproyek', 'App\Http\Controllers\Admin\PembayaranproyekController');
        Route::resource('manajemenlayanan', 'App\Http\Controllers\Admin\ManajemenlayananController');
        Route::get('pihaklain', 'App\Http\Controllers\Admin\ClientController@pihaklain');

        Route::get('admin/monitoringjobdesk', 'App\Http\Controllers\Admin\ManajemenjobdeskController@monitoring');
        Route::get('admin/cekjobdesk/{id}', 'App\Http\Controllers\Admin\ManajemenjobdeskController@cekjobdesk');


        // SISTEM
        Route::resource('info-website', 'App\Http\Controllers\Admin\InfowebsiteController');
        Route::resource('visitor', 'App\Http\Controllers\Sistem\VisitorController');
    });

    // route anggota

    Route::get('daftarjobdesk', 'App\Http\Controllers\Anggota\HomeanggotaController@jobdesk');
    Route::get('daftarproyek', 'App\Http\Controllers\Anggota\HomeanggotaController@proyek');
    Route::get('daftarlayanan', 'App\Http\Controllers\Anggota\HomeanggotaController@layanan');
    Route::get('detailproyek/{id}', 'App\Http\Controllers\Anggota\HomeanggotaController@detailproyek');
    Route::get('posting/{id}', 'App\Http\Controllers\Anggota\MonitoringjobdeskController@posting');
    Route::get('posting/{id}/edit', 'App\Http\Controllers\Anggota\MonitoringjobdeskController@postingedit');
    Route::post('simpanposting', 'App\Http\Controllers\Anggota\MonitoringjobdeskController@simpanposting');
    Route::resource('monitoringjobdesk', 'App\Http\Controllers\Anggota\MonitoringjobdeskController');

    Route::resource('user', 'App\Http\Controllers\Sistem\UserController');
});

// --------------------------------------------------------------------------------------------
// PENGUJIAN DLL
// --------------------------------------------------------------------------------------------
// Cetak PDF dengan dompdf packgake
Route::get('/cetak/lihat','App\Http\Controllers\Pengujian\PrintpdfController@get');
Route::get('/cetak/download','App\Http\Controllers\Pengujian\PrintpdfController@out');
// --------------------------------------------------------------------------------------------
