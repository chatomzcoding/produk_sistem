<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manajemenpihaklain extends Model
{
    use HasFactory;
    
    protected $table = 'manajemen_pihaklain';
    
    protected $guarded = [];
}
