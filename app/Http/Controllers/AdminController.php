<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Admin_Model;
use App\Models\AdminAccInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminDepartments;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    

    public function index()
    {        



      


        if (!session()->has('user_logged')) {
            return view('admin.login_page_admin');
        }
        
        
        $all_admin = AdminAccInfo::all();

      


        return view('admin.admin_list', compact('all_admin'));
    }



    public function login_page_admin(){
       

        if (session()->has('user_logged')) {

            session()->flush(); 
            session()->invalidate(); 
    
            $adminUrl = '/admin';
    
            return redirect($adminUrl);

        }
     

 
    }

    

    public function logout_admin(){
       

        if (session()->has('user_logged')) {

            session()->flush(); 
            session()->invalidate(); 
    
            $adminUrl = '/admin';
    
            return redirect($adminUrl);

        }
     

 
    }

    public function add_admin()
    {
        return view('admin.add_admin');
    }


    

    // public function session_darkmode()
    // {
    //     return redirect('/admin');
    // }


    public function loging_in(Request $request)
    {

  

        $email = $request->input('email');
        $password = $request->input('password');

        $admin = Admin_model::where('username', $email)
        ->first();
        
      
       

        if($admin){
            $admin_id = $admin->id;
            
            $storedPassword = $admin->password; 

            if (Hash::check($password, $storedPassword)) {
                $admin_info = AdminAccInfo::where('owner_id', $admin_id)->first();
                $disable = $admin_info->disabled;
                if($disable == 1){
                    
                    $success = [

                        'icon' => 'error',
                        'title' => 'This account is disabled',
                        'text' => 'Please contact the administrator for more information.',
                    ];


                    
                    return back()->with('disabled', $success);
                    
                }

                $darkmode = AdminAccInfo::where('owner_id', $admin_id)->first();

                $middle = ($darkmode->middlename)? $darkmode->middlename[0]."." : "";
                
                $fullame = $darkmode->lastname . ", " . $darkmode->firstname . " " . $middle;

                $searchingDept = AdminDepartments::all();
                $departmentsList = [];
                foreach($searchingDept as $found){

                    if(strtolower($found->title) == 'college'){
                        $newDepartments = [
                            'College' => ['title' => 'College', 
                            'routes' => 'admin.College_curriculum',
                            'route' => route('admin.College_curriculum')
                          ],
                        ];

                        
                    }
                    else if(strtolower($found->title) == 'shs' || strtolower($found->title) == 'senior high school'){
                        $newDepartments = [
                            'college' => ['title' => 'SHS', 
                            'routes' => 'admin.SHS_curriculum',
                            'route' => route('admin.SHS_curriculum')
                            ],
                        ];
                    }
                    else{
                        $newDepartments = [
                            $found->title => ['title' => $found->title, 
                            'routes' => 'admin.index',
                            'route' => route('admin.index')
                            ],
                        ];
                    }
                    $departmentsList = array_merge($departmentsList, $newDepartments);
                    

                }


                $searchingDept = AdminDepartments::all();
                $sectionList = [];

                foreach($searchingDept as $found){
                    
                    $id = $found->id;
                    $route = route('admin.section', ['department' => $id]);
                    $newDepartments = [
                        $found->title => ['title' => $found->title, 
                        'route' => $route,
                        'routes' => 'fromController',
                        'idControll' => $id,
                        ],
                    ];

                        
                    
                    $sectionList = array_merge($sectionList, $newDepartments);
                    

                }

                
                session(['user_logged' => $admin_id, 'darkmode' => $darkmode->darkmode, 'fullname' => $fullame, 'departmentsList' => $departmentsList, 'sectionList' => $sectionList]);

                return redirect()->route('admin.index');
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

    
    public function adding_admin(Request $request){
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }


        $existingEmployee = AdminAccInfo::where('employee_no', $request->input('employee_no'))->first();

        $existingGmail = Admin_model::where('email', $request->input('gmail'))->first();

        if($existingEmployee || $existingGmail){
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


        $admin_add = new Admin_model([
            'username' => trim($request->input('employee_no')),
            'password' => Hash::make(trim($request->input('password'))),
            'verify_question' => '',
            'verify_answer' => '',
            
            'id' => $uniqueID,
            'email' => trim($request->input('gmail')),
        ]);

        $admin_add->save();

      
        $add_info_admin = new AdminAccInfo([
            'owner_id' => $uniqueID,
            'employee_no' => trim($request->input('employee_no')),
            'firstname' => trim($request->input('first_name')),
            'middlename' => trim($request->input('middle_name')),
            'lastname' => trim($request->input('last_name')),
            'darkmode' => 1,
            'disabled' => '0',
            'image_file_name' => '',
            'super_admin' => '0',
            
        ]);

        $add_info_admin->save();

        $success = [

            'icon' => 'success',
            'title' => 'Added successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);

    }


    public function checkIfEmployeeExist(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        
        $existingEmployee = AdminAccInfo::where('employee_no', trim($request->input('datacheckEmployeeNo')))->first();

        $existingUsername = Admin_model::where('username', trim($request->input('datacheckEmail')))->first();

        $existingemail = Admin_model::where('email', trim($request->input('datacheckgmail')))->first();

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




    public function dark_mode(Request $request){

        if((int)$request->input('darkmode') != 1 && (int)$request->input('darkmode') != 0){
            return redirect()->route('admin.index');
        }
        

        $finding_user = AdminAccInfo::where('owner_id', session('user_logged'))->first();

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
    

    public function update_admin(Request $request, $id)
    {
        $finding_user = AdminAccInfo::where('owner_id', $id)->first();
        $finding_user_acc = Admin_model::where('id', $id)->first();

        return view('admin.update_admin', compact('finding_user', 'finding_user_acc'));
    }

    public function delete_admin(Request $request, $id, $password)
    {

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);
        
    
  
        if($hashedPassword === $ComparingHash){
           
            $finding_user = AdminAccInfo::where('owner_id', intval($id))->first();
            $name = $finding_user->firstname . " " . $finding_user->lastname;
            $finding_user->delete();
    
            $finding_user_acc = Admin_model::where('id', $id)->first();
            $finding_user_acc->delete();
    
            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
            
    
             return redirect()->route('admin.index')->with('delete_success', $success);
           

        }
       

        
    }

    public function checkpassword(Request $request){

        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }

        $finding_password = Admin_model::where('id', session('user_logged'))->first();
        

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

    public function updating_admin(Request $request, $id)
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


        $record_admin = Admin_model::where('id', $id)->first();

        if ($record_admin) {
        
            if($password != ""){
                $record_admin->password = Hash::make(trim($password));
                
            }

            $record_admin->email = $email;
            $record_admin->username = $username;

            $record_admin->save();

        }


        $record_admin_info = AdminAccInfo::where('owner_id', $id)->first();

        if ($record_admin_info) {
        
           
            $record_admin_info->employee_no = $employee;
            $record_admin_info->firstname = $firstname;
            $record_admin_info->middlename = $middlename;
            $record_admin_info->lastname = $lastname;


            $record_admin_info->save();

        }


        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

        

         return back()->with('success', $success);


    }
    public function disabling(Request $request, $id)
    {

        $record_admin = AdminAccInfo::where('owner_id', $id)->first();

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
        return redirect()->route('admin.index')->with('delete_success', $success);


    }

    public function delete_multiple(Request $request){
        
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
    
                $finding_user = AdminAccInfo::where('owner_id', $checkboxValue)->first();
                
                $finding_user->delete();
    
                $finding_user_acc = Admin_model::where('id', $checkboxValue)->first();
                $finding_user_acc->delete();
    
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


    public function disable_multiple(Request $request){
        
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

                $record_admin = AdminAccInfo::where('owner_id', $checkboxValue)->first();
                if($record_admin->disabled == '0'){
                    $record_admin->disabled = '1';
                    $counts++;
                    $record_admin->save();
                }
              
    
                
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }


    

    /**
     * Show the form for creating a new resource.
     */
    public function login_check(Request $request)
    {
        
        if (!session()->has('user_logged')) {
            return response()->json(['login' => '1']);
        }
        else{
            return response()->json(['login' => '0']);
        }
      
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin_Model $admin_Model)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin_Model $admin_Model)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin_Model $admin_Model)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin_Model $admin_Model)
    {
        //
    }
}
