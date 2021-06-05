<?php

namespace App\Http\Controllers\Pengujian;

use App\Http\Controllers\Controller;
use App\Models\Kategoriproduk;
use Illuminate\Http\Request;
use PDF;

class PrintpdfController extends Controller
{
    public function get()
    {
        $kategori = Kategoriproduk::all();
        return view('pengujian.printpdf.index', compact('kategori'));
    }

    public function out()
    {
        $kategori   = Kategoriproduk::all();
        $pdf        = PDF::loadView('pengujian.printpdf.index', compact('kategori'));
        return $pdf->download('pengujian.pdf');
    }
}
