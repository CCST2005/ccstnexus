<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentCourse extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'college_student_courses';

    protected $fillable = [

        'id', 'course', 'ownerID',
    ];
}
