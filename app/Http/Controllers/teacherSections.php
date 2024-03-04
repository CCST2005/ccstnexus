<?php

namespace App\Http\Controllers;
use App\Models\AdminTeacher;
use App\Models\Adminsection;
use App\Models\listCourse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\AdminSubject;
use App\Models\_subject_for_curiculum;
use App\Models\AdminCuriculum;
use App\Models\studentCourse;
use App\Models\AdminStudent;
use App\Models\disabling_section_teacher;
use App\Models\teacher_sub;
use App\Models\acadYear;
use App\Models\student_list_w_sub_teacher;
use App\Models\sectioning;
class teacherSections extends Controller
{

    public function index(){
        $existingEmployeeCodeffsass = disabling_section_teacher::where('id', 1)->first();
        $checkDisableAdding = $existingEmployeeCodeffsass->disable;


        $track = listCourse::all();
        $subject = AdminSubject::all();
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        if($checkDisableAdding == 1){
            return view('teacher.disabledPage');
        }
        else{
            return view('teacher.add_section', compact('track', 'subject', 'acads'));
        }
        
  
    }

    public function settings(){
       
        $infos = AdminTeacher::where('id', strval(session('user_logged_teacher')))->first();
       
        return view('teacher.setting', compact('infos'));
  
    }

