<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolesListForregistrar extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'roles_list_for_registrar';

    protected $fillable = [

        'id', 'role',
    ];
}
