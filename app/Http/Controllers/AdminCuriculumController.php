<?php

namespace App\Http\Controllers;
use App\Models\AdminCuriculum;
use App\Models\acadYear;
use Illuminate\Http\Request;
use App\Models\AdminSubject;
use App\Models\studentCourse;
use App\Models\listCourse;
use App\Models\_subject_for_curiculum;
class AdminCuriculumController extends Controller
{
    public function index(){
       

        return view('admin.curiculum');
    }

    public function College_curriculum(){
        $departments = AdminCuriculum::where('course', 0)->get();

        $course = listCourse::where('course', 0)->get();

        

        return view('admin.College_curiculum', compact('departments', 'course'));
    }

    public function update_curriculum(Request $request, $id, $previous){

        $curiculums = AdminCuriculum::where('id', $id)->first();
        $subjects = _subject_for_curiculum::where('owner_id', $id)->get();

        $idsInclosure = array();

        foreach($subjects as $ids){
            $id_subject = $ids->sub_code;
            array_push($idsInclosure, $id_subject);
        }
        $subs = AdminSubject::all();

        $subjectss = array();

        foreach($subs as $ids){
            if(in_array($ids->id, $idsInclosure)){
                $id_subjectt = [

                    'title' => $ids->title,
                    'sub_code' => $ids->sub_code,
                    
    
                ];
                array_push($subjectss, $id_subjectt);
            }
            
        }
        $courseID = $curiculums['courseID'];
        $previous = $previous;
        $previousID = $previous;
        return view('admin.update_curiculum', compact('curiculums', 'subjectss', 'previous', 'courseID', 'previousID'));
    }

    public function SHS_curriculum(){

        $departments = AdminCuriculum::where('course', 1)->get();
        return view('admin.SHS_curiculum', compact('departments'));
    }

