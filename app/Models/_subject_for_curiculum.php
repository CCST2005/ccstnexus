<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class _subject_for_curiculum extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = '_subject_for_curiculum';
    protected $fillable = ['id', 'sub_code', 'owner_id','ownerCourse'];
}
