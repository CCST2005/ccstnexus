<?php

namespace App\Http\Controllers;
use App\Models\Adminsection;
use App\Models\AdminDepartments;
use App\Models\listCourse;
use Illuminate\Http\Request;
use App\Models\AdminTeacher;
use Illuminate\Support\Facades\Storage;
class AdminSections extends Controller
{
    public function section(Request $request, $department){
        $departments = AdminDepartments::where('id', $department)->get();
        if($departments->isEmpty()){
            return redirect()->route('admin.index');
        }

        $departments = Adminsection::where('department', $department)->get();
        $departmentID = $department;

        $id_name_depart = array();

        foreach($departments as $name){
            $departmenting = listCourse::where('id', $name->track)->first();

            $id_name_depart = array_merge($id_name_depart, array(
                "'" . $name->id . "'" => $departmenting->course,
            ));
        }

        return view('admin.section', compact('departments', 'departmentID', 'id_name_depart'));
    }

    public function add_section(Request $request, $department){
        $idDept = $department;
       

        $departments = AdminDepartments::where('id', $idDept)->get();
        if($departments->isEmpty()){
            return redirect()->route('admin.index');
        }

        $teacher = AdminTeacher::all();
        $collegeTrack = listCourse::where('id_Dept', $idDept)->get();


        return view('admin.add_section', compact('idDept', 'collegeTrack', 'teacher'));
    }


    public function checkIftitlesexistSection(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        
        $existingEmployee = Adminsection::where('section', $request->input('datacheckTitle'))->where('track', $request->input('trackID'))->where('department', $request->input('datacheckID'))->first();

    

        if ($existingEmployee) {
            return response()->json(['title' => true,]);
        } 
    
        else {
            
            return response()->json(['title' => false]);
        }
    }



    public function adding_section  (Request $request)
    {
        $imageName = "";
        $departments = AdminDepartments::where('id', trim($request->input('idDept')))->get();
        if($departments->isEmpty()){
            return redirect()->route('admin.index');
        }

        $request->validate([
            'title' => 'required|string|between:1,200',
            'track' => 'required',
            'desc' => 'nullable|string',
            'image' => 'image|mimes:png|max:10048', // Adjust validation rules as needed
        ]);
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $numbers = rand(1, 100) . rand(100, 200) . rand(200, 1000) . rand(10, 50);
            $imageFile = $request->file('image');
            $imageName = trim($request->input('title')) . '_' . $numbers .'.png';
              // Specify the full path to the destination directory
            $destinationPath = public_path('dist/img/E_SIGNATURES');

            // Ensure the destination directory exists; create it if not
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the file to the destination directory
            $imageFile->move($destinationPath, $imageName);

            // The $imagePath will contain the relative path within the public directory
            $imagePath = 'dist/img/E_SIGNATURES/' . $imageName;
        }
       
        
        $add_info_admin = new Adminsection([
          
            'section' => trim($request->input('title')),
            'department' => trim($request->input('idDept')),
            'desc' => trim($request->input('desc')),
            'track' => trim($request->input('track')),
            'imageName' => $imageName,
            'adviser' => trim($request->input('adviser')),
        ]);

        $add_info_admin->save();
        
        $success = [

            'icon' => 'success',
            'title' => 'Added successfully!',
        ];

       
    
    
        
       return back()->with('success', $success);
    }


    public function delete_section(Request $request, $id, $password, $department)
    {

        $idDept = $department;

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finding_user_acc = Adminsection::where('id', $id)->first();

            $name = $finding_user_acc->title;

            $finding_user_acc->delete();

        
           
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
            
    
             return redirect()->route('admin.section', ['department' => $idDept] )->with('delete_success', $success);
           

        }

        
        
       

        
    }

    public function delete_multiple_section(Request $request){


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
    
            
    
                $finding_user_acc = Adminsection::where('id', $checkboxValue)->first();
                $finding_user_acc->delete();


       
    
                $counts++;
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }

    public function update_section  (Request $request, $id)
    {

        
        $existingEmployee = Adminsection::where('id', $id)->first();
        $idDept = $existingEmployee->department;

        $departments = AdminDepartments::where('id', $idDept)->first();
        $departments = $departments->title;
        $teacher = AdminTeacher::all();
     
        $tracksName = listCourse::where('id', $existingEmployee->track)->first();
        $tracksName = $tracksName->course;

        $teacherNames = AdminTeacher::where('id', $existingEmployee->adviser)->first();
        return view('admin.update_section', compact('existingEmployee', 'departments', 'idDept', 'tracksName', 'teacher', 'teacherNames'));
    }


    public function updating_section  (Request $request, $id)
    {
        $add_info_admin = Adminsection::where('id', $id)->where('department', $request->input('idDept'))->where('track', $request->input('track'))->first();
        if(trim($request->input('title')) != $add_info_admin->section){
            $testing = 'required|string|between:1,100|unique:curiculum,title';
        }
        else{
            $testing = 'required|string|between:1,100';
        }

        $request->validate([
            'title' => $testing,
            'desc' => 'nullable|string|between:0,200',
           

            'image' => 'image|mimes:png|max:10048', // Adjust validation rules as needed
        ]);
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $numbers = rand(1, 100) . rand(100, 200) . rand(200, 1000) . rand(10, 50);
            $imageFile = $request->file('image');
            $imageName = trim($request->input('title')) . '_' . $numbers .'.png';
              // Specify the full path to the destination directory
            $destinationPath = public_path('dist/img/E_SIGNATURES');

            // Ensure the destination directory exists; create it if not
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the file to the destination directory
            $imageFile->move($destinationPath, $imageName);

            // The $imagePath will contain the relative path within the public directory
            $imagePath = 'dist/img/E_SIGNATURES/' . $imageName;
        }
        else{
            $imageName = trim($request->input('imaging'));
        }
       
        
       
        
        $add_info_admin = Adminsection::where('id', $id)->first();

       
        $add_info_admin->section = trim($request->input('title'));

        $add_info_admin->imageName = $imageName;
        
        $add_info_admin->adviser = trim($request->input('adviser'));
       
        $add_info_admin->desc = trim($request->input('desc'));
       
    

        $add_info_admin->save();
        
        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

       
     
    

        return back()->with('success', $success);
    }
}
