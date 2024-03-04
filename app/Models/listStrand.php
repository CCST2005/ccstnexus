<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listStrand extends Model
{
    use HasFactory;

    protected $table = 'shs_strands';

    protected $fillable = [
        'id', 'strand', 'academic_yr', 'YrLength'
    ];
}
