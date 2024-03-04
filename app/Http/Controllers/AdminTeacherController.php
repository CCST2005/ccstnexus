<?php

namespace App\Http\Controllers;
use App\Models\AdminTeacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AdminTeacherController extends Controller
{
    public function index()
    {        


        if (!session()->has('user_logged')) {
            return view('admin.login_page_admin');
        }
        
        
        $all_teacher = AdminTeacher::all();

       
        return view('admin.teacher_list', compact('all_teacher'));
    }

    public function add_teacher(){

        // $rolesListForregistrar = rolesListForregistrar::all();
        return view('admin.add_teacher');
    }

    public function checkIfTeacherExist(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        
        $existingEmployee = AdminTeacher::where('employee_no', $request->input('datacheckEmployeeNo'))->first();

        $existingUsername = AdminTeacher::where('username', $request->input('datacheckEmail'))->first();

        $existingemail = AdminTeacher::where('email', $request->input('datacheckgmail'))->first();

    

        if ($existingEmployee) {
            return response()->json(['employeeNo' => true, 'username' => false, 'email' => false]);
        } 
        elseif ($existingUsername){
            return response()->json(['username' => true, 'employeeNo' => false, 'email' => false]);
        }
        elseif ($existingemail){
            return response()->json(['username' => false, 'employeeNo' => false, 'email' => true]);
        }
        else {
            
            return response()->json(['username' => false, 'employeeNo' => false, 'email' => false]);
        }
    }

    public function adding_teacher(Request $request){
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }


    
        $existingEmployee = AdminTeacher::where('employee_no', $request->input('employee_no'))->first();

        $existingGmail = AdminTeacher::where('email', $request->input('gmail'))->first();

        if($existingEmployee || $existingGmail){
            return back();
        }

        // $roles = $request->input('roles');
        // if (empty($roles)){
        //     return back();
        // }


        $randomNumber = random_int(1, 100);

       

        $request->validate([
            'employee_no' => 'required|string|between:5,20|regex:/^[0-9-]+$/',
            'first_name' => 'required|string|between:2,70|regex:/^[A-Za-zñÑ\s]+$/',
            'middle_name' => 'nullable|string|between:2,70|regex:/^[A-Za-zñÑ\s]+$/',
            'last_name' => 'required|string|between:2,70|regex:/^[A-Za-zñÑ\s]+$/',
            'email' => 'required|string|between:5,70',
            'password' => 'required|string|between:8,30',
            'gmail' => 'required|string|between:5,70|email',

           
           
        ]);


        $numbers = preg_replace("/[^0-9]/", "", $request->input('employee_no'));
        $uniqueID = $numbers . $randomNumber;


      
        $add_info_admin = new AdminTeacher([
            'id' => $uniqueID,
            'username' => trim($request->input('employee_no')),
            'password' => Hash::make(trim($request->input('password'))),
            'verify_question' => '',
            'verify_answer' => '',
            'role' => '', 
            'firstname' => trim(preg_replace('/\s+/', ' ', ucwords(strtolower(str_replace(["\n", ' ', 'Ñ', 'Ñ'], [' ', ' ', 'ñ', 'ñ'], $request->input('first_name'))))))  ,
            'middlename' => trim(preg_replace('/\s+/', ' ', ucwords(strtolower(str_replace(["\n", ' ', 'Ñ', 'Ñ'], [' ', ' ', 'ñ', 'ñ'], $request->input('middle_name')))))) ,
            'lastname' => trim(preg_replace('/\s+/', ' ', ucwords(strtolower(str_replace(["\n", ' ', 'Ñ', 'Ñ'], [' ', ' ', 'ñ', 'ñ'], $request->input('last_name')))))),
            'employee_no' => trim($request->input('employee_no')),
            'image_file_name' => '',
            'darkmode' => 1,
            'disabled' => '0',
            'email' => trim($request->input('gmail')),
            'sex' => trim($request->input('sex')),
        ]);

        $add_info_admin->save();

        



        // if (!empty($roles)) {
        //     foreach ($roles as $value) {

        //         $add_info_admin = new RoleRegistrar([

        //             'owner_id' => $uniqueID,
        //             'role' => $value,
                    
        //         ]);
        
        //         $add_info_admin->save();
                
        //     }
        // }

        $success = [

            'icon' => 'success',
            'title' => 'Added successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);

    }

    public function delete_teacher(Request $request, $id, $password)
    {

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finding_user_acc = AdminTeacher::where('id', $id)->first();

            $name = $finding_user_acc->firstname . " " . $finding_user_acc->lastname;

            $finding_user_acc->delete();

            
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
            
    
             return redirect()->route('admin.teacher')->with('delete_success', $success);
           

        }
       

        
    }

    public function disable_multiple_teacher(Request $request){
        
        $storedHash = base64_decode($request->input('password'));

        $data = "this_is_password123"; 
        $key = "CCST_2005"; 


        $computedHash = hash_hmac("sha256", $data, $key);


        if($computedHash === $storedHash){
        
            $formData = $request->input('id');


            $dataArray = [];
            parse_str($formData, $dataArray);
    
            
            $token = $dataArray['_token'];
            $checkboxValues = $dataArray['checkboxes'];
            $counts = 0;
    
            foreach ($checkboxValues as $checkboxValue) {

                $record_admin = AdminTeacher::where('id', $checkboxValue)->first();
                if($record_admin->disabled == '0'){
                    $record_admin->disabled = '1';
                    $counts++;
                    $record_admin->save();
                }
              
    
                
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }

    public function delete_multiple_teacher(Request $request){
        
        $storedHash = base64_decode($request->input('password'));

        $data = "this_is_password123"; 
        $key = "CCST_2005"; 


        $computedHash = hash_hmac("sha256", $data, $key);


        if($computedHash === $storedHash){
        
            $formData = $request->input('id');


            $dataArray = [];
            parse_str($formData, $dataArray);
    
            
            $token = $dataArray['_token'];
            $checkboxValues = $dataArray['checkboxes'];
            $counts = 0;
    
            foreach ($checkboxValues as $checkboxValue) {
    
            
    
                $finding_user_acc = AdminTeacher::where('id', $checkboxValue)->first();
                $finding_user_acc->delete();


                
    
                $counts++;
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }
    public function disabling_teacher(Request $request, $id)
    {

        $record_admin = AdminTeacher::where('id', $id)->first();

        if ($record_admin) {
            if($record_admin->disabled == '0'){
                $record_admin->disabled = '1';
                $disable = "Disabled successfully!";
            }
            else{
                $record_admin->disabled = '0';
                $disable = "Enabled successfully!";
            }
            

            $record_admin->save();

        }

       
        
        $success = [
            'icon' => 'success', 
            'text' => $record_admin->firstname . " " . $record_admin->lastname,
            'title' => $disable,
        ];
        return back()->with('delete_success', $success);


    }

    public function update_teacher (Request $request, $id)
    {
        $finding_user_acc = AdminTeacher::where('id', $id)->first();
      
        return view('admin.update_teacher', compact('finding_user_acc'));
    }



    public function updating_teacher(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        

        $request->validate([
            'employee_no' => 'required|string|between:5,20|regex:/^[0-9-]+$/',
            'first_name' => 'required|string|between:2,70|regex:/^[A-Za-zñÑ\s]+$/',
            'middle_name' => 'nullable|string|between:2,70|regex:/^[A-Za-zñÑ\s]+$/',
            'last_name' => 'required|string|between:2,70|regex:/^[A-Za-zñÑ\s]+$/',
            'email' => 'required|string|between:5,70',
            'password' => 'nullable|string|between:8,30',
            'gmail' => 'required|string|between:5,70|email',

           
        ]);


        
        $employee = trim($request->input('employee_no'));
        $firstname =  trim(preg_replace('/\s+/', ' ', ucwords(strtolower(str_replace(["\n", ' ', 'Ñ', 'Ñ'], [' ', ' ', 'ñ', 'ñ'], $request->input('first_name')))))) ;
        $lastname =  trim(preg_replace('/\s+/', ' ', ucwords(strtolower(str_replace(["\n", ' ', 'Ñ', 'Ñ'], [' ', ' ', 'ñ', 'ñ'], $request->input('last_name'))))));
        $middlename =trim(preg_replace('/\s+/', ' ', ucwords(strtolower(str_replace(["\n", ' ', 'Ñ', 'Ñ'], [' ', ' ', 'ñ', 'ñ'], $request->input('middle_name'))))));
        $email = trim($request->input('gmail'));
        $username = trim($request->input('email'));
        $password = trim($request->input('password'));
        $sex = trim($request->input('sex'));

    

        $record_admin = AdminTeacher::where('id', $id)->first();

        if ($record_admin) {
        
            if($password != ""){
                $record_admin->password = Hash::make(trim($password));
                
            }

            $record_admin->email = $email;
            $record_admin->username = $username;
            $record_admin->employee_no = $employee;
            $record_admin->firstname = $firstname;
            $record_admin->middlename = $middlename;
            $record_admin->lastname = $lastname;
            $record_admin->sex = $sex;

            $record_admin->save();

          



        }



        


        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

        

         return back()->with('success', $success);


    }
}
