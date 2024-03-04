<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class acadYear extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'acad_year';
    protected $fillable = ['id', 'current', 'year'];
}
