<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manajemenlayanan extends Model
{
    use HasFactory;

    protected $table = 'manajemen_layanan';
    
    protected $guarded = [];
}
