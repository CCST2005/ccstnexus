<?php


namespace App\Http\Controllers;
use App\Models\acadYear;
use App\Models\teacher_sub;
use App\Models\Adminsection;
use App\Models\listCourse;
use App\Models\sectioning;
use App\Models\AdminTeacher;
use App\Models\AdminStudent;
use App\Models\AdminSubject;
use App\Models\student_list_w_sub_teacher;
use App\Models\disabling_section_teacher;
use Illuminate\Http\Request;

class AdminteacherSection extends Controller
{
    public function teacherSection(Request $request){
        $existingEmployeeCodeffsass = disabling_section_teacher::where('id', 1)->first();
        $checkDisableAdding = $existingEmployeeCodeffsass->disable;
        $academic = $request->input('academic');
        $academic_year = teacher_sub::all();

        $schools = array();
        foreach($academic_year as $sections){
            if(!in_array($sections->academic_year, $schools)){
                array_push($schools,$sections->academic_year);
            }
            
             
        }
        

        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        $currentYEAR = $acads;
        

        if($academic == 'original'){
            $academic = $acads;
        }
        else if(in_array($academic, $schools)){
            $academic = $academic;
        }
        else if($academic == 'all'){
            $academic = 'all';
        }
        else{
            $academic = $acads;
        }
        
        $countingDisabled = 0;

        if($academic == 'all'){
            $existingEmployeeCode = teacher_sub::all();
        }
        else{
 
            $existingEmployeeCode = teacher_sub::where('academic_year', $academic)->get();

            foreach($existingEmployeeCode as $disable){

                if($disable->editTable == '1'){
                    $countingDisabled++;
                }

            }
        }



        $yearSelected = $academic;
     

        $sectioning = Adminsection::all();
        $section = array();
        foreach($sectioning as $sections){
            $section += [$sections->id => $sections->section];
        }

        $subjecting = AdminSubject::all();

        $subject = array();
        foreach($subjecting as $sections){
        

            $subject += [$sections->id => $sections->sub_code . " - " . $sections->title];
        }

        $coursing = listCourse::all();
        $course = array();
        foreach($coursing as $sections){
            
            $course += [$sections->id => $sections->course];
        }


        $coursing = AdminTeacher::all();
        $AdminTeacher = array();
        foreach($coursing as $sections){
            
            $AdminTeacher += [$sections->id => $sections->firstname . " " . $sections->lastname];
        }
        
    //  return;
      return view('admin.teacherSection', compact('checkDisableAdding','countingDisabled','yearSelected','currentYEAR','AdminTeacher','existingEmployeeCode', 'section', 'subject', 'course', 'schools'));
    }

    public function disableSections(Request $request){
        $id = $request->input('id');

        $existingEmployeeCode = teacher_sub::where('id', $id)->first();
        $Enable = false;

        if($existingEmployeeCode->editTable == '1'){

            $existingEmployeeCode->editTable = "0";
            $Enable = false;
        }
        else{
            $existingEmployeeCode->editTable = "1";
            $Enable = true;
        }


        $existingEmployeeCode->save();

        if($Enable){
            return response()->json(['mode' => 'enabled']);
        }
        else{
            return response()->json(['mode' => 'disabled']);
        }
     
    }
   public function disable_multiple_TeacherSection(Request $request){
   
    $counts = 0;
        $storedHash = base64_decode($request->input('password'));

        $data = "this_is_password123"; 
        $key = "CCST_2005"; 


        $computedHash = hash_hmac("sha256", $data, $key);


        if($computedHash === $storedHash){
                
                    $id = $request->input('year');

                    $existingEmployeeCode = teacher_sub::where('academic_year', $id)->update(['editTable' => "0"]);
                    $Enable = false;

                    $existingEmployeeCode = teacher_sub::where('academic_year', $id)->count();

                    
                    $counts = $existingEmployeeCode;

                   
            }
    
            
    
        
    
            return response()->json(['success' => $counts]);
           

        }
       
       

        public function disablingSectionTeacher(Request $request){
      
    
            $existingEmployeeCode = disabling_section_teacher::where('id', 1)->first();
            $Enable = false;
    
            if($existingEmployeeCode->disable == '1'){
    
                $existingEmployeeCode->disable = "0";
                $Enable = false;
            }
            else{
                $existingEmployeeCode->disable = "1";
                $Enable = true;
            }
    
    
            $existingEmployeeCode->save();
    
            if($Enable){
                return response()->json(['mode' => 'disabled']);
            }
            else{
                return response()->json(['mode' => 'enabled']);
            }
         
        }


        public function upload_finals(Request $request, $id){

            $idko = $id;
    
            $finding_user_acc = teacher_sub::where('id', $id)->first();
    
            $ditTable = $finding_user_acc->editTable;
            $semester = $finding_user_acc->semester;
            $subject = $finding_user_acc->subject_id;
            $track = $finding_user_acc->course_id;
            $sections = $finding_user_acc->section_id;
    
            $acads = $finding_user_acc->academic_year;
    
            if ($track != "" && $subject != "" && $sections != "") {
    
                $existingEmployee = AdminSubject::where('id', $subject)->first();
                
                
                $courses = listCourse::where('id', $track)->first();
              
                
               
    
                if(!$courses){
                    return redirect()->route('admin.index');
                }
    
              
              
                $subjectName = $existingEmployee->title;
                $subjectNameCode = $existingEmployee->sub_code;
                $courseName = $courses->course;
                
                $students = array();
    
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
    
    
                $selectedStud = array();
                $checkboxValuesffs = student_list_w_sub_teacher::where('owner_id', $idko)->get();
                foreach($checkboxValuesffs as $id){
                    array_push($selectedStud, $id->stud_id);
                }
    
                $gradesFinal = array();
                $checkboxValuesffsfff = student_list_w_sub_teacher::where('owner_id', $idko)->get();
                foreach($checkboxValuesffsfff as $id){
                    $gradesFinal[$id->stud_id] = $id->gradeFinals;
                }
    
                $semesterID = $semester;
                if($semester == 1){
                    $semester = "1ST SEMESTER";
                }
                else{
                    $semester = "2ND SEMESTER";
                }
                $sectionID =  $sections;
    
                $section = Adminsection::where('id', $sectionID)->first();
                $section = $section->section;
    
                return view('admin.upload_finals', compact('ditTable','gradesFinal', 'idko', 'selectedStud','students','subject','track','subjectNameCode','subjectName','courseName', 'semester', 'semesterID', 'section', 'sectionID', 'acads'));
               
            }
    
            return view('admin.index');
        }
 
 
    
   
}
