<?php

namespace App\Http\Controllers;
use App\Models\listCourse;
use App\Models\listStrand;
use App\Models\AdminDepartments;
use App\Models\acadYear;
use Illuminate\Http\Request;
use App\Models\AdminTeacher;
use App\Models\Adminsection;
use App\Models\AdminCuriculum;
use App\Models\_subject_for_curiculum;
class AdminCourse_strand extends Controller
{
    public function course(){
        $departments = listCourse::all();
        
        $id_name_depart = array();

        foreach($departments as $name){
            $departmenting = AdminDepartments::where('id', $name->id_Dept)->first();

            $id_name_depart = array_merge($id_name_depart, array(
                "'" . $name->id . "'" => $departmenting->title,
            ));
        }

        return view('admin.course', compact('departments', 'id_name_depart'));
    }
    public function add_course ()
    {
        $departmenting = AdminDepartments::all();
        $teacher = AdminTeacher::all();
        return view('admin.add_course', compact('departmenting', 'teacher'));
    }

   

    public function checkIftitlesexistCourse(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        $dept = trim($request->input('id_Dept'));
        $existingEmployee = listCourse::where('course', $request->input('datacheckTitle'))->where('academic_yr', '=', $acads)->where('id_Dept', '=', $dept)->first();

    

        if ($existingEmployee) {
            return response()->json(['title' => true,]);
        } 
    
        else {
            
            return response()->json(['title' => false]);
        }
    }

