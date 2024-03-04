<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_Model extends Model
{
    use HasFactory;
    
    protected $timezone = 'Asia/Manila';
    protected $table = 'admin';
    protected $fillable = ['id', 'username', 'password', 'verify_question', 'verify_answer', 'email'];
}

