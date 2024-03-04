<?php
namespace App\Http\Controllers;
use App\Models\acadYear;
use App\Models\AdminSubject;
use App\Models\listCourse;
use App\Models\AdminTeacher;
use App\Models\Adminsection;

use Illuminate\Support\Facades\Hash;


use App\Models\studentCourse;
use App\Models\AdminStudent;
use App\Models\teacher_sub;

use App\Models\student_list_w_sub_teacher;
use App\Models\sectioning;

use Illuminate\Http\Request;

class AdminSectioning extends Controller
{
    public function sectioning(){
      
 


        $track = listCourse::all();
        $subject = AdminSubject::all();
        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        
       
        return view('admin.add_student_section', compact('track', 'subject', 'acads'));
     
       
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
        $semester = $request->input('semester');
            
            $strands = Adminsection::where('track', $requests)->where('semester', $semester)->get();
            foreach($strands as $iteming){
                
                array_push($items, $iteming->section);
                array_push($ids, $iteming->id);
            }
        
          
        


    
            
        return response()->json(['strands' => $items, 'ids' => $ids]);
       
    }

    public function sectioning_student(Request $request){

        $semester = $request->input('semester');
        
        $track = $request->input('track');
        $sections = $request->input('sections');

        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;

        if ($track != "" && $sections != "") {

            
            
            $courses = listCourse::where('id', $track)->first();
          
            
           

            if(!$courses){
                return redirect()->route('teacher.section');
            }

          
          
          
            $courseName = $courses->course;
            
            $students = array();

            // $checkboxValues = studentCourse::where('course', $track)->get();
            $studentsInfo = array();
            $checkboxValues = studentCourse::where('course', $track)->get();
            foreach($checkboxValues as $id){
                $Adminsection = AdminStudent::where('id', intval($id->ownerID))->first();
                $students[] = $Adminsection;
                $tempInfo = array();
                $tempInfo['stduentS'] = $Adminsection->student_no;
                $tempInfo['fnames'] = $Adminsection->firstname;
                $tempInfo['mnames'] = $Adminsection->middlename;
                $tempInfo['lnames'] = $Adminsection->lastname;
                $tempInfo['bdayS'] = $Adminsection->birth_month . '-' . $Adminsection->birth_day . '-' . $Adminsection->birth_year;
                $tempInfo['BplaS'] = $Adminsection->birthplace;
                $tempInfo['ageS'] = $Adminsection->age;
                $tempInfo['sexS'] = $Adminsection->sex;
                $tempInfo['addS'] = $Adminsection->region . ', ' . $Adminsection->province . ', ' . $Adminsection->city . ', ' . $Adminsection->barangay . ', ' . $Adminsection->block_lot;
                $tempInfo['id'] = $Adminsection->id;

                $studentsInfo[intval($Adminsection->id)] = $tempInfo;
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

            
            $studSectionLIst = array();
     
            $all_sections = sectioning::where('section', $sections)->where('academic_year', $acads)->where('semester', $semesterID)->orderBy('created_at', 'asc')->get();
      
            foreach($all_sections as $studnes){
                $Adminsection = AdminStudent::where('id', intval($studnes->owner_id))->first();

                if($Adminsection){
                    $Adminsection['remarkings'] = $studnes->markings;
                    $Adminsection['creatingats'] = $studnes->created_at;
                    $Adminsection['IDSectioning'] = $studnes->id;
                    array_push($studSectionLIst,$Adminsection);
                }
               
               
            }
            


         return view('admin.sectioning_student', compact('studSectionLIst','studentsInfo','students','track','courseName', 'semester', 'semesterID', 'section', 'sectionID', 'acads'));
           
        }

       return redirect()->route('admin.sectioning');
        
            
        

    }
    public function print_section_reports(Request $request, $semester, $year, $section){
        
        $studSectionLIst = array();
     
        $all_sections = sectioning::where('section', $section)->where('academic_year', $year)->where('semester', $semester)->orderBy('created_at', 'asc')->get();

        if(!$all_sections){
            return back();
        }
        $sectionf = Adminsection::where('id', $section)->first();
        $section = $sectionf->section;
        $adviser = AdminTeacher::where('id', $sectionf->adviser)->first();
        if($adviser){
            $adviser = $adviser->firstname . ' ' . $adviser->lastname;
        }
        else{
            $adviser = "N/A";
        }
        $REGULAR = 0;
        $IRREGULAR = 0;
        foreach($all_sections as $studnes){
            $Adminsection = AdminStudent::where('id', intval($studnes->owner_id))->first();

            if($Adminsection){

                $Adminsection['remarkings'] = $studnes->markings;
                $Adminsection['creatingats'] = $studnes->created_at;
                if($studnes->markings == null){
                    $REGULAR++;
                }
                else{
                    $IRREGULAR++;
                }
                array_push($studSectionLIst,$Adminsection);
            }
           
           
        }

        usort($studSectionLIst, function ($a, $b) {
            return [$a->lastname, $a->firstname] <=> [$b->lastname, $b->firstname];
        });
        
        // // Display the sorted array
        // foreach ($studSectionLIst as $student) {
        //     echo "Lastname: {$student->lastname}, Firstname: {$student->firstname}<br>";
        // }
        return view('admin.print_section', compact('studSectionLIst', 'section', 'adviser','IRREGULAR','REGULAR'));

    }

    public function adding_section_student(Request $request){

           
        
      
         
        $semester = trim($request->input('semester'));
        $remarks = strtoupper(trim($request->input('remarks')));
     
        $section = trim($request->input('section_id'));
        $studenoID = $request->input('studentIDs');

        $acads = acadYear::where('current', '1')->first();
        $acads = $acads->year;
     

            $record_admin = AdminStudent::where('id', $studenoID)->first();
        
            if ($record_admin) {
              
  



                $record_admins = sectioning::
                  where('academic_year', $acads)
                ->where('semester', intval($semester))
                ->where('owner_id', intval($studenoID))
                ->first();


                if($record_admins){
                   
                    $record_admins->section = $section;
                    $record_admins->markings = $remarks;
        
                    $record_admins->save();
                }
                else{
                   
                    $add_info_admin = new sectioning([
          
                        'academic_year' => $acads,
                        'semester' => intval($semester),
                        'owner_id' => intval($studenoID),
                        'section' => $section,
                        'markings' => $remarks,
                    ]);
            
                    $add_info_admin->save();
                
                    
                }

                $success = [

                    'icon' => 'success',
                    'title' => 'Added successfully!',
                ];
        
               
             
            
                
                return back()->with('success', $success);


            
        }
    }

    public function studentlist_sections(Request $request, $sems, $year){
        
        if($sems != 'original'){

            $all_sections = sectioning::
            where('academic_year', $year)->where('semester', $sems)->get();

            if($sems == 1){
                $semester = "1ST SEMESTER";
            }
            else{
                $semester = "2ND SEMESTER"; 
            }
            $semesterDisplay = $year . ' ' . $semester;

        }
        else{
            $acads = acadYear::where('current', '1')->first();
            $acads = $acads->year;

            $all_sections = sectioning::
            where('academic_year', $acads)->get();

            $semesterDisplay = 'School year';
        }

        $studentsf = array();
        foreach($all_sections as $students){
            $Adminsection = AdminStudent::where('id', intval($students->owner_id))->first();

            if($Adminsection){
                if($students->semester == 1){
                    $semester = "1ST SEMESTER";
                }
                else{
                    $semester = "2ND SEMESTER"; 
                }

                $Adminsection['semester'] = $students->academic_year .' '. $semester;

                $Adminsection['remarkings'] = $students->markings;

                $section = Adminsection::where('id', $students->section)->first();
                $Adminsection['section'] = $section->section;

                $sectionf = listCourse::where('id', $section->track)->first();
                $Adminsection['course'] = $sectionf->course;
            
                array_push($studentsf, $Adminsection);
            }
        }

        $dropdowns = array();
        $alls = sectioning::all();
        foreach($alls as $items){
            $tempArray = array();
            $tempArray['academic_year'] = $items->academic_year;
            $tempArray['semester'] = $items->semester;

            if($items->semester == 1){
                $semester = "1ST SEMESTER";
            }
            else{
                $semester = "2ND SEMESTER"; 
            }

            $tempArray['name'] = $items->academic_year . ' ' . $semester;

            $dropdowns['"'.$tempArray['name'].'"'] = $tempArray;


        }




        
        
        return view('admin.studentlist_sections', compact('semesterDisplay','studentsf','dropdowns','all_sections'));
    }

    public function deleteSectionStudents(Request $request, $id)
    {

      

     

  

           
       
    
            $finding_user_acc = sectioning::where('id', $id)->first();

          

            $finding_user_acc->delete();

        
           
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => '',
            ];
    
            
    
             return redirect()->back()->with('delete_success', $success);
           

        

        
        
       

        
    }
}
