<?php

namespace App\Http\Controllers;
use App\Models\AdminRegistrar;
use App\Models\RoleRegistrar;
use App\Models\rolesListForregistrar;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AdminRegistrarController extends Controller
{
    public function index()
    {        


        if (!session()->has('user_logged')) {
            return view('admin.login_page_admin');
        }
        
        
        $all_registrar = AdminRegistrar::all();

       
        return view('admin.registrar_list', compact('all_registrar'));
    }

    public function add_registrar(){

        $rolesListForregistrar = rolesListForregistrar::all();
        return view('admin.add_registrar', compact('rolesListForregistrar'));
    }


    public function checkIfRegistrarExist(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        
        $existingEmployee = AdminRegistrar::where('employee_no', $request->input('datacheckEmployeeNo'))->first();

        $existingUsername = AdminRegistrar::where('username', $request->input('datacheckEmail'))->first();

        $existingemail = AdminRegistrar::where('email', $request->input('datacheckgmail'))->first();

    

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

    public function adding_registrar(Request $request){
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }


    
        $existingEmployee = AdminRegistrar::where('employee_no', $request->input('employee_no'))->first();

        $existingGmail = AdminRegistrar::where('email', $request->input('gmail'))->first();

        if($existingEmployee || $existingGmail){
            return back();
        }

        $roles = $request->input('roles');
        if (empty($roles)){
            return back();
        }


        $randomNumber = random_int(1, 100);

       

        $request->validate([
            'employee_no' => 'required|string|between:5,20|regex:/^[0-9-]+$/',
            'first_name' => 'required|string|between:2,30|regex:/^[A-Za-z\s]+$/',
            'middle_name' => 'nullable|string|between:2,30|regex:/^[A-Za-z\s]+$/',
            'last_name' => 'required|string|between:2,30|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|string|between:5,30',
            'password' => 'required|string|between:8,30',
            'gmail' => 'required|string|between:5,30|email',

           
           
        ]);

        $numbers = preg_replace("/[^0-9]/", "", $request->input('employee_no'));

        $uniqueID =  $numbers . $randomNumber;


      
        $add_info_admin = new AdminRegistrar([
            'id' => $uniqueID,
            'username' => trim($request->input('employee_no')),
            'password' => Hash::make(trim($request->input('password'))),
            'verify_question' => '',
            'verify_answer' => '',
            'role' => '', 
            'firstname' => trim($request->input('first_name')),
            'middlename' => trim($request->input('middle_name')),
            'lastname' => trim($request->input('last_name')),
            'employee_no' => trim($request->input('employee_no')),
            'image_file_name' => '',
            'darkmode' => 1,
            'disabled' => '0',
            'email' => trim($request->input('gmail')),
            
        ]);

        $add_info_admin->save();

        



        if (!empty($roles)) {
            foreach ($roles as $value) {

                $add_info_admin = new RoleRegistrar([

                    'owner_id' => $uniqueID,
                    'role' => $value,
                    
                ]);
        
                $add_info_admin->save();
                
            }
        }

        $success = [

            'icon' => 'success',
            'title' => 'Added successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);

    }


    public function delete_registrar(Request $request, $id, $password)
    {

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finding_user_acc = AdminRegistrar::where('id', $id)->first();

            $name = $finding_user_acc->firstname . " " . $finding_user_acc->lastname;

            $finding_user_acc->delete();

            
            RoleRegistrar::where('owner_id', $id)->delete();
           
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
            
    
             return redirect()->route('admin.registrar')->with('delete_success', $success);
           

        }
       

        
    }


    public function disabling_registrar(Request $request, $id)
    {

        $record_admin = AdminRegistrar::where('id', $id)->first();

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



    public function disable_multiple_registrar(Request $request){
        
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

                $record_admin = AdminRegistrar::where('id', $checkboxValue)->first();
                if($record_admin->disabled == '0'){
                    $record_admin->disabled = '1';
                    $counts++;
                    $record_admin->save();
                }
              
    
                
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }


    public function delete_multiple_registrar(Request $request){
        
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
    
            
    
                $finding_user_acc = AdminRegistrar::where('id', $checkboxValue)->first();
                $finding_user_acc->delete();


                RoleRegistrar::where('owner_id', $checkboxValue)->delete();
    
                $counts++;
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }


    public function update_registrar(Request $request, $id)
    {
        $finding_user_acc = AdminRegistrar::where('id', $id)->first();
        $roles_registrar = RoleRegistrar::where('owner_id', $id)->get();
        $rolesListForregistrar = rolesListForregistrar::all();
        return view('admin.update_registrar', compact('roles_registrar', 'finding_user_acc', 'rolesListForregistrar'));
    }


    public function updating_registrar(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        

        $request->validate([
            'employee_no' => 'required|string|between:5,20|regex:/^[0-9-]+$/',
            'first_name' => 'required|string|between:2,30|regex:/^[A-Za-z\s]+$/',
            'middle_name' => 'nullable|string|between:2,30|regex:/^[A-Za-z\s]+$/',
            'last_name' => 'required|string|between:2,30|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|string|between:5,30',
            'password' => 'nullable|string|between:8,30',
            'gmail' => 'required|string|between:5,30|email',
           
        ]);


        $employee = trim($request->input('employee_no'));
        $firstname = trim($request->input('first_name'));
        $lastname = trim($request->input('last_name'));
        $middlename = trim($request->input('middle_name'));
        $email = trim($request->input('gmail'));
        $username = trim($request->input('email'));
        $password = trim($request->input('password'));
        $roles = $request->input('roles');

        if (empty($roles)){
            return back();
        }

        $record_admin = AdminRegistrar::where('id', $id)->first();

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
            

            $record_admin->save();

            RoleRegistrar::where('owner_id', $id)->delete();

            if (!empty($roles)) {
                foreach ($roles as $value) {
    
                    $add_info_admin = new RoleRegistrar([
    
                        'owner_id' => $id,
                        'role' => $value,
                        
                    ]);
            
                    $add_info_admin->save();
                    
                }
            }


        }



        


        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

        

         return back()->with('success', $success);


    }



}
