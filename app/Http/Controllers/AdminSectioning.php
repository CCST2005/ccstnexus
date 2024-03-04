<?php
namespace App\Http\Controllers;
use App\Models\acadYear;
use App\Models\AdminSubject;
use App\Models\listCourse;
use App\Models\AdminTeacher;
use App\Models\Adminsection;

use Illuminate\Support\Facades\Hash;


use App\Models\studentCourse;
use App\Models\AdminStudent;
use App\Models\teacher_sub;

use App\Models\student_list_w_sub_teacher;
use App\Models\sectioning;

use Illuminate\Http\Request;

class AdminSectioning extends Controller
{
    public function sectioning(){
        $track = listCourse::all();
        
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        return view('admin.add_student_section', compact('track', 'subject', 'acads'));
       
    }
    public function sectioning_student(Request $request){



        $semester = $request->input('semester');
        
        $track = $request->input('track');
        $sections = $request->input('sections');

        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        if ($track != "" && $sections != "") {

            $existingEmployee = AdminSubject::where('id', )->first();
            
            
            $courses = listCourse::where('id', $track)->first();
          
            
           

            if(!$courses){
                return redirect()->route('teacher.section');
            }

          
         
            $courseName = $courses->course;
            
            $students = array();

            // $checkboxValues = studentCourse::where('course', $track)->get();

            $checkboxValues = AdminStudent::all();
            foreach($checkboxValues as $id){
                $Adminsection = AdminStudent::where('id', $id->id)->first();
                $sectioningID = sectioning::where('owner_id', $id->id)->where('academic_year', $acads)->where('semester', $semester)->exists();
                
                
                if($sectioningID){

                
                    $sectioningID = sectioning::where('owner_id', $id->id)->where('academic_year', $acads)->where('semester', $semester)->first();
                    $sectioning = Adminsection::where('id', $sectioningID->section)->first();
                    if($Adminsection){
                        $Adminsection["sectioning"] = $sectioning->section;
                        $Adminsection["sectionId"] = $sectioningID->section;
                        
                        $students[] = $Adminsection;

                    }
                }
               
                    
             
                
            }
            $semesterID = $semester;
            if($semester == 1){
                $semester = "1ST SEMESTER";
            }
            else{
                $semester = "2ND SEMESTER";
            }
            $sectionID =  $request->input('sections');

            $section = Adminsection::where('id', $sectionID)->first();
            $section = $section->section;

       //  return view('teacher.add_section_student', compact('students','track','courseName', 'semester', 'semesterID', 'section', 'sectionID', 'acads'));
           
        }

       //return redirect()->route('teacher.section');
        
            
        
       
    }
}
