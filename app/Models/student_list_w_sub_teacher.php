<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_list_w_sub_teacher extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'student_list_w_sub_teacher';

    protected $fillable = [

        'id', 'stud_id', 'owner_id', 'gradeFinals',
    ];
}