    public function add_shs_curriculum(){
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        return view('admin.add_shs_curiculum', compact('acads'));
    }
    public function add_college_curriculum(){


        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        $ids = array();

        $subjects = AdminCuriculum::where('acadYr', $acads)->get();
        $listCourse = listCourse::where('academic_yr', $acads)->get();
        if(count($listCourse) == 0){
            
            $courseComplete[] = [

                'semester' => '',
                'course' => '',
                'id' => '',
                'year' => $acads,
                'check' => 'non',
                
            ];

        
        


            return view('admin.add_college_curiculum', compact('acads','courseComplete'));
        }
      
        


       
        foreach($subjects as $id){
            
            array_push($ids,$id->courseID);
            
            
        }
        $courseComplete = array();
        
        $course = listCourse::where('academic_yr', $acads)->get();
        
        foreach($course as $coursing){
            $countCourse = AdminCuriculum::where('courseID', $coursing['id'])->first();

            if ($countCourse){
                $yearLength = 0;
                $countCoursesdadas = AdminCuriculum::where('courseID', $coursing['id'])->get();

                $yearLength = strval($coursing['YrLength']) * 2;

                $checking = 0;

                // print_r($countCoursesdadas->title);

                foreach($countCoursesdadas as $value){

                       $titlechecks = 
                        $value->title[strlen($value->title)-6]
                       . $value->title[strlen($value->title)-5]
                       . $value->title[strlen($value->title)-4]
                       . $value->title[strlen($value->title)-3]
                       . $value->title[strlen($value->title)-2] 
                       . $value->title[strlen($value->title)-1] 
                       ;
                       
                       if($titlechecks == 'Summer'){
                        $checking++;
                        
                       }
                    
                   
                }
                
                $yearLength +=  $checking;


              
                    $titles = [
    
                        'Clark College - 1st Year 1st Semester',
                        'Clark College - 1st Year 2nd Semester',

                        'Clark College - 1st Year Summer',

                        'Clark College - 2nd Year 1st Semester',
                        'Clark College - 2nd Year 2nd Semester',
            
                        'Clark College - 2nd Year Summer',
            
                        'Clark College - 3rd Year 1st Semester',
                        'Clark College - 3rd Year 2nd Semester',
            
                        'Clark College - 3rd Year Summer',

                        'Clark College - 4th Year 1st Semester',
                        'Clark College - 4th Year 2nd Semester',
            
                        'Clark College - 4th Year Summer',

                        'Clark College - 5th Year 1st Semester',
                        'Clark College - 5th Year 2nd Semester',
            
                        'Clark College - 5th Year Summer',

                        'Clark College - 6th Year 1st Semester',
                        'Clark College - 6th Year 2nd Semester',

                        'Clark College - 6th Year Summer',
            
                    ];
           
    
    
    
    
    
    
    
    
    
    
    
                


                $trues = 0;
                $countCourse = AdminCuriculum::where('courseID', $coursing['id'])->count();
                $coursename = $coursing['course'];
    
                if($yearLength == $countCourse){
                    $trues = 1;
                }
    
                $specificFields = AdminCuriculum::select('acadYr')->where('courseID', $coursing['id'])->get();
                //ANG COURSE AY HINDI PA NALAGAY SA KAYA MAY BUG DAPAT MAG IF1
                $yearsing = [];
                foreach($specificFields as $years){
                    $yearsing[] = $years['acadYr'];
                }
              
                
    
                $yourArray = $yearsing;
                $maxYear = max($yearsing);
                $valueToCheck = $maxYear;
    
                $countOfDuplicates = array_count_values($yourArray)[$valueToCheck] ?? 0;
    
                if($countOfDuplicates == 2){
                    $yearArray = explode('-', $maxYear);
    
         
                    $newYear1 = intval($yearArray[0]) + 1 . '-' . intval($yearArray[1]) + 1;
                }
                else{
                    $newYear1 = max($yearsing);
                }
    
                $semesterSummer = 'Clark College - 2nd Year Summer';
    
                $Find2ndsem = AdminCuriculum::where('title', 'Clark College - 2nd Year 2nd Semester')
                    ->where('courseID', $coursing['id'])
                    ->get();
    
                $FindSummer = AdminCuriculum::where('title', $semesterSummer)
                                ->where('courseID', $coursing['id'])
                                ->get();
    
                if (!$Find2ndsem->isEmpty() && $FindSummer->isEmpty()) {
                    $newYear1 = max($yearsing);
                } else {
                    $yearArray = explode('-', $maxYear);
    
                   $numcounts = 0 ;
                    foreach($yearsing as $checks){
                        if($maxYear == $checks){
                            $numcounts++;
                        }
                    }
                    $checkifor = $titles[$countCourse];
                    $titllescheck = $checkifor[strlen($checkifor)-6] . $checkifor[strlen($checkifor)-5] . $checkifor[strlen($checkifor)-4] . $checkifor[strlen($checkifor)-3] . $checkifor[strlen($checkifor)-2] . $checkifor[strlen($checkifor)-1];
                    if( $titllescheck == 'Summer'){
                        $newYear1 = max($yearsing);
                    }
                    else if( $numcounts != 1){
                        $newYear1 = intval($yearArray[0]) + 1 . '-' . intval($yearArray[1]) + 1;
                        $newYear1 = $newYear1;
                    }
                    else{
                        $newYear1 = max($yearsing);
                    }
                    
                   




                }
                $titleNewing = $titles[$countCourse];
            }
            else{

                $titleNewing = 'Clark College - 1st Year 1st Semester';
                $newYear1 = $acads;
                $trues = 0;
                $coursename = $coursing['course'];
            }

            

            
           



            $courseComplete[] = [

                'semester' => $titleNewing,
                'course' => $coursename,
                'id' => $coursing['id'],
                'year' => $newYear1,
                'check' => $trues
            ];

        }
        


        return view('admin.add_college_curiculum', compact('acads','courseComplete'));


    }
    public function checkIftitlesexistCurriculumSHS(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        
        // $existingEmployee = AdminCuriculum::where('title', $request->input('datacheckTitle'))
        // ->where('course', '=', '1')
        // ->first();
   
    

        // if ($existingEmployee) {
        //     return response()->json(['title' => false]);
        // } 
      
    
        // else {
            
        //     return response()->json(['title' => false]);
        // }
    }

    public function checkIftitlesexistCurriculumCollege(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        
        // $existingEmployee = AdminCuriculum::where('title', $request->input('datacheckTitle'))
        // ->where('course', '=', '0')
        // ->first();
   
    

        // if ($existingEmployee) {
        //     return response()->json(['title' => true]);
        // } 
        // else {
            
        //     return response()->json(['title' => false]);
        // }
    }