    public function add_section(){
        $existingEmployeeCodeffsass = disabling_section_teacher::where('id', 1)->first();
        $checkDisableAdding = $existingEmployeeCodeffsass->disable;

        $track = listCourse::all();
        $subject = AdminSubject::all();
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        if($checkDisableAdding == 1){
            return view('teacher.disabledPage');
        }
        else{
            return view('teacher.add_section', compact('track', 'subject', 'acads'));
        }
      
  
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


    public function gettingfillSubsTeacher(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('teacher.section');
        }

        $strands = '';
        $items = array();
        $ids = array();
        $requests = $request->input('gradeLeve');


        $strandsfs = AdminCuriculum::where('courseID', $requests)->get();
        foreach($strandsfs as $idsr){
            $idCuri = $idsr->id;
            
            $strands = _subject_for_curiculum::where('owner_id', $idCuri)->get();
            foreach($strands as $iteming){
                $itemingf = $iteming->sub_code;


                $strandsf = AdminSubject::where('id', $itemingf)->first();
      
                
                    array_push($items, $strandsf->sub_code .' - '. $strandsf->title);
                    array_push($ids, $strandsf->id);
                
            }
        
        
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

                
                    $sectioningID = sectioning::where('owner_id', $id->id)->where('academic_year', $acads)->where('semester', $semester)->where('section', $sections)->first();
                    if($sectioningID){
                        $sectioning = Adminsection::where('id', $sectioningID->section)->first();
                        if($Adminsection){
                            $Adminsection["sectioning"] = $sectioning->section;
                            $Adminsection["sectionId"] = $sectioningID->section;
                            
                            $students[] = $Adminsection;
    
                        }
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
        
        $getingAllsDeleted = student_list_w_sub_teacher::where('owner_id', intval($id))->get();
        
        $currentStudent = array();
        $currentStID = array();
        foreach ($getingAllsDeleted as $iding) {
            $currentStudent[intval($iding->stud_id)] = $iding->gradeFinals;
            array_push( $currentStID, intval($iding->stud_id));
        }


        $getingAllsDeleted = student_list_w_sub_teacher::where('owner_id', $id)->delete();

        $arraALL = $request->input('checkingBoxs');
      


        $dataArray = json_decode($arraALL, true);
        $checkedCheckboxes = array_keys($dataArray);
        
        // Output the keys
        // print_r($keys);

        // return;
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;


        $randomNumber = $id; 
        // print_r($currentStID);
        // print '<br>';
  

        
        

        foreach ($checkedCheckboxes as $checkboxValue) {

            if(in_array(intval($checkboxValue), $currentStID )){
              
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
        $existingEmployeeCodeffsass = disabling_section_teacher::where('id', 1)->first();
        $checkDisableAdding = $existingEmployeeCodeffsass->disable;

        if($checkDisableAdding == 1){
            return redirect()->route('teacher.section');
        }

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
            'done' => '0',
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
            $existingEmployeeCode = teacher_sub::where('owner_id', session('user_logged_teacher'))->orderBy('created_at', 'desc')->get();
        }
        else{
            $existingEmployeeCode = teacher_sub::where('owner_id', session('user_logged_teacher'))->where('academic_year', $academic)->orderBy('created_at', 'desc')->get();
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

                
                    $sectioningID = sectioning::where('owner_id', $id->id)->where('academic_year', $acads)->where('semester', $semester)->where('section', $sections)->first();
                    if($sectioningID){
                        $sectioning = Adminsection::where('id', $sectioningID->section)->first();
                        if($Adminsection){
                            $Adminsection["sectioning"] = $sectioning->section;
                            $Adminsection["sectionId"] = $sectioningID->section;
                            
                            $students[] = $Adminsection;
    
                        }
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
        $dones = $finding_user_acc->done;
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

            return view('teacher.upload_finals', compact('dones','ditTable','gradesFinal', 'idko', 'selectedStud','students','subject','track','subjectNameCode','subjectName','courseName', 'semester', 'semesterID', 'section', 'sectionID', 'acads'));
           
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
        $record_admin = teacher_sub::where('id', $id)->first();

        if ($record_admin) {
           
            $record_admin->done = '1';
            $record_admin->save();
        }

          

        $success = [

            'icon' => 'success',
            'title' => 'Saved successfully!',
        ];

        

        return redirect()->back()->with('success', $success);

    }


    public function checkIfTeacherExist(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('teacher.index');
        }
        
     

        $existingemail = AdminTeacher::where('email', trim($request->input('datacheckgmail')))->first();

    

      if ($existingemail){
            return response()->json([ 'email' => true]);
        }
        else {
            
            return response()->json([ 'email' => false]);
        }
    }

    public function updating_teachers (Request $request, $id)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('teacher.index');
        }
        

        $request->validate([
           
            'first_name' => 'required|string|between:2,100|regex:/^[A-Za-zñÑ\s]+$/',
            'middle_name' => 'nullable|string|between:2,100|regex:/^[A-Za-zñÑ\s]+$/',
            'last_name' => 'required|string|between:2,100|regex:/^[A-Za-zñÑ\s]+$/',
            'password' => 'nullable|string|between:8,30',
            'gmail' => 'required|string|between:5,100|email',
            'image' => 'image|mimes:jpeg,jpg|max:10048',
           
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {

            
            $numbers = rand(1, 100) . rand(100, 200) . rand(200, 1000) . rand(10, 50) . rand(100, 5000);
            $imageFile = $request->file('image');
            $imageName = trim($request->input('first_name')) . '_' . $numbers .'.jpg';
              // Specify the full path to the destination directory
            $destinationPath = public_path('dist/img/profiles');

            // Ensure the destination directory exists; create it if not
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the file to the destination directory
            $imageFile->move($destinationPath, $imageName);

            // The $imagePath will contain the relative path within the public directory
            $imagePath = 'dist/img/profiles/' . $imageName;
        }
        else{
            $imageName = trim($request->input('imaging'));
        }
        
       
        $firstname =  trim(preg_replace('/\s+/', ' ', ucwords(strtolower(str_replace(["\n", ' ', 'Ñ', 'Ñ'], [' ', ' ', 'ñ', 'ñ'], $request->input('first_name'))))));
        $lastname =  trim(preg_replace('/\s+/', ' ', ucwords(strtolower(str_replace(["\n", ' ', 'Ñ', 'Ñ'], [' ', ' ', 'ñ', 'ñ'], $request->input('last_name'))))));
        $middlename =trim(preg_replace('/\s+/', ' ', ucwords(strtolower(str_replace(["\n", ' ', 'Ñ', 'Ñ'], [' ', ' ', 'ñ', 'ñ'], $request->input('middle_name'))))));
        $email = trim($request->input('gmail'));
      
        $password = trim($request->input('password'));
        $sex = trim($request->input('sex'));

    

        $record_admin = AdminTeacher::where('id', $id)->first();

        if ($record_admin) {
            if($password != ""){
                $record_admin->password = Hash::make(trim($password));
            }

            $record_admin->email = $email;
  
            $record_admin->firstname = $firstname;
            $record_admin->middlename = $middlename;
            $record_admin->lastname = $lastname;
            
            $record_admin->sex = $sex;
            $record_admin->image_file_name = $imageName;

            $record_admin->save();
        }



        


        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

        
        $darkmode = AdminTeacher::where('id', $id)->first();

        $middle = ($darkmode->middlename)? $darkmode->middlename[0]."." : "";
        
        $fullame = $darkmode->lastname . ", " . $darkmode->firstname . " " . $middle;


        $links = $darkmode->image_file_name;


        session([ 'fullname' => $fullame, 'links' => $links]);
        
         return back()->with('success', $success);


    }


    public function studentList(Request $request){
        
        
        $students = AdminStudent::all();
        $schools = array();
        
     



            $students = AdminStudent::all();
 

        $course = array();
        foreach($students as $id){

            $cur = studentCourse::where('ownerID', $id->id)->first();
            $temp = listCourse::where('id', $cur->course)->first();
            $course[$id->id] = $temp->course;
        }


        $sectioning = array();
        foreach($students as $id){

            $cur = sectioning::where('owner_id', $id->id)->exists();


            if($cur){
                $cur = sectioning::where('owner_id', $id->id)->first();
                $temp = AdminSection::where('id', $cur->section)->first();
                $sectioning[$id->id] = $temp->section;
            }
            else{
                $sectioning[$id->id] = 'N/A';
            }
           
        }



        return view('teacher.teacherSections', compact('students', 'schools', 'course', 'sectioning'));
    }

    public function disabledPage(){
        return view('teacher.disabledPage');
    }



    public function welcome(){
        return view('teacher.welcome');
    }
}
