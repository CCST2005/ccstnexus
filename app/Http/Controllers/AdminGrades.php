<?php

namespace App\Http\Controllers;
use App\Models\AdminStudent;
use App\Models\studentCourse;
use App\Models\sectioning;
use App\Models\AdminSubject;
use App\Models\AdminSection;
use App\Models\listCourse;
use Illuminate\Http\Request;
use App\Models\AdminTeacher;
use App\Models\_subject_for_curiculum;
use App\Models\AdminCuriculum;
use App\Models\teacher_sub;
use App\Models\student_list_w_sub_teacher;
use App\Models\acadYear;
class AdminGrades extends Controller
{
    public function grade_reports(Request $request, $year){
        
        
        $students = AdminStudent::all();
        $schools = array();
        
        foreach($students as $schoolYear){
            if(!in_array($schoolYear->academic_year, $schools)){
                array_push($schools, $schoolYear->academic_year);
            }
        }



        if(in_array($year, $schools)){
            $students = AdminStudent::where('academic_year', $year)->get();
        }
        else{
            $students = AdminStudent::all();
        }

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



        return view('admin.grade_reports', compact('students', 'schools', 'course', 'sectioning'));
    }

    public function reports_of_grades(Request $request, $id, $mode){

        $cur = AdminStudent::where('id', $id)->exists();

        
            if($cur){

                $student = AdminStudent::where('id', $id)->get();
            
        

                

                foreach($student as $id){
                    $studentId = $id->id;

                    $studentsf = AdminStudent::where('id', $studentId)->first();
                    if($studentsf->middlename != ''){
                        $middles = $studentsf->middlename[0] . '.';
                    }
                    else{
                        $middles = '';
                    }
                    $studentName = $studentsf->lastname . ', ' . $studentsf->firstname . ' ' . $middles;

                    
                    $studentCourse = studentCourse::where('ownerID', $studentId)->first();

                    $courseStudent = $studentCourse->course;

                    $studentCourse = listCourse::where('id', $courseStudent)->first();

                    $courseName = $studentCourse->course;
            
            


                    $student_list_w_sub_teacher = student_list_w_sub_teacher::where('stud_id', $studentId)->get();
                    
                    $dropdown = array();
                    foreach($student_list_w_sub_teacher as $ownerID){
                        


                        $studentCourse = teacher_sub::where('id', $ownerID->owner_id)->first();
                        $sems = [
                            '',
                            ' - 1st Semester',
                            ' - 2nd Semester',

                        ];
                    
                        $Semesters = $studentCourse->academic_year . $sems[$studentCourse->semester];
                        if(!array_key_exists($Semesters, $dropdown)){

                            $dropdown[$Semesters] = [$studentCourse->academic_year, $studentCourse->semester,$Semesters,$id,$courseStudent];
                        
                        }
                    
                    
                    }
                


                }
        $mode = $mode;
    
            return view('admin.reports_of_grades', compact('dropdown', 'courseName', 'studentName', 'mode'));
        

            
        
           
        }


    }
    public function grade_reports_picked(Request $request, $year, $semester, $id, $course, $printable, $mode){
        $mode = $mode;
        $yearIDs = $year;
        $semesterIDsp = $semester;
        $studensIdsfs = $id;
        $fingingCourse = studentCourse::where('ownerID', intval($id))->first();
        $courseID = $fingingCourse->course;

        $fingingCourse = listCourse::where('id', $courseID)->first();

        if($fingingCourse->adviser != ''){
            $DepartmentNames = $fingingCourse->adviser;
            $fingingDepartmentNames = AdminTeacher::where('id', $DepartmentNames)->first();


            if($fingingDepartmentNames->sex == 'm'){

                $TeacherNameDepartment = "MR. " .  $fingingDepartmentNames->firstname . ' '. $fingingDepartmentNames->lastname;

            }
            else{
                $TeacherNameDepartment = "MS. " .  $fingingDepartmentNames->firstname . ' '. $fingingDepartmentNames->lastname;
            }
        }
        else{
            $TeacherNameDepartment = '';
        }

        if($fingingCourse->imageName != ''){
            $TeacherNameDepartmentImage = $fingingCourse->imageName;
        }
        else{
            $TeacherNameDepartmentImage = '';
        }

        if($fingingCourse->adviserPosition != ''){
            $TeacherNameDepartmentPosition = $fingingCourse->adviserPosition;
        }
        else{
            $TeacherNameDepartmentPosition = '';
        }

        

        
        

        


        
        $cur = sectioning::where('owner_id', intval($id))->first();
        $temp = AdminSection::where('id', $cur->section)->first();
        $sectioningName = $temp->section;
        $TeacherNameSignature = $temp->imageName;
        $tempic = AdminTeacher::where('id', $temp->adviser)->first();
        
        if($tempic->sex == 'm'){

            $TeacherName = "MR. " .  $tempic->firstname . ' '. $tempic->lastname;

        }
        else{
            $TeacherName = "MS. " .  $tempic->firstname . ' '. $tempic->lastname;
        }
        $TeacherName = strtoupper($TeacherName);
        $printYears = $year;
        $printSems = $semester;
        $printID = $id;
        $printCourse = $course;
        
        
        $studentIDs = $id;
        $courseIds = $course;
        $all2005 = array();
        $all2005Years = array();

        if($mode == 1){
            $titles = [
    
                'Clark College - 1st Year 1st Semester' => 1,
                'Clark College - 1st Year 2nd Semester' => 2,
    
                'Clark College - 1st Year Summer' => 3,
    
                'Clark College - 2nd Year 1st Semester' => 1,
                'Clark College - 2nd Year 2nd Semester' => 2,
    
                'Clark College - 2nd Year Summer' => 3,
    
                'Clark College - 3rd Year 1st Semester' => 1,
                'Clark College - 3rd Year 2nd Semester' => 2,
    
                'Clark College - 3rd Year Summer' => 3,
    
                'Clark College - 4th Year 1st Semester' => 1,
                'Clark College - 4th Year 2nd Semester' => 2,
    
                'Clark College - 4th Year Summer' => 3,
    
                'Clark College - 5th Year 1st Semester' => 1,
                'Clark College - 5th Year 2nd Semester' => 2,
    
                'Clark College - 5th Year Summer' => 3,
    
                'Clark College - 6th Year 1st Semester' => 1,
                'Clark College - 6th Year 2nd Semester' => 2,
    
                'Clark College - 6th Year Summer' => 3,
    
            ];
            $subjecting = array();
            
            $AdminCuriculum = AdminCuriculum::where('acadYr', $year)->where('courseID', $course)->get();
            $foundCuriculm = 0;
            foreach($AdminCuriculum as $semestefr){
    
                $semestering = $titles[$semestefr->title];
    
                if($semestering == $semester){
              
                    $foundCuriculm = $semestefr->id;
     
                    break;
    
                }
            }
            
      
                   
                $AdminCuriculums = student_list_w_sub_teacher::where('stud_id', $studentIDs)->get();
                if($AdminCuriculums){

                    foreach($AdminCuriculums as $subjectsing){

                        $teacher_sub = teacher_sub::where('id', $subjectsing->owner_id)->where('semester', $semesterIDsp)->where('academic_year', $yearIDs)->get();
                        foreach($teacher_sub as $subjectsingf){
                            
                                array_push($subjecting, $subjectsingf->subject_id);
                                
                         
                        }
                        
                    }

                    
                }
                   
              
            
          
                $gradesStudent = array();
                $counts = 0;
                // //print_r($subjecting);
                // return;
                

                foreach($subjecting as $subjects){
    
                    $AdminCuriculums = AdminSubject::where('id', $subjects)->first();
        
                    $subjectName = $AdminCuriculums->title;
                    $subjectCode = $AdminCuriculums->sub_code;
                    $subjectLecture = $AdminCuriculums->lecture;
                    $subjectLab = $AdminCuriculums->lab;
                    
    
                    $teacher_sub = teacher_sub::where('subject_id', $subjects)->where('course_id', $course)->where('semester', $semester)->where('academic_year', $year)->first();
                    
                    if($teacher_sub){
                        $teacherSection = $teacher_sub->section_id;
                        $teacherSection = AdminSection::where('id', $teacherSection)->first();
                        $teacherSection = $teacherSection->section;
                        $student_list_w_sub_teacher = student_list_w_sub_teacher::where('owner_id', $teacher_sub->id)->where('stud_id', $id)->first();
                        $grades = $student_list_w_sub_teacher->gradeFinals;
                        
                    }
                    else{
                        $teacherSection = '-';
                      
                    
                        $grades = '-';
                    }
    
                    $gradesStudent[$counts] = [
    
                        'subjectName' => $subjectName,
    
                        'subjectCode' => $subjectCode,
    
                        'subjectLecture' => $subjectLecture,
    
                        'subjectLab' => $subjectLab,
    
                        'teacherSection' => $teacherSection ,
    
                        'grades' => $grades,
    
                        
    
                    ];
    
                    $counts++;
                }
    
                if($semester == 1){
                    $semester = '1st Semester';
                }
                else if($semester == 2){
                    $semester = '2nd Semester';
                }
    
                $namingSemester = $year . ' - ' . $semester;
    
                $students = AdminStudent::where('id', $id)->first();
                if($students->middlename != ''){
                    $middles = $students->middlename[0] . '.';
                }
                else{
                    $middles = '';
                }
                $studentName = $students->lastname . ', ' . $students->firstname . ' ' . $middles;
    
                $studentCourse = listCourse::where('id', $course)->first();
                $course = $studentCourse->course;
    
           
    
            //   foreach($gradesStudent as $pogi){
    
            //     echo 'Sub name ' . $pogi['subjectName'] . '<br>';
            //     echo 'Sub code ' . $pogi['subjectCode'] . '<br>';
            //     echo 'Sub lecture ' . $pogi['subjectLecture'] . '<br>';
    
            //     echo 'Sub lab ' . $pogi['subjectLab'] . '<br>';
    
            //     echo 'Sub section take ' . $pogi['teacherSection'] . '<br>';
            //     echo 'Sub grade ' . $pogi['grades'] . '<br>';
            //     echo '<br>' . '<br>';
    
            //   }
    
            $cur = AdminStudent::where('id', $id)->exists();
    
    
            if($cur){
    
                $student = AdminStudent::where('id', $id)->get();
              
        
    
                
    
                foreach($student as $id){
                    $studentId = $id->id;
    
                    $studentsf = AdminStudent::where('id', $studentId)->first();
                    if($studentsf->middlename != ''){
                        $middles = $studentsf->middlename[0] . '.';
                    }
                    else{
                        $middles = '';
                    }
                    $studentName = $studentsf->lastname . ', ' . $studentsf->firstname . ' ' . $middles;
    
                    
                    $studentCourse = studentCourse::where('ownerID', $studentId)->first();
    
                    $courseStudent = $studentCourse->course;
    
                    $studentCourse = listCourse::where('id', $courseStudent)->first();
    
                    $courseName = $studentCourse->course;
            
             
    
    
                    $student_list_w_sub_teacher = student_list_w_sub_teacher::where('stud_id', $studentId)->get();
                    
                    $dropdown = array();
                    foreach($student_list_w_sub_teacher as $ownerID){
                        
    
    
                        $studentCourse = teacher_sub::where('id', $ownerID->owner_id)->first();
                        $sems = [
                            '',
                            ' - 1st Semester',
                            ' - 2nd Semester',
    
                        ];
                     
                        $Semesters = $studentCourse->academic_year . $sems[$studentCourse->semester];
                        if(!array_key_exists($Semesters, $dropdown)){
    
                            $dropdown[$Semesters] = [$studentCourse->academic_year, $studentCourse->semester,$Semesters,$id,$courseStudent];
                          
                        }
                    
                       
                    }
                 
    
    
                }
            
               
            }
            if($printable == "1"){
                return view('admin.print_grade', compact('TeacherNameSignature','TeacherName', 'sectioningName','printYears','printSems','printID','printCourse','dropdown', 'courseName', 'studentName', 'gradesStudent','namingSemester','mode', 'TeacherNameDepartmentPosition', 'TeacherNameDepartmentImage', 'TeacherNameDepartment'));

            }
            else{
              return view('admin.reports_of_grades', compact('TeacherNameSignature','TeacherName', 'sectioningName','printYears','printSems','printID','printCourse','dropdown', 'courseName', 'studentName', 'gradesStudent','namingSemester','mode', 'TeacherNameDepartmentPosition', 'TeacherNameDepartmentImage', 'TeacherNameDepartment'));

            }
    
            // return view('admin.print_grade', compact('dropdown', 'courseName', 'studentName', 'gradesStudent','namingSemester'));

              //return view('admin.reports_of_grades', compact('dropdown', 'courseName', 'studentName', 'gradesStudent','namingSemester'));
        }



        ///IF MODE != 2//////////////////////////////////////
        if($semester == 2005){

            $AdminCuriculum = AdminCuriculum::where('courseID', $course)->get();

            foreach($AdminCuriculum as $semester){
                $year = $semester->acadYr;
                
                


                $titles = [
    
                    'Clark College - 1st Year 1st Semester' => 1,
                    'Clark College - 1st Year 2nd Semester' => 2,
        
                    'Clark College - 1st Year Summer' => 3,
        
                    'Clark College - 2nd Year 1st Semester' => 1,
                    'Clark College - 2nd Year 2nd Semester' => 2,
        
                    'Clark College - 2nd Year Summer' => 3,
        
                    'Clark College - 3rd Year 1st Semester' => 1,
                    'Clark College - 3rd Year 2nd Semester' => 2,
        
                    'Clark College - 3rd Year Summer' => 3,
        
                    'Clark College - 4th Year 1st Semester' => 1,
                    'Clark College - 4th Year 2nd Semester' => 2,
        
                    'Clark College - 4th Year Summer' => 3,
        
                    'Clark College - 5th Year 1st Semester' => 1,
                    'Clark College - 5th Year 2nd Semester' => 2,
        
                    'Clark College - 5th Year Summer' => 3,
        
                    'Clark College - 6th Year 1st Semester' => 1,
                    'Clark College - 6th Year 2nd Semester' => 2,
        
                    'Clark College - 6th Year Summer' => 3,
        
                ];
                $courseCodes = $semester->courseID;
               
                $namingYearSem = $semester->acadYr;
                $foundCuriculm = $semester->id;
                $semesterIndexing = $semester->title;
                $semesterDisplay = $semester->title;
                $semester = $titles[$semester->title];
               
                $subjecting = array();
                
           
          
                
                
                
                    if($foundCuriculm != 0){
                       
                        $AdminCuriculums = _subject_for_curiculum::where('owner_id', $foundCuriculm)->get();
                        if($AdminCuriculums){
                            foreach($AdminCuriculums as $subjectsing){
                                array_push($subjecting, $subjectsing->sub_code);
                            }
                        }
                       
                    }
                
              
                    $gradesStudent = array();
                    $counts = 0;

                    if(count($subjecting) == 0){{
                        $gradesStudent[$counts] = [
        
                            'subjectName' => '-',
        
                            'subjectCode' => '-',
        
                            'subjectLecture' => '-',
        
                            'subjectLab' => '-',
        
                            'teacherSection' => '-' ,
        
                            'grades' => '-',
        
                            'semester' => '-'
        
                        ];
                    }

                    }
                    foreach($subjecting as $subjects){
                        $grasubfs = $subjects;
                        $AdminCuriculums = AdminSubject::where('id', $subjects)->first();
            
                        $subjectName = $AdminCuriculums->title;
                        $subjectCode = $AdminCuriculums->sub_code;
                        $subjectLecture = $AdminCuriculums->lecture;
                        $subjectLab = $AdminCuriculums->lab;
                        
        
                        $teacher_sub = teacher_sub::where('subject_id', $subjects)->where('course_id', $courseCodes)->where('semester', $semester)->where('academic_year', $namingYearSem)->first();
                        
                        if($teacher_sub){
                            $teacherSection = $teacher_sub->section_id;
                            $teacherSection = AdminSection::where('id', $teacherSection)->first();
                            $teacherSection = $teacherSection->section;
                            $student_list_w_sub_teacher = student_list_w_sub_teacher::where('owner_id', $teacher_sub->id)->where('stud_id', $studentIDs)->first();
                            
                            if($student_list_w_sub_teacher){
                                $grades = $student_list_w_sub_teacher->gradeFinals;
                            }
                            else{
                                $grades = '';
                            }
                            
                        }
                        else{
                            $teacherSection = '-';
                          
                            

                            $teacher_subfs = teacher_sub::where('subject_id', $grasubfs)->where('course_id', $courseCodes)->first();

                            if($teacher_subfs){
                                $getGradews = student_list_w_sub_teacher::where('owner_id', $teacher_subfs->id)->where('stud_id', $studensIdsfs)->first();
                                if($getGradews){
                                    $grades = $getGradews->gradeFinals;
                                }
                                else{
                                    $grades = '-';
                                }
                            }
                            else{
                                $grades = '-';
                            }
                           
                        }
                        $namingSemester = $semesterDisplay;

                        $gradesStudent[$counts] = [
        
                            'subjectName' => $subjectName,
        
                            'subjectCode' => $subjectCode,
        
                            'subjectLecture' => $subjectLecture,
        
                            'subjectLab' => $subjectLab,
        
                            'teacherSection' => $teacherSection ,
        
                            'grades' => $grades,
        
                            'semester' => $namingSemester
        
                        ];
        
                        $counts++;
                    }
        
                    if($semester == 1){
                        $semester = '1st Semester';
                    }
                    else if($semester == 2){
                        $semester = '2nd Semester';
                    }
        
                    $namingSemester = $semesterDisplay;
        
                    $students = AdminStudent::where('id', $studentIDs)->first();
                    if($students->middlename != ''){
                        $middles = $students->middlename[0] . '.';
                    }
                    else{
                        $middles = '';
                    }
                    $studentName = $students->lastname . ', ' . $students->firstname . ' ' . $middles;
        
                    $studentCourse = listCourse::where('id', $courseIds)->first();
                    $course = $studentCourse->course;
                    

                    $indexing = [
    
                        'Clark College - 1st Year 1st Semester' => 0,
                        'Clark College - 1st Year 2nd Semester' => 1,
            
                        'Clark College - 1st Year Summer' => 2,
            
                        'Clark College - 2nd Year 1st Semester' => 3,
                        'Clark College - 2nd Year 2nd Semester' => 4,
            
                        'Clark College - 2nd Year Summer' => 5,
            
                        'Clark College - 3rd Year 1st Semester' => 6,
                        'Clark College - 3rd Year 2nd Semester' => 7,
            
                        'Clark College - 3rd Year Summer' => 8,
            
                        'Clark College - 4th Year 1st Semester' => 9,
                        'Clark College - 4th Year 2nd Semester' => 10,
            
                        'Clark College - 4th Year Summer' => 11,
            
                        'Clark College - 5th Year 1st Semester' => 12,
                        'Clark College - 5th Year 2nd Semester' => 13,
            
                        'Clark College - 5th Year Summer' => 14,
            
                        'Clark College - 6th Year 1st Semester' => 15,
                        'Clark College - 6th Year 2nd Semester' => 16,
            
                        'Clark College - 6th Year Summer' => 17,
            
                    ];
               
        
                //   foreach($gradesStudent as $pogi){
        
                //     echo 'Sub name ' . $pogi['subjectName'] . '<br>';
                //     echo 'Sub code ' . $pogi['subjectCode'] . '<br>';
                //     echo 'Sub lecture ' . $pogi['subjectLecture'] . '<br>';
        
                //     echo 'Sub lab ' . $pogi['subjectLab'] . '<br>';
        
                //     echo 'Sub section take ' . $pogi['teacherSection'] . '<br>';
                //     echo 'Sub grade ' . $pogi['grades'] . '<br>';
                //     echo '<br>' . '<br>';
        
                //   }
        
                $cur = AdminStudent::where('id', $id)->exists();
        
        
                if($cur){
        
                    $student = AdminStudent::where('id', $id)->get();
                  
            
        
                    
        
                    foreach($student as $id){
                        $studentId = $id->id;
        
                        $studentsf = AdminStudent::where('id', $studentId)->first();
                        if($studentsf->middlename != ''){
                            $middles = $studentsf->middlename[0] . '.';
                        }
                        else{
                            $middles = '';
                        }
                        $studentName = $studentsf->lastname . ', ' . $studentsf->firstname . ' ' . $middles;
        
                        
                        $studentCourse = studentCourse::where('ownerID', $studentId)->first();
        
                        $courseStudent = $studentCourse->course;
        
                        $studentCourse = listCourse::where('id', $courseStudent)->first();
        
                        $courseName = $studentCourse->course;
                
                 
        
        
                        $student_list_w_sub_teacher = student_list_w_sub_teacher::where('stud_id', $studentId)->get();
                        
                        $dropdown = array();
                        foreach($student_list_w_sub_teacher as $ownerID){
                            
        
        
                            $studentCourse = teacher_sub::where('id', $ownerID->owner_id)->first();
                            $sems = [
                                '',
                                ' - 1st Semester',
                                ' - 2nd Semester',
        
                            ];
                         
                            $Semesters = $studentCourse->academic_year . $sems[$studentCourse->semester];
                            if(!array_key_exists($Semesters, $dropdown)){
        
                                $dropdown[$Semesters] = [$studentCourse->academic_year, $studentCourse->semester,$Semesters,$id,$courseStudent];
                              
                            }
                        
                           
                        }
                     
        
        
                    }
                
                   
                }



              

                // echo $indexing[$semesterIndexing];
                $all2005[$indexing[$semesterIndexing]] = $gradesStudent;
                $all2005Semester[$indexing[$semesterIndexing]] = $namingSemester;
                $all2005Years[$indexing[$semesterIndexing]] = $namingYearSem;
            }
            if($printable == "1"){
                return view('admin.print_grade', compact('TeacherNameSignature','TeacherName', 'sectioningName', 'printYears','printSems','printID','printCourse','all2005Semester','all2005Years','gradesStudent','dropdown', 'courseName', 'studentName', 'all2005','namingSemester', 'mode',  'TeacherNameDepartmentPosition', 'TeacherNameDepartmentImage', 'TeacherNameDepartment'));

            }
            else{
                return view('admin.reports_of_grades', compact('TeacherNameSignature','TeacherName', 'sectioningName','printYears','printSems','printID','printCourse','all2005Semester','all2005Years','gradesStudent','dropdown', 'courseName', 'studentName', 'all2005','namingSemester','mode',  'TeacherNameDepartmentPosition', 'TeacherNameDepartmentImage', 'TeacherNameDepartment'));

            }

            // $inst = 0;

            // for($i = 0; $i != count($all2005)-1; $i++){
            //     echo '<b>' . $all2005Semester[$i ] . '<br></b>';
            //     foreach($all2005[$i] as $pogi){
            //         // echo 'Sub name ' . $pogi['semester'] . '<br>';
            //     echo 'Sub name ' . $pogi['subjectName'] . '<br>';
            //     echo 'Sub code ' . $pogi['subjectCode'] . '<br>';
            //     echo 'Sub lecture ' . $pogi['subjectLecture'] . '<br>';
    
            //     echo 'Sub lab ' . $pogi['subjectLab'] . '<br>';
    
            //     echo 'Sub section take ' . $pogi['teacherSection'] . '<br>';
            //     echo 'Sub grade ' . $pogi['grades'] . '<br>';
            //     echo '<br>' . '<br>';
    
            //   } 
            // }


            // }
            // foreach($all2005 as $gradesStudent){  
            //         echo '<b>' . $all2005Semester[$inst ] . '<br></b>';
            //         foreach($gradesStudent as $pogi){
            //             echo 'Sub name ' . $pogi['semester'] . '<br>';
            //         echo 'Sub name ' . $pogi['subjectName'] . '<br>';
            //         echo 'Sub code ' . $pogi['subjectCode'] . '<br>';
            //         echo 'Sub lecture ' . $pogi['subjectLecture'] . '<br>';
        
            //         echo 'Sub lab ' . $pogi['subjectLab'] . '<br>';
        
            //         echo 'Sub section take ' . $pogi['teacherSection'] . '<br>';
            //         echo 'Sub grade ' . $pogi['grades'] . '<br>';
            //         echo '<br>' . '<br>';
        
            //       } 

            //       echo '<br>----------------<br>';
            //       $inst++;
            //     }
                

        }







        ////////////////////////////////////////////
        else{
            
            $titles = [
    
                'Clark College - 1st Year 1st Semester' => 1,
                'Clark College - 1st Year 2nd Semester' => 2,
    
                'Clark College - 1st Year Summer' => 3,
    
                'Clark College - 2nd Year 1st Semester' => 1,
                'Clark College - 2nd Year 2nd Semester' => 2,
    
                'Clark College - 2nd Year Summer' => 3,
    
                'Clark College - 3rd Year 1st Semester' => 1,
                'Clark College - 3rd Year 2nd Semester' => 2,
    
                'Clark College - 3rd Year Summer' => 3,
    
                'Clark College - 4th Year 1st Semester' => 1,
                'Clark College - 4th Year 2nd Semester' => 2,
    
                'Clark College - 4th Year Summer' => 3,
    
                'Clark College - 5th Year 1st Semester' => 1,
                'Clark College - 5th Year 2nd Semester' => 2,
    
                'Clark College - 5th Year Summer' => 3,
    
                'Clark College - 6th Year 1st Semester' => 1,
                'Clark College - 6th Year 2nd Semester' => 2,
    
                'Clark College - 6th Year Summer' => 3,
    
            ];
            $subjecting = array();
            
            $AdminCuriculum = AdminCuriculum::where('acadYr', $year)->where('courseID', $course)->get();
            $foundCuriculm = 0;
            foreach($AdminCuriculum as $semestefr){
    
                $semestering = $titles[$semestefr->title];
    
                if($semestering == $semester){
              
                    $foundCuriculm = $semestefr->id;
     
                    break;
    
                }
            }
            
                if($foundCuriculm != 0){
                   
                    $AdminCuriculums = _subject_for_curiculum::where('owner_id', $foundCuriculm)->get();
                    if($AdminCuriculums){
                        foreach($AdminCuriculums as $subjectsing){
                            array_push($subjecting, $subjectsing->sub_code);
                        }
                    }
                   
                }
            
          
                $gradesStudent = array();
                $counts = 0;
                foreach($subjecting as $subjects){
    
                    $AdminCuriculums = AdminSubject::where('id', $subjects)->first();
        
                    $subjectName = $AdminCuriculums->title;
                    $subjectCode = $AdminCuriculums->sub_code;
                    $subjectLecture = $AdminCuriculums->lecture;
                    $subjectLab = $AdminCuriculums->lab;
                    
    
                    $teacher_sub = teacher_sub::where('subject_id', $subjects)->where('course_id', $course)->where('semester', $semester)->where('academic_year', $year)->first();
                    
                    


                    if($teacher_sub ){


                        $teacherSection = $teacher_sub->section_id;
                        $teacherSection = AdminSection::where('id', $teacherSection)->first();
                        $teacherSection = $teacherSection->section;
                        $student_list_w_sub_teacher = student_list_w_sub_teacher::where('owner_id', $teacher_sub->id)->where('stud_id', $id)->first();
                        if($student_list_w_sub_teacher){
                            $grades = $student_list_w_sub_teacher->gradeFinals;
                        }
                        else{
                            $grades = '-';
                        }
                        
                        
                    }
                    else{
                        $teacherSection = '-';
                      
                    
                        $grades = '-';
                    }
    
                    $gradesStudent[$counts] = [
    
                        'subjectName' => $subjectName,
    
                        'subjectCode' => $subjectCode,
    
                        'subjectLecture' => $subjectLecture,
    
                        'subjectLab' => $subjectLab,
    
                        'teacherSection' => $teacherSection ,
    
                        'grades' => $grades,
    
                        
    
                    ];
    
                    $counts++;
                }
    
                if($semester == 1){
                    $semester = '1st Semester';
                }
                else if($semester == 2){
                    $semester = '2nd Semester';
                }
    
                $namingSemester = $year . ' - ' . $semester;
    
                $students = AdminStudent::where('id', $id)->first();
                if($students->middlename != ''){
                    $middles = $students->middlename[0] . '.';
                }
                else{
                    $middles = '';
                }
                $studentName = $students->lastname . ', ' . $students->firstname . ' ' . $middles;
    
                $studentCourse = listCourse::where('id', $course)->first();
                $course = $studentCourse->course;
    
           
    
            //   foreach($gradesStudent as $pogi){
    
            //     echo 'Sub name ' . $pogi['subjectName'] . '<br>';
            //     echo 'Sub code ' . $pogi['subjectCode'] . '<br>';
            //     echo 'Sub lecture ' . $pogi['subjectLecture'] . '<br>';
    
            //     echo 'Sub lab ' . $pogi['subjectLab'] . '<br>';
    
            //     echo 'Sub section take ' . $pogi['teacherSection'] . '<br>';
            //     echo 'Sub grade ' . $pogi['grades'] . '<br>';
            //     echo '<br>' . '<br>';
    
            //   }
    
            $cur = AdminStudent::where('id', $id)->exists();
    
    
            if($cur){
    
                $student = AdminStudent::where('id', $id)->get();
              
        
    
                
    
                foreach($student as $id){
                    $studentId = $id->id;
    
                    $studentsf = AdminStudent::where('id', $studentId)->first();
                    if($studentsf->middlename != ''){
                        $middles = $studentsf->middlename[0] . '.';
                    }
                    else{
                        $middles = '';
                    }
                    $studentName = $studentsf->lastname . ', ' . $studentsf->firstname . ' ' . $middles;
    
                    
                    $studentCourse = studentCourse::where('ownerID', $studentId)->first();
    
                    $courseStudent = $studentCourse->course;
    
                    $studentCourse = listCourse::where('id', $courseStudent)->first();
    
                    $courseName = $studentCourse->course;
            
             
    
    
                    $student_list_w_sub_teacher = student_list_w_sub_teacher::where('stud_id', $studentId)->get();
                    
                    $dropdown = array();
                    foreach($student_list_w_sub_teacher as $ownerID){
                        
    
    
                        $studentCourse = teacher_sub::where('id', $ownerID->owner_id)->first();
                        $sems = [
                            '',
                            ' - 1st Semester',
                            ' - 2nd Semester',
    
                        ];
                     
                        $Semesters = $studentCourse->academic_year . $sems[$studentCourse->semester];
                        if(!array_key_exists($Semesters, $dropdown)){
    
                            $dropdown[$Semesters] = [$studentCourse->academic_year, $studentCourse->semester,$Semesters,$id,$courseStudent];
                          
                        }
                    
                       
                    }
                 
    
    
                }
            
               
            }
            if($printable == "1"){
                return view('admin.print_grade', compact('TeacherNameSignature','TeacherName', 'sectioningName','printYears','printSems','printID','printCourse','dropdown', 'courseName', 'studentName', 'gradesStudent','namingSemester','mode',  'TeacherNameDepartmentPosition', 'TeacherNameDepartmentImage', 'TeacherNameDepartment'));

            }
            else{
              return view('admin.reports_of_grades', compact('TeacherNameSignature','TeacherName', 'sectioningName','printYears','printSems','printID','printCourse','dropdown', 'courseName', 'studentName', 'gradesStudent','namingSemester','mode',  'TeacherNameDepartmentPosition', 'TeacherNameDepartmentImage', 'TeacherNameDepartment'));

            }
    
            // return view('admin.print_grade', compact('dropdown', 'courseName', 'studentName', 'gradesStudent','namingSemester'));

              //return view('admin.reports_of_grades', compact('dropdown', 'courseName', 'studentName', 'gradesStudent','namingSemester'));
        }


        

    }




    
}
