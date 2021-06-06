<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaranproyek extends Model
{
    use HasFactory;
        
    protected $table = 'pembayaran_proyek';

    protected $guarded = [];
}