    public function adding_course  (Request $request)
    {
        $imageName = "";
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        $request->validate([
            'title' => 'required|string|between:1,200',
            'lect' => 'nullable|string',
            'image' => 'image|mimes:png|max:10048',
        ]);

        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        $dept = trim($request->input('id_Dept'));
        $existingEmployee = listCourse::where('course', $request->input('title'))->where('academic_yr', '=', $acads)->where('id_Dept', '=', $dept)->first();

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


        if ($existingEmployee) {
            return back();
        } 
        
        $add_info_admin = new listCourse([
          
            'course' => trim($request->input('title')),
            'academic_yr' => $acads,
            'YrLength' => trim($request->input('lect')),
            'id_Dept' => trim($request->input('id_Dept')),
            'adviserPosition' => trim($request->input('position')),
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



    public function delete_multiple_course(Request $request){
        
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
    
            
    
                $finding_user_acc = listCourse::where('id', $checkboxValue)->first();
                $finding_user_acc->delete();

                $finding_user_accdsda = Adminsection::where('track', $checkboxValue)->delete();

                $finding_user_acc = AdminCuriculum::where('courseID', $checkboxValue)->delete();

                $finding_user_acc = _subject_for_curiculum::where('ownerCourse', $checkboxValue)->delete();
    
                $counts++;
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }

    public function delete_course(Request $request, $id, $password)
    {

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finding_user_acc = listCourse::where('id', $id)->first();

            $name = $finding_user_acc->title;

            $finding_user_acc->delete();
            $finding_user_accdsda = Adminsection::where('track', $id)->delete();
        
            $finding_user_acc = AdminCuriculum::where('courseID', $id)->delete();

            $finding_user_acc = _subject_for_curiculum::where('ownerCourse', $id)->delete();
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
            
    
             return redirect()->route('admin.track')->with('delete_success', $success);
           

        }
       

        
    }


    public function update_course  (Request $request, $id)
    {

        
        $existingEmployee = listCourse::where('id', $id)->first();


       
        $existingEmployeesdd = $existingEmployee->id_Dept;
        $departs = AdminDepartments::where('id', $existingEmployeesdd)->first();
        $departs = $departs-> title;
        $teacher = AdminTeacher::all();
        $teacherNames = AdminTeacher::where('id', $existingEmployee->adviser)->first();
        return view('admin.update_course', compact('existingEmployee', 'departs', 'teacherNames', 'teacher'));
    }


    public function updating_course  (Request $request, $id)
    {
        
        $add_info_admin = listCourse::where('id', $id)->first();
        if(trim($request->input('title')) != $add_info_admin->course){

            $acads = acadYear::where('current', '1')->first();
            $acads = $acads->year;
            $dept = trim($request->input('id_Dept'));
            
            $existingEmployee = listCourse::where('course', $request->input('title'))->where('academic_yr', '=', $acads)->where('academic_yr', '=', $dept)->first();

    

            if ($existingEmployee) {
                return back();
            } 
            $testing = 'required|string|between:1,200';
        }
        else{
            $testing = 'required|string|between:1,200';
        }

        $request->validate([
            'title' => $testing,      
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

        
        $add_info_admin = listCourse::where('id', $id)->first();

       
          
        $add_info_admin->course = trim($request->input('title'));
       
        $add_info_admin->YrLength = trim($request->input('lect'));


        $add_info_admin->imageName = $imageName;
        $add_info_admin->adviser = trim($request->input('adviser'));

        $add_info_admin->adviserPosition = trim($request->input('position'));


        $add_info_admin->save();
        
        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);
    }


    //strand


    public function strand(){
        $departments = listStrand::all();

        return view('admin.strand', compact('departments'));
    }
    public function add_strand ()
    {
        
      
        return view('admin.add_strand');
    }

    public function checkIftitlesexiststrand(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        
        $existingEmployee = listStrand::where('strand', $request->input('datacheckTitle'))->where('academic_yr', '=', $acads)->first();

    

        if ($existingEmployee) {
            return response()->json(['title' => true,]);
        } 
    
        else {
            
            return response()->json(['title' => false]);
        }
    }

    public function adding_strand  (Request $request)
    {
        $imageName = "";

        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        $request->validate([
            'title' => 'required|string|between:1,200',
            'position' => 'required|string|between:1,200',
            'lect' => 'nullable|string',
            'image' => 'image|mimes:png|max:10048',
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

        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        
        $existingEmployee = listStrand::where('strand', $request->input('title'))->where('academic_yr', '=', $acads)->first();



        if ($existingEmployee) {
            return back();
        } 
        
        $add_info_admin = new listStrand([
          
            'strand' => trim($request->input('title')),
            'academic_yr' => $acads,
            'YrLength' => trim($request->input('lect')),
            'adviserPosition' => trim($request->input('position')),
            'imageName' => $imageFile,
            'adviser' => trim($request->input('adviser')),
        ]);

        $add_info_admin->save();
        
        $success = [

            'icon' => 'success',
            'title' => 'Added successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);
    }



    public function delete_multiple_strand(Request $request){
        
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
    
            
    
                $finding_user_acc = listStrand::where('id', $checkboxValue)->first();
                $finding_user_acc->delete();


                $finding_user_acc = AdminCuriculum::where('courseID', $checkboxValue)->delete();

                $finding_user_acc = _subject_for_curiculum::where('ownerCourse', $checkboxValue)->delete();
    
                $counts++;
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }

    public function delete_strand(Request $request, $id, $password)
    {

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finding_user_acc = listStrand::where('id', $id)->first();

            $name = $finding_user_acc->title;

            $finding_user_acc->delete();

        
            $finding_user_acc = AdminCuriculum::where('courseID', $id)->delete();

            $finding_user_acc = _subject_for_curiculum::where('ownerCourse', $id)->delete();
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
            
    
             return redirect()->route('admin.strand')->with('delete_success', $success);
           

        }
       

        
    }


    public function update_strand  (Request $request, $id)
    {

        
        $existingEmployee = listStrand::where('id', $id)->first();


       
     
    
        
        return view('admin.update_strand', compact('existingEmployee'));
    }


    public function updating_strand  (Request $request, $id)
    {
        $add_info_admin = listStrand::where('id', $id)->first();
        if(trim($request->input('title')) != $add_info_admin->strand){

            $acads = acadYear::where('current', '1')->first();
            $acads = $acads->year;
            
            $existingEmployee = listStrand::where('strand', $request->input('title'))->where('academic_yr', '=', $acads)->first();

    

            if ($existingEmployee) {
                return back();
            } 
            $testing = 'required|string|between:1,200';
        }
        else{
            $testing = 'required|string|between:1,200';
        }

        $request->validate([
            'title' => $testing,      
        ]);
        
        $add_info_admin = listStrand::where('id', $id)->first();

       
          
        $add_info_admin->strand = trim($request->input('title'));
       
        $add_info_admin->YrLength = trim($request->input('lect'));

        $add_info_admin->save();
        
        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);
    }

}
