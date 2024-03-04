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
    public function grade_reports(Request $request){
        if($request->input('sy') != '' && $request->input('course') != '' && $request->input('section') != ''){
            $year = $request->input('sy');
            $sem = $request->input('sem');
            $course = $request->input('course');
            $section = $request->input('section');
            $semID = $request->input('sem');
            $courseID = $course;
            $yearID = $year;
            $sectionID = $section;
            $sectionName = AdminSection::where('id', $section)->first();
            if($sectionName){
                $sectionName = $sectionName->section;
            }
           

            $courseName =  listCourse::where('id', $course)->first();
            if($courseName){
                $courseName = $courseName->course;
            }
            

            $yearName = $year;
           
            $teacher_subb = teacher_sub::where('academic_year', $year)->where('course_id', $courseID)->where('section_id', intval($sectionID))->where('semester', intval($sem))->get();

        }
        else{
            $year = '';
            $course = '';
            $section = '';
            $sectionID = '';
            $courseID = '';
            $yearID = '';
            $sectionName = '';
            $semID = '';
            $courseName = '';
            $yearName  = '';
            $teacher_subb = array();
            $sem = '';
        }
            
            
            
            

   
    


             $teacher_sub = teacher_sub::all();
             $dropdownyearing = array();
             foreach($teacher_sub as $yearing){
                $dropdownyearing[$yearing->academic_year] = $yearing->academic_year;
             }


             $listCourse = listCourse::all();
             $dropdownlistCourse = array();
             foreach($listCourse as $listCourses){
                $dropdownlistCourse[$listCourses->course] = [$listCourses->id, $listCourses->course];
             }


             $AdminSection = AdminSection::where('semester', 1)->get();
             $dropdownlistAdminSection1stSem = array();
             foreach($AdminSection as $lAdminSections){
                $dropdownlistAdminSection1stSem[] = [$lAdminSections->track, $lAdminSections->section, $lAdminSections->id];
             }



             $AdminSection = AdminSection::where('semester', 2)->get();
             $dropdownlistAdminSection2ndSem = array();
             foreach($AdminSection as $lAdminSections){
                $dropdownlistAdminSection2ndSem[] = [$lAdminSections->track, $lAdminSections->section, $lAdminSections->id];
             }
             
             
            $getStudents = array();
            if($teacher_subb){
                foreach($teacher_subb as $students){
                    $searching = student_list_w_sub_teacher::where('owner_id', $students->id)->get(); 
                    if($searching){

                        foreach($searching as $studentsget){

                            $getStudents[$studentsget->stud_id] = $studentsget->stud_id;

                        }
                        
                    }
                }
            }

           



            $studentsf = AdminStudent::all();
            $students = array();
            foreach($studentsf as $student){
                
                $studentID = intval($student->id);
                $cur = sectioning::where('owner_id', intval($studentID))->where('section', intval($sectionID))->where('semester', intval($sem))->where('academic_year', $year)->first();
                
                
                if($cur && in_array($studentID ,$getStudents)){
                    array_push($students, $student);
                }
            }

           
          
    
            $course = array();
            foreach($students as $id){
    
                $cur = studentCourse::where('ownerID', intval($id->id))->first();
                $temp = listCourse::where('id', $cur->course)->first();
                $course[$id->id] = $temp->course;
            }
    
    
            $sectioning = array();
            foreach($students as $id){
    
                $cur = sectioning::where('owner_id', intval($id->id))->exists();
    
    
                if($cur){
                    $cur = sectioning::where('owner_id', intval($id->id))->where('section', intval($sectionID))->where('semester', intval($sem))->where('academic_year', intval($year))->first();
                    $temp = AdminSection::where('id', $cur->section)->first();
                    $sectioning[$id->id] = $temp->section;
                }
                else{
                    $sectioning[$id->id] = 'N/A';
                }
               
            }
    
    
            
            return view('admin.grade_reports', compact('semID','sectionID','courseID','yearID','courseName','sectionName','yearName','dropdownlistAdminSection1stSem','dropdownlistAdminSection2ndSem','dropdownlistCourse','dropdownyearing','students', 'course', 'sectioning'));
        
        
        
    }

    public function reports_of_grades(Request $request, $id, $mode, $academicYear){

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
                        

                        
                        $studentCourse = teacher_sub::where('id', $ownerID->owner_id)->where('academic_year', $academicYear)->first();
                        $sems = [
                            '',
                            '1st Semester',
                            '2nd Semester',

                        ];
                        $sections = $studentCourse->section_id;
                        $Semesters = $sems[$studentCourse->semester];
                        if(!array_key_exists($Semesters, $dropdown)){

                            $dropdown[$Semesters] = [$academicYear, $studentCourse->semester,$Semesters,$id,$courseStudent,$sections];
                        
                        }
                    
                    
                    }
                


                }
        $mode = $mode;
    
            return view('admin.reports_of_grades', compact('dropdown', 'courseName', 'studentName', 'mode'));
        

            
        
           
        }


    }
    public function grade_reports_picked(Request $request, $year, $semester, $id, $course, $printable, $mode, $sections){
        $sectioningIds = $sections;
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
                $AdminCuriculumsf = student_list_w_sub_teacher::where('stud_id', $studentIDs)->get();

                $tempArray = array();
                foreach($AdminCuriculumsf as $subjectsfs){

                    $teacher_sub = teacher_sub::where('id', $subjectsfs->owner_id)->where('semester', $semesterIDsp)->where('academic_year', $yearIDs)->first();
                    if($teacher_sub){
                        $subjects = $teacher_sub->subject_id;
                        $teacherID = $teacher_sub->owner_id;

                        $AdminCuriculumsTeracher = AdminTeacher::where('id', $teacherID)->first();
                        $teacherName = $AdminCuriculumsTeracher->firstname . ' ' . $AdminCuriculumsTeracher->lastname;
                        $AdminCuriculums = AdminSubject::where('id', $subjects)->first();
        
                        $subjectName = $AdminCuriculums->title;
                        $subjectCode = $AdminCuriculums->sub_code;
                        $subjectLecture = $AdminCuriculums->lecture;
                        $subjectLab = $AdminCuriculums->lab;

                        $teacherSection = $teacher_sub->section_id;
                        $teacherSection = AdminSection::where('id', $teacherSection)->first();
                        $teacherSection = $teacherSection->section;
                        if($subjectsfs->gradeFinals != null){
                            $grades = $subjectsfs->gradeFinals;
                        }
                        else{
                            $grades = '-';
                        }
                        

                    }
                 
                   

                 
                    
                    ////SECS

                 
                   

                   
                    
    
                    $gradesStudent[$counts] = [
                        'teachers' => $teacherName,
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
                            '1st Semester',
                            '2nd Semester',
    
                        ];
                        $sections = $studentCourse->section_id;
                        $Semesters = $sems[$studentCourse->semester];
                        if(!array_key_exists($Semesters, $dropdown)){
    
                            $dropdown[$Semesters] = [$studentCourse->academic_year, $studentCourse->semester,$Semesters,$id,$courseStudent,$sections];
                          
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
                        
        
                        $teacher_sub = teacher_sub::where('subject_id', $subjects)->where('course_id', $course)->where('section_id', $sectioningIds)->where('academic_year', $year)->first();
                        
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
                                '1st Semester',
                                '2nd Semester',
        
                            ];
                            $sections = $studentCourse->section_id;
                            $Semesters = $sems[$studentCourse->semester];
                            if(!array_key_exists($Semesters, $dropdown)){
        
                                $dropdown[$Semesters] = [$studentCourse->academic_year, $studentCourse->semester,$Semesters,$id,$courseStudent,$sections];
                              
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
                    
    
                    $teacher_sub = teacher_sub::where('subject_id', $subjects)->where('course_id', $course)->where('section_id', $sectioningIds)->where('academic_year', $year)->first();
                    
                    


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
                            '1st Semester',
                            '2nd Semester',
    
                        ];
                        $sections = $studentCourse->section_id;
                        $Semesters =  $sems[$studentCourse->semester];
                        if(!array_key_exists($Semesters, $dropdown)){
    
                            $dropdown[$Semesters] = [$studentCourse->academic_year, $studentCourse->semester,$Semesters,$id,$courseStudent,$sections];
                          
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



    public function studentlist_reports(Request $request, $sems, $year, $sec){
        $dropdownsSEction = array();
        $firstGet = 0;
        if($sems != 'original'){
            
            $alls = AdminSection::where('semester', $sems)->orderBy('section')->get();
            foreach($alls as $items){
                
                $tempArray = array();
                $tempArray['academic_year'] = $year;
                $tempArray['semester'] = $sems;

                if($items->semester == 1){
                    $semester = "1ST SEMESTER";
                }
                else{
                    $semester = "2ND SEMESTER"; 
                }

                $tempArray['name'] = $items->section;

                $tempArray['section'] = $items->id;
                if($firstGet == 0){
                    $firstGet = $items->id;
                }
                
                $dropdownsSEction['"'.$tempArray['name'].'"'] = $tempArray;


            }

            
            if($sec == 'original'){
                $alls = array();
                if($alls){
                    $section = $alls->section;
                    $sectionsDisplay = $section;
                }
                else{
                    $sectionsDisplay = 'All';
                }
                

                
                $all_sections = sectioning::
                where('academic_year', $year)->where('semester', $sems)->get();
                if(!$all_sections){
                    return redirect()->route("admin.studentlist_reports", ['year' => 'original', 'sems' => 'original', 'sec' => 'original']);
                }
                if($sems == 1){
                    $semester = "1ST SEMESTER";
                }
                else{
                    $semester = "2ND SEMESTER"; 
                }
                $semesterDisplay = $year . ' ' . $semester;
            }
            else{
                $alls = AdminSection::where('id', $sec)->first();
             
                if(!$alls){
                    return redirect()->route("admin.studentlist_reports", ['year' => 'original', 'sems' => 'original', 'sec' => 'original']);
                }
                $section = $alls->section;
                $sectionsDisplay = $section;

                $all_sections = sectioning::
                where('academic_year', $year)->where('semester', $sems)->where('section', $sec)->get();
                if(!$all_sections){
                    return redirect()->route("admin.studentlist_reports", ['year' => 'original', 'sems' => 'original', 'sec' => 'original']);
                }
                if($sems == 1){
                    $semester = "1ST SEMESTER";
                }
                else{
                    $semester = "2ND SEMESTER"; 
                }
                $semesterDisplay = $year . ' ' . $semester;
                
            }
            

        }
        else{

            
                $acads = acadYear::where('current', '1')->first();
                $acads = $acads->year;
                
                $all_sections = sectioning::
                where('academic_year', $acads)->get();
    
                $semesterDisplay = 'School year';

                $sectionsDisplay = 'Section';
            
            

         
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
        $count = 0;
        foreach($alls as $items){
            $count++;
            $tempArray = array();
            $tempArray['academic_year'] = $items->academic_year;
            $tempArray['semester'] = $items->semester;

            if($items->semester == 1){
                $semester = "1ST SEMESTER";
            }
            else{
                $semester = "2ND SEMESTER"; 
            }
            $tempArray['section'] = 'original';

            

            $tempArray['name'] = $items->academic_year . ' ' . $semester;

            $dropdowns['"'.$tempArray['name'].'"'] = $tempArray;

            
        }


        
        $sectionID = $sec;
        $acads = $year;
        $semesterID = $sems;

        

        
        
        
        
        return view('admin.studentlist_reports', compact('sectionID','acads','semesterID','dropdownsSEction','sectionsDisplay','semesterDisplay','studentsf','dropdowns','all_sections'));
    }


    public function print_student_reports(Request $request, $semester, $year, $section){
       
        $studSectionLIst = array();
        $selection = $request->input('selection');
        
       
        if($semester != 'original' && $year != 'original'  && $section != 'original'){
            $all_sections = sectioning::where('section', $section)->where('academic_year', $year)->where('semester', $semester)->orderBy('created_at', 'asc')->get();
            $sectionf = Adminsection::where('id', $section)->first();
            $section = $sectionf->section;
            $adviser = AdminTeacher::where('id', $sectionf->adviser)->first();
            if($adviser){
                $adviser = $adviser->firstname . ' ' . $adviser->lastname;
            }
            else{
                $adviser = "N/A";
            }
        }
        else{
            $section = 'ALL';
            $adviser = "N/A";
            $all_sections = sectioning::where('academic_year', $year)->where('semester', $semester)->orderBy('created_at', 'asc')->get();
        }
        if(!$all_sections){
            return redirect()->route("admin.studentlist_reports", ['year' => 'original', 'sems' => 'original', 'sec' => 'original']);
        }
        
        
        $REGULAR = 0;
        $IRREGULAR = 0;
        foreach($all_sections as $studnes){
            $Adminsection = AdminStudent::where('id', intval($studnes->owner_id))->first();

            if($Adminsection){
                $sectionsf = Adminsection::where('id', $studnes->section)->first();
                if($sectionsf){
                    $Adminsection['section'] = $sectionsf->section;

                    $sectionf = listCourse::where('id', $sectionsf->track)->first();
                    if($sectionf){
                        $Adminsection['course'] = $sectionf->course;
                    }
                    
                }
                

          
          

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

        if($semester == 1){
            $semester = "1ST SEMESTER";
        }
        else{
            $semester = "2ND SEMESTER"; 
        }
        $semesterDisplay = $year . ' ' . $semester;
        return view('admin.print_student_reports', compact('selection', 'semesterDisplay','studSectionLIst', 'section', 'adviser','IRREGULAR','REGULAR'));

    }

    
}
