<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listCourse extends Model
{
    use HasFactory;
    protected $table = 'college_crourse';

    protected $fillable = [
        'id', 'course', 'academic_yr', 'YrLength', 'id_Dept', 'imageName', 'adviser', 'adviserPosition',
    ];
}
