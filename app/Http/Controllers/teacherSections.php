<?php

namespace App\Http\Controllers;
use App\Models\AdminTeacher;
use App\Models\Adminsection;
use App\Models\listCourse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\AdminSubject;
use App\Models\studentCourse;
use App\Models\AdminStudent;
use App\Models\teacher_sub;
use App\Models\acadYear;
use App\Models\student_list_w_sub_teacher;
use App\Models\sectioning;
class teacherSections extends Controller
{

    public function index(){
        $track = listCourse::all();
        $subject = AdminSubject::all();
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        return view('teacher.add_section', compact('track', 'subject', 'acads'));
  
    }
    public function add_section(){
        $track = listCourse::all();
        $subject = AdminSubject::all();
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        return view('teacher.add_section', compact('track', 'subject', 'acads'));
  
    }
    public function gettingSectionTeacher(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('teacher.section');
        }

        $strands = '';
        $items = array();
        $ids = array();
        $requests = $request->input('gradeLeve');
        
            
            $strands = Adminsection::where('track', $requests)->get();
            foreach($strands as $iteming){
                
                array_push($items, $iteming->section);
                array_push($ids, $iteming->id);
            }
        
        
        


    
            
        return response()->json(['strands' => $items, 'ids' => $ids]);
       
    }

    public function add_section_student(Request $request)
    {

        $semester = $request->input('semester');
        $subject = $request->input('subject');
        $track = $request->input('track');
        $sections = $request->input('sections');

        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        if ($track != "" && $subject != "" && $sections != "") {

            $existingEmployee = AdminSubject::where('id', $subject)->first();
            
            
            $courses = listCourse::where('id', $track)->first();
          
            
           

            if(!$courses){
                return redirect()->route('teacher.section');
            }

          
          
            $subjectName = $existingEmployee->title;
            $subjectNameCode = $existingEmployee->sub_code;
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

         return view('teacher.add_section_student', compact('students','subject','track','subjectNameCode','subjectName','courseName', 'semester', 'semesterID', 'section', 'sectionID', 'acads'));
           
        }

       return redirect()->route('teacher.section');
        
            
        
       
    }

    public function updating_section_student (Request $request, $id)
    {
        
        $getingAlls = student_list_w_sub_teacher::where('owner_id', $id)->get();
        
        $currentStudent = array();
        $currentStID = array();
        foreach ($getingAlls as $iding) {
            $currentStudent[$iding->stud_id] = $iding->gradeFinals;
            array_push( $currentStID, $iding->stud_id);
        }


        $getingAlls = student_list_w_sub_teacher::where('owner_id', $id)->delete();

        $checkedCheckboxes = $request->input('checkboxes', []);
      


        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;


        $randomNumber = $id; 
     


        
        

        foreach ($checkedCheckboxes as $checkboxValue) {

            if(in_array($checkboxValue, $currentStID )){
              
                $grades = $currentStudent[$checkboxValue];
                
            }
            else{
                $grades = '';
            }


        $add_info_admin = new student_list_w_sub_teacher([
    
            'stud_id' => $checkboxValue,
            'owner_id'  => $randomNumber,
            'gradeFinals' =>  $grades,
            
        ]);

        $add_info_admin->save();

        


   

        
       
        }
        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

        

        return redirect()->back()->with('success', $success);
      
       
    }

    public function adding_section_student(Request $request)
    {
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;


        do {
            // Step 1: Generate a random number
            $randomNumber = rand(100, 9999) . rand(200, 999) . rand(300, 999); 
            $numberExists = teacher_sub::where('id', $randomNumber)->exists();
        } while ($numberExists);


        $add_info_admin = new teacher_sub([
            'id' => $randomNumber,
            'academic_year' => $acads,
            'subject_id'  => strval(trim($request->input('subject_id'))),
            'course_id'  => strval(trim($request->input('course_id'))),
            'section_id'  => strval(trim($request->input('section_id'))),
            'owner_id'  => strval(session('user_logged_teacher')),
            'semester'  => strval(trim($request->input('semester'))),
            'editTable' => '1',
        ]);

        $add_info_admin->save();
        
        $checkedCheckboxes = $request->input('checkboxes', []);

        foreach ($checkedCheckboxes as $checkboxValue) {


        $add_info_admin = new student_list_w_sub_teacher([
    
            'stud_id' => $checkboxValue,
            'owner_id'  => $randomNumber,
            'gradeFinals' => '',
            
        ]);

        $add_info_admin->save();


       
        }
        $success = [

            'icon' => 'success',
            'title' => 'Added successfully!',
        ];

        

        return redirect()->route('teacher.section')->with('success', $success);
      
       
    }


    public function checkIftitlesexistSubjectTeacher(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('teacher.section');
        }



        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        
       
        $existingEmployeeCode = teacher_sub::where('subject_id', $request->input('subject'))
        ->where('course_id', $request->input('track'))
        ->where('section_id', $request->input('section'))
        ->where('semester', $request->input('semester'))
        ->where('owner_id', session('user_logged_teacher'))
        ->where('academic_year', $acads)
        ->first();

        $listCourse = listCourse::where('id', $request->input('track'))->first();
        $AdminSubject = AdminSubject::where('id', $request->input('subject'))->first();
        $Adminsection = Adminsection::where('id', $request->input('section'))->first();


        $subject = '';
        $track =  '';
        $section = '';

        if($listCourse){
            $track =  $listCourse->course;
        }
        if($AdminSubject){
            $subject = $AdminSubject->sub_code;
        }
        if($Adminsection){
            $section = $Adminsection->section;
        }
       
        
      
        $semester = '';
        if($request->input('semester') == "1"){
            $semester = "1ST SEMESTER";
        }else{
            $semester = "2ND SEMESTER";
        }

        if ($existingEmployeeCode) {
            return response()->json(['condition' => true, 'subject' => $subject, 'track' => $track, 'section' => $section, 'semester' => $semester]);
        } 
       
    
        else {
            
            return response()->json(['condition' => false, 'subject' => $subject, 'track' => $track, 'section' => $section, 'semester' => $semester]);
        }
    }


    public function edit_section(Request $request){
        $academic = $request->input('academic');
        $academic_year = teacher_sub::where('owner_id', session('user_logged_teacher'))->get();

        $schools = array();
        foreach($academic_year as $sections){
            if(!in_array($sections->academic_year, $schools)){
                array_push($schools,$sections->academic_year);
            }
            
             
        }
        

        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        if($academic == 'original'){
            $academic = $acads;
        }
        else if(in_array($academic, $schools)){
            $academic = $academic;
        }
        else if($academic == 'all'){
            $academic = 'all';
        }
        


        if($academic == 'all'){
            $existingEmployeeCode = teacher_sub::where('owner_id', session('user_logged_teacher'))->get();
        }
        else{
            $existingEmployeeCode = teacher_sub::where('owner_id', session('user_logged_teacher'))->where('academic_year', $academic)->get();
        }

        

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

       
      return view('teacher.edit_section', compact('existingEmployeeCode', 'section', 'subject', 'course', 'schools'));
  
    }


    public function delete_section(Request $request, $id, $password)
    {
        $finding_user_acc = teacher_sub::where('id', $id)->first();
        
     
        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finding_user_acc = teacher_sub::where('id', $id)->first();


   

            $finding_user_acc->delete();


            student_list_w_sub_teacher::where('owner_id', $id)->delete();
           
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => '',
            ];
    
            
    
            return redirect()->route('teacher.edit_section', ['academic' => 'original'])->with('delete_success', $success);
           

        }
       

        
    }


    public function checkpassword(Request $request){

        if ($request->isMethod('get')) {
            return redirect()->route('teacher.section');
        }

        $finding_password = AdminTeacher::where('id', session('user_logged_teacher'))->first();
        
        // return response()->json(['password' => $finding_password->password]);
        $password = 'this_is_password123';
        $key = 'CCST_2005'; 


        $hashedPassword = hash_hmac('sha256', $password, $key);


        $base64HMAC = base64_encode($hashedPassword);
        

        if (Hash::check($request->input('password'), $finding_password->password)) {
            return response()->json(['password' => $base64HMAC]);
        } 
        else{
            return response()->json(['password' => 'false']);
        }

    }

    public function delete_multiple_section(Request $request){
        
        $storedHash = base64_decode($request->input('password'));

        $data = "this_is_password123"; 
        $key = "CCST_2005"; 


        $computedHash = hash_hmac("sha256", $data, $key);

        $counts = 0;
        if($computedHash === $storedHash){
        
            $formData = $request->input('id');


            $dataArray = [];
            parse_str($formData, $dataArray);
    
            
            $token = $dataArray['_token'];
            $checkboxValues = $dataArray['checkboxes'];
            
    
            foreach ($checkboxValues as $checkboxValue) {


                $finding_user_acc = teacher_sub::where('id', $checkboxValue)->first();


   

                    $finding_user_acc->delete();


                    student_list_w_sub_teacher::where('owner_id', $checkboxValue)->delete();


    
             
    
                $counts++;
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }
    public function success_message(Request $request, $icon, $title){

        $text = $request->input('text');

       
        $success = [

            'icon' => $icon,
            'title' => $title,
            'text' => $text,
        ];
        
        return back()->with('message', $success);

    }


    public function update_section(Request $request, $id){

        $idko = $id;

        $finding_user_acc = teacher_sub::where('id', $id)->where('owner_id', session('user_logged_teacher'))->first();


        $semester = $finding_user_acc->semester;
        $subject = $finding_user_acc->subject_id;
        $track = $finding_user_acc->course_id;
        $sections = $finding_user_acc->section_id;

        $acads = $finding_user_acc->academic_year;

        if ($track != "" && $subject != "" && $sections != "") {

            $existingEmployee = AdminSubject::where('id', $subject)->first();
            
            
            $courses = listCourse::where('id', $track)->first();
          
            
           

            if(!$courses){
                return redirect()->route('teacher.section');
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

            return view('teacher.update_section', compact('idko', 'selectedStud','students','subject','track','subjectNameCode','subjectName','courseName', 'semester', 'semesterID', 'section', 'sectionID', 'acads'));
           
        }

        return view('teacher.edit_section');

    }

    public function upload_finals(Request $request, $id){

        $idko = $id;

        $finding_user_acc = teacher_sub::where('id', $id)->where('owner_id', session('user_logged_teacher'))->first();


        $semester = $finding_user_acc->semester;
        $subject = $finding_user_acc->subject_id;
        $track = $finding_user_acc->course_id;
        $sections = $finding_user_acc->section_id;

        $acads = $finding_user_acc->academic_year;

        if ($track != "" && $subject != "" && $sections != "") {

            $existingEmployee = AdminSubject::where('id', $subject)->first();
            
            
            $courses = listCourse::where('id', $track)->first();
          
            
           

            if(!$courses){
                return redirect()->route('teacher.section');
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

            return view('teacher.upload_finals', compact('gradesFinal', 'idko', 'selectedStud','students','subject','track','subjectNameCode','subjectName','courseName', 'semester', 'semesterID', 'section', 'sectionID', 'acads'));
           
        }

        return view('teacher.edit_section');
    }

    public function uploading_finals(Request $request, $id){

        $checkboxValuesffs = student_list_w_sub_teacher::where('owner_id', $id)->get();

        foreach($checkboxValuesffs as $idStudents){

            $add_info_admin = student_list_w_sub_teacher::where('owner_id', $id)->where('stud_id', $idStudents->stud_id)->first();

        
            
        
            $add_info_admin->gradeFinals = floatval($request->input($idStudents->stud_id . 'inputGrade'));
        
        

            $add_info_admin->save();
        }

        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

        

        return redirect()->back()->with('success', $success);

    }
}
