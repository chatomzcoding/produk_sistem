<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        switch ($user->level) {
            case 'admin':
                return view('admin.dashboard');
                break;
            case 'anggota':
                $anggota    = Anggota::where('user_id',$user->id)->first();
                return view('anggota.dashboard',compact('anggota'));
                break;
        }
    }
}
