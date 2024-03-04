<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAccInfo extends Model
{
    use HasFactory;

    protected $timezone = 'Asia/Manila';
    protected $table = 'admin_acc_info';
    protected $fillable = [
        'id', 'owner_id', 'super_admin', 'firstname', 'middlename', 'lastname',
        'employee_no', 'image_file_name', 'darkmode', 'created_at', 'updated_at', 'disabled'
    ];
}
