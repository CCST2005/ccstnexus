<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDepartments extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'departments';

    protected $fillable = [
        'id', 'description', 'acadYr', 'title',
    ];
}
