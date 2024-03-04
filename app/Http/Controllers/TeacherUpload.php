<?php
// In your ExcelController.php
namespace App\Http\Controllers;
use App\Imports\YourExcelImport;

use App\Imports\processGradeUpload;
use App\Models\listCourse;
use App\Models\AdminTeacher;

use App\Models\Adminsection;
use App\Models\AdminStudent;
use App\Models\sectioning;
use App\Models\studentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherUpload extends Controller
{

    public function logout_admin(){
       

        if (session()->has('user_logged_teacher')) {

            session()->flush(); 
            session()->invalidate(); 
    
            $adminUrl = '/teacher';
    
            return redirect($adminUrl);

        }
     

 
    }
    public function index()
    {        



      


        if (!session()->has('user_logged_teacher')) {
            return view('teacher.login_page_teacher');
        }
        
        
    

      


        return view('teacher.index_teacher');
    }

    public function uploadForm()
    {
        return view('teacher.upload-form');
    }

    public function processExcel(Request $request)
    {
        $notValid = array();
        $indexNotvalid = 0;
        $uniID = '';
        $studentNo = '';
        $bday = '';
        $verify_question = '';
        $verify_answer = '';
        $firstName = '';
        $middleName = '';
        $lastName = '';
        $gmail = '';
        $regionText = '';
        $cityText = '';
        $province = '';
        $barangayText = '';
        $house = '';
        $month = '';
        $year = '';
        $day = '';
        $sex = '';
        $sivil_status = '';
        $citizenship = '';
        $age = '';
        $bdayplace = '';
        $contactStudent = '';
        $fFirstName = '';
        $fMiddleName = '';
        $fLastName = '';
        $mFirstName = '';
        $mMiddleName = '';
        $mLastName = '';
        $mOccupation = '';
        $fOccupation = '';
        $eFirstName = '';
        $eMiddleName = '';
        $eLastName = '';
        $eRelation = '';
        $econtact = '';
        $eAddress = '';
        $level = 'College';


        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        $file = $request->file('file');

        // Use the import class to handle the Excel file
        $import = new YourExcelImport();
        $import->import($file);
        $listall = array();
        $data = $import->data;
        $indexes = 0;
        foreach ($data as $row){
            $i = 0;
            $NOTINCLUDED = 0;
            $temp = array();
            $howMany = 0;
            foreach ($row as $cell){
                $i++;
                if($i == 1){
                    if(trim($cell) == ''){
                        $howMany++;
                        
                    }
                    $temp['student_no'] = $cell;
                }
                elseif($i == 2){
                    if(trim($cell) == ''){
                        $howMany++;
                    }
                    $temp['fname'] = $cell;
                }
                elseif($i == 3){
                    if(trim($cell) == ''){
                        $howMany++;
                    }
                    $temp['mname'] = $cell;
                }
                elseif($i == 4){
                    if(trim($cell) == ''){
                        $howMany++;
                    }
                    $temp['lname'] = $cell;
                }
                elseif($i == 5){
                    if(trim($cell) == ''){
                        $howMany++;
                    }
                    if(trim($cell) == "ACT"){
                        $cell = '14';
                    }
                    elseif(trim($cell) == "CT"){
                        $cell = '15';
                    }
                    elseif(trim($cell) == "HMT"){
                        $cell = '16';
                    }
                    elseif(trim($cell) == "HRS"){
                        $cell = '17';
                    }
                    elseif(trim($cell) == "BSOA"){
                        $cell = '18';
                    }
                    elseif(trim($cell) == "BSE"){
                        $cell = '19';
                    }

                    $temp['course'] = $cell;
                }
                elseif($i == 6){
                    if(trim($cell) == ''){
                        $howMany++;
                    }
                    $temp['sex'] = $cell;
                }
                elseif($i == 7){
                    if(trim($cell) == ''){
                        $howMany++;
                    }
                    $temp['year'] = $cell;
                }
                elseif($i == 8){
                    if(trim($cell) == ''){
                        $howMany++;
                    }
                    $temp['month'] = $cell;
                }
                elseif($i == 9){
                    if(trim($cell) == ''){
                        $howMany++;
                    }
                    $temp['day'] = $cell;
                }
                elseif($i == 10){
                    if(trim($cell) == ''){
                        $howMany++;
                    }
                    $temp['section'] = $cell;
                }
               
            }

            if($howMany != 10){
                    array_push($listall, $temp);
                }
            
            
            $indexingIndex = 0;
         
            
        }


        unset($listall[0]);

        foreach ($listall as $row) {

            $student_no = trim($row['student_no']);
            
            $fname = trim($row['fname']);
            $mname = trim($row['mname']);
            $lname = trim($row['lname']);
            $course = trim($row['course']);
            $sex = trim($row['sex']);
            $year = trim($row['year']);
            $month = trim($row['month']);
            $day = trim($row['day']);
            $section = trim($row['section']);

            $courseName = '';
            if(trim($course) == "14"){
                $courseName = 'ACT';
            }
            elseif(trim($course) == "15"){
                $courseName = 'CT';
            }
            elseif(trim($course) == "16"){
                $courseName = 'HM';
            }
            elseif(trim($course) == "17"){
                $courseName = 'HRS';
            }
            elseif(trim($course) == "18"){
                $courseName = 'BSOA';
            }
            elseif(trim($course) == "19"){
                $courseName = 'BSE';
            }
            else{
                $courseName = '';
            }

            $duplicated = false;

            $existingEmployeeffas = AdminStudent::where('student_no', $student_no)->exists();

            if($existingEmployeeffas){
                $duplicated = true;
            }
            $sectioning = $courseName . '-' . $section;
            $existingEmployee = Adminsection::where('section', $sectioning)->exists();
            
            $message = '';
            if(strval($student_no) == ''){
                $message = 'Student no empty ||' . $student_no;
            }
            if($section == ''){
                $message = 'section empty ||' . $section;
            }
            if($course == ''){
                $message = 'course empty ||' . $course;
            }
            if(strval($student_no) == '01-1900'){
                $message = 'student_no 01-1900 ||' . $student_no;
            }
            if($duplicated){
                $message = 'stud no duplicated ||' . $student_no;
            }
            if(!$existingEmployee){
                $message = 'section not found database ||' . $sectioning;
            }
            

            if(strval($student_no) != '' && $section != '' && $course != ''  && strval($student_no) != '01-1900' && !$duplicated && $existingEmployee){
                

                $randomNumber = random_int(1, 100);

                $numbers = preg_replace("/[^0-9]/", "", $student_no);
        
                $uniID = $numbers . $randomNumber;


                $add_info_admin = new AdminStudent([


                    'id' => $uniID,
                    'username' => $student_no,
                    'password' => $bday,
                    'verify_question' => '',
                    'verify_answer' => '',
        
                    'firstname' => $fname,
                    'middlename' => $mname,
                    'lastname' => $lname,
                    'student_no' => $student_no,
                    'image_file_name' => '',
                    'darkmode' => 1,
                    'disabled' => '0',
                    'email' => $gmail,
                    'region' => $regionText,
                    'city' => $cityText,
                    'province' => $province,
                    'barangay' => $barangayText,
                    'block_lot' => $house,
                    'birth_month' => $month,
                    'birth_year' => $year,
                    'birth_day' => $day,
                    'sex' => $sex,
                    'sivil_status' => $sivil_status,
                    'citizenship' => $citizenship,
                    'age' => $age,
                    'birthplace' => $bdayplace,
                    'ContactNo' => $contactStudent,
                    'father_fname' => $fFirstName,
                    'father_mname' => $fMiddleName,
                    'father_lname' => $fLastName,
                    'mother_fname' => $mFirstName,
                    'mother_mname' => $mMiddleName,
                    'mother_lname' => $mLastName,
                    'm_occupation' => $mOccupation,
                    'f_occupation' => $fOccupation,
                    'emergency_fname' => $eFirstName,
                    'emergency_mname' => $eMiddleName,
                    'emergency_lname' => $eLastName,
                    'emergency_relation' => $eRelation,
                    'emergency_contact' => $econtact,
                    'emergency_address' => $eAddress,
                    'level' => $level
        
                ]);

                $add_info_admin->save();


                $add_info_admins = new studentCourse([

                    'ownerID' => $uniID,
                    'course' => $course,
                    
                ]);
                $add_info_admins->save();

                $existingEmployee = Adminsection::where('section', $sectioning)->first();

                $add_info_adminss = new sectioning([

                    'owner_id' => $uniID,
                    'section' => $existingEmployee->id,
                    
                ]);
                $add_info_adminss->save();


            }
            else{
                // array_push($data[$indexNotvalid], $message);
                array_push($notValid, [
                    trim($row['fname']),
                    trim($row['mname']),
                    trim($row['lname']),
                    trim($row['course']),
                    trim($row['sex']),
                    trim($row['year']),
                    trim($row['month']),
                    trim($row['day']),
                    trim($row['section']),
                    $message
                ]);
            }

            $indexNotvalid++;
        }




        $color = "style=background:red";
        // You can now access the data in $import->data and pass it to the view
        return view('teacher.display-values', ['data' => $notValid]);
    }


    public function loging_in(Request $request)
    {

  

        $email = $request->input('email');
        $password = $request->input('password');

        $admin = AdminTeacher::where('username', $email)
        ->first();
        
      
       

        if($admin){
            $admin_id = $admin->id;
            
            $storedPassword = $admin->password; 

            if (Hash::check($password, $storedPassword)) {
                $admin_info = AdminTeacher::where('id', $admin_id)->first();
                $disable = $admin_info->disabled;
                if($disable == 1){
                    
                    $success = [

                        'icon' => 'error',
                        'title' => 'This account is disabled',
                        'text' => 'Please contact the administrator for more information.',
                    ];


                    
                    return back()->with('disabled', $success);
                    
                }

                $darkmode = AdminTeacher::where('id', $admin_id)->first();

                $middle = ($darkmode->middlename)? $darkmode->middlename[0]."." : "";
                
                $fullame = $darkmode->lastname . ", " . $darkmode->firstname . " " . $middle;


                
                

                
                session(['user_logged_teacher' => $admin_id, 'darkmode' => $darkmode->darkmode, 'fullname' => $fullame]);

                return redirect()->route('teacher.section');
            } else {
                // Passwords do not match
                
                $errors = ['message' => 'Wrong password.', 'color_password' => 'red'];

                

                $data = ['email' => $email,];
                return back()->withErrors($errors)->withInput()->with('data', $data);
            }

        }
        else{
            //return view('Wrong_password');
           
            $errors = ['message' => 'Email not found.', 'color_email' => 'red'];
            $data = ['email' => $email,];
            return back()->withErrors($errors)->withInput()->with('data', $data);
        }

        
    }



    public function dark_mode(Request $request){

        if((int)$request->input('darkmode') != 1 && (int)$request->input('darkmode') != 0){
            return redirect()->route('teacher.index_teacher');
        }
        

        $finding_user = AdminTeacher::where('id', session('user_logged_teacher'))->first();

        $darkmode_input = (int)$finding_user->darkmode;

        if($darkmode_input == 1){
            $darkmode_input = 0;

        }
        else{

            $darkmode_input = 1;

        }

       

       

        if ($finding_user) {
            $finding_user->update([

                'darkmode' => $darkmode_input,
                
            ]);
        }
        session(['darkmode' => $darkmode_input]);
        
        return response()->json(['darkmode' => $darkmode_input]);

       

        


        
    }



    public function add_section(){
        $track = listCourse::all();

        return view('teacher.add_section', compact('track'));
    }




    public function processUpload(Request $request){
        $file = $request->file('filing');

        // Use the import class to handle the Excel file
        $import = new processGradeUpload();
        $import->import($file);
        $allVales = array();
        $data = $import->data;
       
        foreach($data as $pogi){
            $temp = array();
            $counts = 0;
            foreach($pogi as $vals){
                $counts++;
                if($counts ==2){
                    
                    $temp['student_no'] = trim($vals);
                }
                elseif($counts == 30){
                    
                    $temp['grade'] = trim($vals);
                }
               
            }
            array_push($allVales, $temp);
          
        }

        $gradeStudents = array();
        $countserror = 0;
        foreach($allVales as $valuing){
            
            if(trim($valuing['student_no']) == ''){
                $valse = 'none' . $countserror;
            }
            else{
                $valse =  $valuing['student_no'];
            }
            $gradeStudents[$valse] = $valuing['grade'];
            $countserror++;
        }


        return redirect()->back()->with('gradesUploaded', $gradeStudents);
    }







    

  
 
}