    public function adding_college_curriculum  (Request $request)
    {

        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        $ids = array();

        $subjects = AdminCuriculum::where('acadYr', $acads)->get();
        $listCourse = listCourse::where('academic_yr', $acads)->get();
        if(count($listCourse) == 0){
            
            $courseComplete[] = [

                'semester' => '',
                'course' => '',
                'id' => '',
                'year' => $acads,
                'check' => 'non',
                
            ];

        
        


            return view('admin.add_college_curiculum', compact('acads','courseComplete'));
        }

        $request->validate([
            'title' => 'required|string|between:1,70',
            'desc' => 'nullable|string|between:0,30',
           

           
           
        ]);

        $valueCourse = trim($request->input('courseCurrent'));

        $maxAttempts = 20;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            $randomNumber1 = random_int(1, 40000);
            $randomNumber2 = random_int(100, 1000);
            $randomNumber3 = random_int(200, 500);

            $ID = strval($randomNumber1) . strval($randomNumber2) . strval($randomNumber3);

            if (!AdminCuriculum::where('id', $ID)->exists()) {
                break; 
            }
        }

        
        if ($attempt > $maxAttempts) {
            return back();
        }


        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
        
        $add_info_admin = new AdminCuriculum([
            'id' => $ID,
            'title' => trim($request->input('title')),
            'desc' => trim($request->input('desc')),
            'acadYr' => trim($request->input('year')),
            'course' => '0',
            'ordering' => '',
            'courseID' => trim($request->input('course')),
            'AcadYearsEdited' => $acads,
        ]);

        $add_info_admin->save();
        
        $success = [
            'courseCurrent' => $valueCourse,
            'ID' => $ID,
            'icon' => 'success',
            'title' => 'Added successfully!',
            'text' => ''. trim($request->input('title')) . "",
        ];

       
     
    
        
