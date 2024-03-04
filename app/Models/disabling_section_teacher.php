<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class disabling_section_teacher extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'disabling_section_teacher';

    protected $fillable = [
        'id', 'disable',
    ];
}
