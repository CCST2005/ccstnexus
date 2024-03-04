<?php

namespace App\Http\Controllers;

use App\Models\studentCourse;
use App\Models\AdminStudent;
use App\Models\teacher_sub;
use App\Models\acadYear;
use App\Models\AdminSubject;
use App\Models\listCourse;
use App\Models\AdminTeacher;
use App\Models\Adminsection;
use App\Models\student_list_w_sub_teacher;
use App\Models\sectioning;
use Illuminate\Http\Request;

class StudentSubject extends Controller
{
    function StudentSubject(){
        
        
        $track = listCourse::all();
        $subject = AdminSubject::all();
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        
       
    
     
       
    
        return view('admin.add_subject_student', compact('track', 'subject', 'acads'));
    }
}
