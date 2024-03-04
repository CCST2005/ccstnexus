<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSection extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'sections';

    protected $fillable = [
        'id', 'track', 'section', 'department', 'desc', 'created_at', 'updated_at', 'adviser', 'imageName'
    ];
}
