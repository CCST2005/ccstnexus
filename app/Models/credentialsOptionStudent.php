<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class credentialsOptionStudent extends Model
{
    use HasFactory;
    protected $table = 'student_credentials_option';

    protected $fillable = [
        'id', 'credentials',
    ];
}
