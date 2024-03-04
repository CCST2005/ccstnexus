<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRegistrar extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'roles_registrar';

    protected $fillable = [

        'id', 'owner_id', 'role',
    ];
}
