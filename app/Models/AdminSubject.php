<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSubject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'id', 'title', 'description', 'sub_code',  'lecture',  'lab',  'pre'
    ];
}