        return back()->with('success', $success);
    }
    public function add_subject_curriculum (Request $request, $id){
       
        $curiculumn = AdminCuriculum::where('id', $id)->first();
        $subjects = AdminSubject::all();
        $roles_registrar = _subject_for_curiculum::where('owner_id', $id)->get();
        return view('admin.add_subject_curriculum', compact('curiculumn','subjects','roles_registrar'));
     
    }
    public function edit_subject_curriculum (Request $request, $id, $previous){
       
        $curiculumn = AdminCuriculum::where('id', $id)->first();
        $subjects = AdminSubject::all();
        $roles_registrar = _subject_for_curiculum::where('owner_id', $id)->get();

        $courseID = $curiculumn['courseID'];
        $previousID = $previous;
        return view('admin.edit_subject_curriculum', compact('curiculumn','subjects','roles_registrar', 'courseID', 'previousID'));
     
    }

    public function editCourseCurriculum (Request $request, $id){
        $previousID = $id;
        

        
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        $curiculumn = listCourse::where('id', $id)->first();
        $courseName = $curiculumn['course'];



        
            $titles = [

                'Clark College - 1st Year 1st Semester',
                'Clark College - 1st Year 2nd Semester',

                'Clark College - 1st Year Summer',

                'Clark College - 2nd Year 1st Semester',
                'Clark College - 2nd Year 2nd Semester',
    
                'Clark College - 2nd Year Summer',
    
                'Clark College - 3rd Year 1st Semester',
                'Clark College - 3rd Year 2nd Semester',
    
                'Clark College - 3rd Year Summer',

                'Clark College - 4th Year 1st Semester',
                'Clark College - 4th Year 2nd Semester',
    
                'Clark College - 4th Year Summer',

                'Clark College - 5th Year 1st Semester',
                'Clark College - 5th Year 2nd Semester',
    
                'Clark College - 5th Year Summer',

                'Clark College - 6th Year 1st Semester',
                'Clark College - 6th Year 2nd Semester',

                'Clark College - 6th Year Summer',
    
            ];
       
        

        $curiculums = array();

     
        
        for($x = 0; $x != count($titles); $x++){
            $findingCuri = AdminCuriculum::where('courseID', '=', $id)->where('title', '=', $titles[$x])->first();
            if($findingCuri){
                $curiculumn = listCourse::where('id', $id)->first();

                $subjects = array();
                
                $curiculumn = _subject_for_curiculum::where('owner_id',  $findingCuri['id'])->orderBy('id','ASC')->get();
                foreach($curiculumn as $cums){
                    $curiculumning = AdminSubject::where('id',  $cums['sub_code'])->first();
                    $subjects[] = [
                        'subject' => $curiculumning['title'],
                        'lec' => $curiculumning['lecture'],
                        'lab' => $curiculumning['lab'],
                        'code' => $curiculumning['sub_code'],
                    ];
                }
                
                $curiculums[] = [

                    'title' => $findingCuri['title'],
                    'id' => $findingCuri['id'],
                    'year' => $findingCuri['acadYr'],
                    'subs' => $subjects
                ];
            }
            
           
        }

        
        $curiculumnkn = listCourse::where('id', $id)->first();


        $subjects = AdminSubject::all();
        
        $roles_registrar = _subject_for_curiculum::where('owner_id', $id)->get();
        return view('admin.editCourseCurriculum', compact('curiculumnkn','curiculumn','curiculums','subjects','roles_registrar', 'previousID'));
     
    }
    public function adding_subject_curriculum(Request $request){
        $roles = $request->input('roles');
        $id = $request->input('id');
        $courseID = $request->input('courseID');
     

        _subject_for_curiculum::where('owner_id', $id)->delete();

        if (!empty($roles)) {
            foreach ($roles as $value) {

                $add_info_admin = new _subject_for_curiculum([

                    'owner_id' => $id,
                    'sub_code' => $value,
                    'ownerCourse' => $courseID
                ]);
        
                $add_info_admin->save();
                
            }
        }

        

        $success = [
            'ID' => '',
            'icon' => 'success',
            'title' => '',
            'text' => "Edited successfully!",
        ];

       
     
    
        
        return back()->with('success', $success);

    }
    public function delete_multiple_curriculum (Request $request){
        
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
    
            
    
                $finding_user_acc = AdminCuriculum::where('id', $checkboxValue)->first();
                $finding_user_acc->delete();


                _subject_for_curiculum::where('owner_id', $checkboxValue)->delete();
    
                $counts++;
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }


    public function MultipledeleteCourseCurriculum (Request $request){
        
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
    
            
    
               

                AdminCuriculum::where('courseID', $checkboxValue)->delete();
                _subject_for_curiculum::where('owner_id', $checkboxValue)->delete();
    
                $counts++;
            }
    
            
            
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }

    public function deleteCourseCurriculum(Request $request, $id, $password)
    {

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finadName = listCourse::where('id', $id)->first();

            $name = $finadName['course'];


            
            AdminCuriculum::where('courseID', $id)->delete();
           
            _subject_for_curiculum::where('ownerCourse', $id)->delete();


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
          
    
             return redirect()->route('admin.College_curriculum')->with('delete_success', $success);
           

        }
       

        
    }

    public function delete_curriculum(Request $request, $id, $password, $prev)
    {

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finding_user_acc = AdminCuriculum::where('id', $id)->first();
            
            $name = $finding_user_acc->title;

            $finding_user_acc->delete();

            
            _subject_for_curiculum::where('owner_id', $id)->delete();
           
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
          
    
            return redirect()->route('admin.editCourseCurriculum', ['id' => $prev])->with('delete_success', $success);
           

        }
       

        
    }

    public function updating_curriculum  (Request $request, $id)
    {
        $add_info_admin = AdminCuriculum::where('id', $id)->first();
        if(trim($request->input('title')) != $add_info_admin->title){
            $testing = 'required|string|between:1,20|unique:curiculum,title';
        }
        else{
            $testing = 'required|string|between:1,20';
        }

        $request->validate([
            'title' => $testing,
            'desc' => 'nullable|string|between:0,30',
           

           
           
        ]);
        
        $add_info_admin = AdminCuriculum::where('id', $id)->first();

       
          
       
        $add_info_admin->desc = trim($request->input('desc'));
       
    

        $add_info_admin->save();
        
        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

       
     
    

        return back()->with('success', $success);
    }
}
