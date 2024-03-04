<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class previousEducation extends Model
{
    use HasFactory;

    protected $timezone = 'Asia/Manila';
    protected $table = 'previouseducation';

    protected $fillable = [

        'id', 'elementary', 'highschool', 'college', 'elementaryYr', 'highschoolYr', 'collegeYr', 'collegeCourse'
    ];

}
