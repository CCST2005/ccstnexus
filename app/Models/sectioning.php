<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sectioning extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'sectioning';

    protected $fillable = [

        'owner_id', 'section',
    ];
}
