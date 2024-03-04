<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher_sub extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'teacher_subjects';

    protected $fillable = [
        'id', 'owner_id', 'academic_year', 'subject_id', 'course_id', 'section_id', 'semester', 'editTable',
       
    ];
}
