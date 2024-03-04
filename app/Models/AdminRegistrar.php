<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRegistrar extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'registrar_acc';

    protected $fillable = [
        'id', 'role', 'firstname', 'middlename', 'lastname', 
        'employee_no', 'image_file_name', 'darkmode', 'created_at', 'updated_at', 'disabled', 
        'email', 'username', 'password', 'verify_question', 'verify_answer', 
    ];
}
