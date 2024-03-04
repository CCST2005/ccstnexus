<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminStudent extends Model
{
    use HasFactory;
    protected $timezone = 'Asia/Manila';
    protected $table = 'student_account';

    protected $fillable = [
        
        'id',
        'created_at',
        'updated_at',
        'username',
        'password',
        'verify_question',
        'verify_answer',
        'firstname',
        'middlename',
        'lastname',
        'student_no',
        'image_file_name',
        'darkmode',
        'disabled',
        'email',
        'region',
        'city',
        'province',
        'barangay',
        'block_lot',
        'birth_month',
        'birth_year',
        'birth_day',
        'sex',
        'sivil_status',
        'level',
        'citizenship',
        'age',
        'birthplace',
        'ContactNo',

        'father_fname',
        'father_mname',
        'father_lname',

        'mother_fname',
        'mother_mname',
        'mother_lname',

        'm_occupation',
        'f_occupation',

        'emergency_fname',
        'emergency_mname',
        'emergency_lname',

        'emergency_relation',

        'emergency_contact',

        'emergency_address',
        'academic_year',
    ];
}
