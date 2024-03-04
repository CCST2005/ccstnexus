<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentStrand extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 's_h_s_student_stands';

    protected $fillable = [

        'id', 'strand', 'ownerID'
    ];
}
