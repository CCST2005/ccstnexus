<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_credentials extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'student_credentials';

    protected $fillable = [

        'id', 'credentials_id', 'owner_id',
    ];
}
