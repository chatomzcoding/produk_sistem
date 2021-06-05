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
        Route::resource('client', 'App\Http\Controllers\Admin\ClientController');

        // SISTEM
        Route::resource('info-website', 'App\Http\Controllers\Admin\InfowebsiteController');
        Route::resource('visitor', 'App\Http\Controllers\Sistem\VisitorController');
    });

    Route::resource('user', 'App\Http\Controllers\Sistem\UserController');
});

// --------------------------------------------------------------------------------------------
// PENGUJIAN DLL
// --------------------------------------------------------------------------------------------
// Cetak PDF dengan dompdf packgake
Route::get('/cetak/lihat','App\Http\Controllers\Pengujian\PrintpdfController@get');
Route::get('/cetak/download','App\Http\Controllers\Pengujian\PrintpdfController@out');
// --------------------------------------------------------------------------------------------
