<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminCuriculum extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'curiculum';
    protected $fillable = [
        'id', 'course', 'title', 'created_at', 'updated_at', 'acadYr', 'desc', 'courseID', 'AcadYearsEdited', 'ordering'
    ];
}
