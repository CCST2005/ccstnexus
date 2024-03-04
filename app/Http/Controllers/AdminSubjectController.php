<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\_subject_for_curiculum;
use App\Models\AdminSubject;
class AdminSubjectController extends Controller
{
    public function index(){
        $departments = AdminSubject::all();

        return view('admin.subjects', compact('departments'));
    }
    public function add_subject(){
        $departments = AdminSubject::all();
        return view('admin.add_subject', compact('departments'));
    }
    public function adding_subjects (Request $request){

        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }


    
        $existingEmployee = AdminSubject::where('sub_code', $request->input('code'))->where('title', $request->input('title'))->first();

        if($existingEmployee){
            return back();
        }

        // $roles = $request->input('roles');
        // if (empty($roles)){
        //     return back();
        // }




       

        $request->validate([

            'code' => 'required|string|min:2|max:100',
            'title' => 'required|string|min:2|max:100',
            'desc' => 'nullable|string|max:150',
            'lect' => 'required|numeric|min:1|max:80',
            'lab' => 'nullable|numeric|max:3',
            'pre' => 'nullable|string|max:150',
        ]);


 


      
        $add_info_admin = new AdminSubject([
    
            'title' => trim($request->input('title')),
            'description'  => trim($request->input('desc')),
            'sub_code'  => trim($request->input('code')),
            'lecture' => trim($request->input('lect')),
            'lab'  => trim($request->input('lab')),
            'pre'  => trim($request->input('pre')),
            
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
    public function delete_subject(Request $request, $id, $password)
    {

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finding_user_acc = AdminSubject::where('id', $id)->first();
            
            
            $credentialsStuds = AdminSubject::where('pre', $id)->update(['pre' => '']);

            $finding_user_accerew = _subject_for_curiculum::where('sub_code', $id)->delete();
            $name = $finding_user_acc->title;
            $finding_user_acc->delete();

            

        
           
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
            
    
             return redirect()->route('admin.subjects')->with('delete_success', $success);
           

        }
       

        
    }
    public function delete_multiple_subject(Request $request){
        
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
    
            
    
                $finding_user_acc = AdminSubject::where('id', $checkboxValue)->first();
            
                $finding_user_accerew = _subject_for_curiculum::where('sub_code', $checkboxValue)->delete();

                $credentialsStuds = AdminSubject::where('pre', $checkboxValue)->update(['pre' => '']);
    
                $finding_user_acc->delete();
    
                $counts++;
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }


    public function update_subject  (Request $request, $id)
    {

        
        $subject = AdminSubject::where('id', $id)->first();

        $departments = AdminSubject::all();
       
     
        $pre = AdminSubject::where('id', $subject->pre)->first();
        
        return view('admin.update_subject', compact('subject','departments','pre'));
    }

    public function updating_subjects (Request $request, $id){

        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }

        $existingEmployee = false;
        $existingGmail = false;

        $exifindingsstingEmployee = AdminSubject::where('id', $id)->first();
        if($exifindingsstingEmployee->sub_code != $request->input('code') || $exifindingsstingEmployee->title != $request->input('title')){

            $existingEmployee = AdminSubject::where('sub_code', $request->input('code'))->where('title', $request->input('title'))->first();

        }
      
    
        

        

        if($existingEmployee || $existingGmail){
            return back();
        }

        // $roles = $request->input('roles');
        // if (empty($roles)){
        //     return back();
        // }




       

        $request->validate([

            'code' => 'required|string|min:2|max:100',
            'title' => 'required|string|min:2|max:100',
            'desc' => 'nullable|string|max:150',
            'lect' => 'required|numeric|min:1|max:80',
            'lab' => 'nullable|numeric|max:3',
            'pre' => 'nullable|string|max:150',
        ]);


 


      
        $record_admin = AdminSubject::where('id', $id)->first();

      

        $record_admin->title = trim($request->input('title'));
        $record_admin->description  = trim($request->input('desc'));
        $record_admin->sub_code  = trim($request->input('code'));
        $record_admin->lecture = trim($request->input('lect'));
        $record_admin->lab  = trim($request->input('lab'));
        $record_admin->pre  = trim($request->input('pre'));
            
    

        $record_admin->save();

        



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
            'title' => 'Updated successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);

    }

    public function checkIftitlesexistSubject(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        
        $existingEmployee = AdminSubject::where('title', trim($request->input('datacheckTitle')))->where('sub_code', trim($request->input('datacheckCode')))->first();
     
    

        if ($existingEmployee) {
            return response()->json(['title' => true,'code' => true]);
        } 
        
    
        else {
            
            return response()->json(['title' => false,'code' => false]);
        }
    }
}
