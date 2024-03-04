<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.login_page_admin');
});

Route::get('kiosk', 'App\Http\Controllers\AdminStudentController@add_student_kiosk')->name('kiosk.index');
Route::get('kiosk/new_add_student_kiosk', 'App\Http\Controllers\AdminStudentController@new_add_student_kiosk')->name('kiosk.new_add_student_kiosk');
Route::get('kiosk/update_student_kiosk', 'App\Http\Controllers\AdminStudentController@update_student_kiosk')->name('kiosk.update_student_kiosk');


Route::match(['get', 'post'], 'kiosk/updating_student/{id}', 'App\Http\Controllers\AdminStudentController@kiosk_updating_student')->name('kiosk.updating_student');
Route::match(['get', 'post'],'kiosk/searched_student_kiosk', 'App\Http\Controllers\AdminStudentController@searched_student_kiosk')->name('kiosk.searched_student_kiosk');

Route::match(['get', 'post'],'kiosk/adding_student_kiosk', 'App\Http\Controllers\AdminStudentController@adding_student_kiosk')->name('kiosk.adding_student_kiosk');



Route::match(['get', 'post'], 'admin/login_page_admin', 'App\Http\Controllers\AdminController@login_page_admin')->name('admin.login_page_admin');

//ADMIN ACCOUNTS



Route::get('admin/logging_out', 'App\Http\Controllers\AdminController@logout_admin')->name('admin.logout_admin');

Route::get('admin/session_darkmode', 'App\Http\Controllers\AdminController@session_darkmode')->name('admin.session_darkmode')->middleware('preventManualAccess');

Route::post('admin/loging_in', 'App\Http\Controllers\AdminController@loging_in')->name('admin.loging_in');

Route::match(['get', 'post'], 'admin/login_check', 'App\Http\Controllers\AdminController@login_check')->name('admin.login_check');

Route::get('admin/add_admin', 'App\Http\Controllers\AdminController@add_admin')->name('admin.add_admin')->middleware('preventManualAccess');


Route::match(['get', 'post'], 'admin/adding_admin', 'App\Http\Controllers\AdminController@adding_admin')->name('admin.adding_admin')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/checking_employee_exist', 'App\Http\Controllers\AdminController@checkIfEmployeeExist')->name('admin.checkIfEmployeeExist')->middleware('preventManualAccess');


Route::match(['get', 'post'], 'admin/dark_mode', 'App\Http\Controllers\AdminController@dark_mode')->name('admin.dark_mode')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/checkpassword', 'App\Http\Controllers\AdminController@checkpassword')->name('admin.checkpassword')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/delete_multiple', 'App\Http\Controllers\AdminController@delete_multiple')->name('admin.delete_multiple')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/disable_multiple', 'App\Http\Controllers\AdminController@disable_multiple')->name('admin.disable_multiple')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/updating_admin/{id}', 'App\Http\Controllers\AdminController@updating_admin')->name('admin.updating_admin')->middleware('preventManualAccess');

Route::get('admin/update_admin/{id}', 'App\Http\Controllers\AdminController@update_admin')->name('admin.update_admin')->middleware('preventManualAccess');
Route::get('admin/delete_admin/{id}/{password}', 'App\Http\Controllers\AdminController@delete_admin')->name('admin.delete_admin')->middleware('preventManualAccess');

Route::get('admin/success_message/{icon}/{title}', 'App\Http\Controllers\AdminController@success_message')->name('admin.success_message')->middleware('preventManualAccess');

Route::get('admin/disabling/{id}', 'App\Http\Controllers\AdminController@disabling')->name('admin.disabling')->middleware('preventManualAccess');


//END LINE ADMIN ACCOUNTS



//REGISTRAR ACCOUNTS

Route::get('admin/registrar', 'App\Http\Controllers\AdminRegistrarController@index')->name('admin.registrar')->middleware('preventManualAccess');
Route::get('admin/add_registrar', 'App\Http\Controllers\AdminRegistrarController@add_registrar')->name('admin.add_registrar')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/adding_registrar', 'App\Http\Controllers\AdminRegistrarController@adding_registrar')->name('admin.adding_registrar')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/checkIfRegistrarExist', 'App\Http\Controllers\AdminRegistrarController@checkIfRegistrarExist')->name('admin.checkIfRegistrarExist')->middleware('preventManualAccess');

Route::get('admin/delete_registrar/{id}/{password}', 'App\Http\Controllers\AdminRegistrarController@delete_registrar')->name('admin.delete_registrar')->middleware('preventManualAccess');

Route::get('admin/disabling_registrar/{id}', 'App\Http\Controllers\AdminRegistrarController@disabling_registrar')->name('admin.disabling_registrar')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/disable_multiple_registrar', 'App\Http\Controllers\AdminRegistrarController@disable_multiple_registrar')->name('admin.disable_multiple_registrar')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/update_registrar/{id}', 'App\Http\Controllers\AdminRegistrarController@update_registrar')->name('admin.update_registrar')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/delete_multiple_registrar', 'App\Http\Controllers\AdminRegistrarController@delete_multiple_registrar')->name('admin.delete_multiple_registrar')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/updating_registrar/{id}', 'App\Http\Controllers\AdminRegistrarController@updating_registrar')->name('admin.updating_registrar')->middleware('preventManualAccess');

//END LINE REGISTRAR ACCOUNTS



//TEACHER ACCOUNTS

Route::get('admin/teacher', 'App\Http\Controllers\AdminTeacherController@index')->name('admin.teacher')->middleware('preventManualAccess');



Route::get('admin/add_teacher', 'App\Http\Controllers\AdminTeacherController@add_teacher')->name('admin.add_teacher')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/adding_teacher', 'App\Http\Controllers\AdminTeacherController@adding_teacher')->name('admin.adding_teacher')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/checkIfTeacherExist', 'App\Http\Controllers\AdminTeacherController@checkIfTeacherExist')->name('admin.checkIfTeacherExist')->middleware('preventManualAccess');

Route::get('admin/delete_teacher/{id}/{password}', 'App\Http\Controllers\AdminTeacherController@delete_teacher')->name('admin.delete_teacher')->middleware('preventManualAccess');

Route::get('admin/disabling_teacher/{id}', 'App\Http\Controllers\AdminTeacherController@disabling_teacher')->name('admin.disabling_teacher')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/disable_multiple_teacher', 'App\Http\Controllers\AdminTeacherController@disable_multiple_teacher')->name('admin.disable_multiple_teacher')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/update_teacher/{id}', 'App\Http\Controllers\AdminTeacherController@update_teacher')->name('admin.update_teacher')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/delete_multiple_teacher', 'App\Http\Controllers\AdminTeacherController@delete_multiple_teacher')->name('admin.delete_multiple_teacher')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/updating_teacher/{id}', 'App\Http\Controllers\AdminTeacherController@updating_teacher')->name('admin.updating_teacher')->middleware('preventManualAccess');

//END LINE TEACHER ACCOUNTS


//STUDENT ACCOUNTS

Route::get('admin/student', 'App\Http\Controllers\AdminStudentController@index')->name('admin.student')->middleware('preventManualAccess');



Route::get('admin/add_student', 'App\Http\Controllers\AdminStudentController@add_student')->name('admin.add_student')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/adding_student', 'App\Http\Controllers\AdminStudentController@adding_student')->name('admin.adding_student')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/checkIfStudentExist', 'App\Http\Controllers\AdminStudentController@checkIfStudentExist')->name('admin.checkIfStudentExist')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/gettingStrand', 'App\Http\Controllers\AdminStudentController@gettingStrand')->name('admin.gettingStrand')->middleware('preventManualAccess');

Route::get('admin/delete_student/{id}/{password}', 'App\Http\Controllers\AdminStudentController@delete_student')->name('admin.delete_student')->middleware('preventManualAccess');

Route::get('admin/disabling_student/{id}', 'App\Http\Controllers\AdminStudentController@disabling_student')->name('admin.disabling_student')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/disable_multiple_student', 'App\Http\Controllers\AdminStudentController@disable_multiple_student')->name('admin.disable_multiple_student')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/update_student/{id}', 'App\Http\Controllers\AdminStudentController@update_student')->name('admin.update_student')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/delete_multiple_student', 'App\Http\Controllers\AdminStudentController@delete_multiple_student')->name('admin.delete_multiple_student')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/updating_student/{id}', 'App\Http\Controllers\AdminStudentController@updating_student')->name('admin.updating_student')->middleware('preventManualAccess');

//END LINE STUDENT ACCOUNTS



Route::get('admin/academic_year', 'App\Http\Controllers\AcademYr@index')->name('admin.academic_year')->middleware('preventManualAccess');
Route::get('admin/update_acad/{id}/{password}', 'App\Http\Controllers\AcademYr@update_acad')->name('admin.update_acad')->middleware('preventManualAccess');

Route::get('admin/departments', 'App\Http\Controllers\AdminDepartment@index')->name('admin.departments')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/adding_departments', 'App\Http\Controllers\AdminDepartment@adding_departments')->name('admin.adding_departments')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/checkIftitlesexist', 'App\Http\Controllers\AdminDepartment@checkIftitlesexist')->name('admin.checkIftitlesexist')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/update_department/{id}', 'App\Http\Controllers\AdminDepartment@update_department')->name('admin.update_department')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/updating_department/{id}', 'App\Http\Controllers\AdminDepartment@updating_department')->name('admin.updating_department')->middleware('preventManualAccess');
Route::get('admin/add_departments', 'App\Http\Controllers\AdminDepartment@add_department')->name('admin.add_departments')->middleware('preventManualAccess');
Route::get('admin/delete_department/{id}/{password}', 'App\Http\Controllers\AdminDepartment@delete_department')->name('admin.delete_department')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/delete_multiple_department', 'App\Http\Controllers\AdminDepartment@delete_multiple_department')->name('admin.delete_multiple_department')->middleware('preventManualAccess');

// AdminSubjectController
Route::match(['get', 'post'], 'admin/update_subject/{id}', 'App\Http\Controllers\AdminSubjectController@update_subject')->name('admin.update_subject')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/checkIftitlesexistSubject', 'App\Http\Controllers\AdminSubjectController@checkIftitlesexistSubject')->name('admin.checkIftitlesexistSubject')->middleware('preventManualAccess');
Route::get('admin/delete_subject/{id}/{password}', 'App\Http\Controllers\AdminSubjectController@delete_subject')->name('admin.delete_subject')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/delete_multiple_subject', 'App\Http\Controllers\AdminSubjectController@delete_multiple_subject')->name('admin.delete_multiple_subject')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/updating_subjects/{id}', 'App\Http\Controllers\AdminSubjectController@updating_subjects')->name('admin.updating_subjects')->middleware('preventManualAccess');

Route::get('admin/subjects', 'App\Http\Controllers\AdminSubjectController@index')->name('admin.subjects')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/adding_subjects', 'App\Http\Controllers\AdminSubjectController@adding_subjects')->name('admin.adding_subjects')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/add_subject', 'App\Http\Controllers\AdminSubjectController@add_subject')->name('admin.add_subject')->middleware('preventManualAccess');
// ENDAdminSubjectController


Route::get('admin/College_curriculum/{year}', 'App\Http\Controllers\AdminCuriculumController@College_curriculum')->name('admin.College_curriculum')->middleware('preventManualAccess');
Route::get('admin/SHS_curriculum', 'App\Http\Controllers\AdminCuriculumController@SHS_curriculum')->name('admin.SHS_curriculum')->middleware('preventManualAccess');

Route::get('admin/add_shs_curriculum', 'App\Http\Controllers\AdminCuriculumController@add_shs_curriculum')->name('admin.add_shs_curriculum')->middleware('preventManualAccess');
Route::get('admin/add_college_curriculum', 'App\Http\Controllers\AdminCuriculumController@add_college_curriculum')->name('admin.add_college_curriculum')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/checkIftitlesexistCurriculumSHS', 'App\Http\Controllers\AdminCuriculumController@checkIftitlesexistCurriculumSHS')->name('admin.checkIftitlesexistCurriculumSHS')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/checkIftitlesexistCurriculumCollege', 'App\Http\Controllers\AdminCuriculumController@checkIftitlesexistCurriculumCollege')->name('admin.checkIftitlesexistCurriculumCollege')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/adding_college_curriculum', 'App\Http\Controllers\AdminCuriculumController@adding_college_curriculum')->name('admin.adding_college_curriculum')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/add_subject_curriculum/{id}', 'App\Http\Controllers\AdminCuriculumController@add_subject_curriculum')->name('admin.add_subject_curriculum')->middleware('preventManualAccess');
Route::post('admin/adding_subject_curriculum', 'App\Http\Controllers\AdminCuriculumController@adding_subject_curriculum')->name('admin.adding_subject_curriculum')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/editCourseCurriculum/{id}/{year}', 'App\Http\Controllers\AdminCuriculumController@editCourseCurriculum')->name('admin.editCourseCurriculum')->middleware('preventManualAccess');
Route::get('admin/deleteCourseCurriculum/{id}/{password}', 'App\Http\Controllers\AdminCuriculumController@deleteCourseCurriculum')->name('admin.deleteCourseCurriculum')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/MultipledeleteCourseCurriculum', 'App\Http\Controllers\AdminCuriculumController@MultipledeleteCourseCurriculum')->name('admin.MultipledeleteCourseCurriculum')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/delete_multiple_curriculum', 'App\Http\Controllers\AdminCuriculumController@delete_multiple_curriculum')->name('admin.delete_multiple_curriculum')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/updating_curriculum/{id}', 'App\Http\Controllers\AdminCuriculumController@updating_curriculum')->name('admin.updating_curriculum')->middleware('preventManualAccess');
Route::get('admin/update_curriculum/{id}/{previous}/{year}', 'App\Http\Controllers\AdminCuriculumController@update_curriculum')->name('admin.update_curriculum')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/edit_subject_curriculum/{id}/{previous}/{courseID}/{year}', 'App\Http\Controllers\AdminCuriculumController@edit_subject_curriculum')->name('admin.edit_subject_curriculum')->middleware('preventManualAccess');
Route::get('admin/delete_curriculum/{id}/{password}/{prev}', 'App\Http\Controllers\AdminCuriculumController@delete_curriculum')->name('admin.delete_curriculum')->middleware('preventManualAccess');
Route::get('admin/','App\Http\Controllers\AdminController@index')->name('admin.index')->middleware('preventManualAccess');



//tracks 
Route::get('admin/tracks', 'App\Http\Controllers\AdminCourse_strand@course')->name('admin.track')->middleware('preventManualAccess');
Route::get('admin/add_tracks', 'App\Http\Controllers\AdminCourse_strand@add_course')->name('admin.add_track')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/adding_tracks', 'App\Http\Controllers\AdminCourse_strand@adding_course')->name('admin.adding_track')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/checkIftitlesexistCourse', 'App\Http\Controllers\AdminCourse_strand@checkIftitlesexistCourse')->name('admin.checkIftitlesexistCourse')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/delete_multiple_track', 'App\Http\Controllers\AdminCourse_strand@delete_multiple_course')->name('admin.delete_multiple_track')->middleware('preventManualAccess');
Route::get('admin/delete_track/{id}/{password}', 'App\Http\Controllers\AdminCourse_strand@delete_course')->name('admin.delete_track')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/update_tracks/{id}', 'App\Http\Controllers\AdminCourse_strand@update_course')->name('admin.update_track')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/updating_tracks/{id}', 'App\Http\Controllers\AdminCourse_strand@updating_course')->name('admin.updating_track')->middleware('preventManualAccess');


//ENDtracks




//SECTION
Route::get('admin/section/{department}/{year}/{semester}/{course}', 'App\Http\Controllers\AdminSections@section')->name('admin.section')->middleware('preventManualAccess');



Route::get('admin/add_section/{department}/{year}/{semester}/{course}', 'App\Http\Controllers\AdminSections@add_section')->name('admin.add_section')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/checkIftitlesexistSection', 'App\Http\Controllers\AdminSections@checkIftitlesexistSection')->name('admin.checkIftitlesexistSection')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/adding_section', 'App\Http\Controllers\AdminSections@adding_section')->name('admin.adding_section')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/updating_section/{id}', 'App\Http\Controllers\AdminSections@updating_section')->name('admin.updating_section')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/delete_multiple_section', 'App\Http\Controllers\AdminSections@delete_multiple_section')->name('admin.delete_multiple_section')->middleware('preventManualAccess');
Route::get('admin/delete_section/{id}/{password}/{department}', 'App\Http\Controllers\AdminSections@delete_section')->name('admin.delete_section')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/update_section/{id}/{year}/{semester}/{course}', 'App\Http\Controllers\AdminSections@update_section')->name('admin.update_section')->middleware('preventManualAccess');


//ENDSECTION




//SECTIONING
Route::match(['get', 'post'], 'admin/gettingSectionTeacher', 'App\Http\Controllers\AdminSectioning@gettingSectionTeacher')->name('admin.gettingSectionTeacher')->middleware('preventManualAccess');

Route::get('admin/sectioning', 'App\Http\Controllers\AdminSectioning@sectioning')->name('admin.sectioning')->middleware('preventManualAccess');

Route::get('admin/AdminSectioning/{sems}/{year}', 'App\Http\Controllers\AdminSectioning@studentlist_sections')->name('admin.studentlist_sections')->middleware('preventManualAccess');

Route::get('admin/print_section_reports/{semester}/{year}/{section}', 'App\Http\Controllers\AdminSectioning@print_section_reports')->name('admin.print_section_reports')->middleware('preventManualAccess');


Route::get('admin/sectioning_student', 'App\Http\Controllers\AdminSectioning@sectioning_student')->name('admin.sectioning_student')->middleware('preventManualAccess');

Route::post('admin/adding_section_student', 'App\Http\Controllers\AdminSectioning@adding_section_student')->name('admin.adding_section_student')->middleware('preventManualAccess');

Route::get('admin/deleteSectionStudents/{id}', 'App\Http\Controllers\AdminSectioning@deleteSectionStudents')->name('admin.deleteSectionStudents')->middleware('preventManualAccess');


//ENDSECTIONING



//SECTIONING



//ENDSECTIONING



//ADMINREPORTS

Route::get('admin/reports_of_grades/{id}/{mode}/{year}', 'App\Http\Controllers\AdminGrades@reports_of_grades')->name('admin.reports_of_grades')->middleware('preventManualAccess');
Route::get('admin/grade_reports', 'App\Http\Controllers\AdminGrades@grade_reports')->name('admin.grade_reports')->middleware('preventManualAccess');

Route::get('admin/studentlist_reports/{sems}/{year}/{sec}', 'App\Http\Controllers\AdminGrades@studentlist_reports')->name('admin.studentlist_reports')->middleware('preventManualAccess');

Route::get('admin/print_student_reports/{semester}/{year}/{section}', 'App\Http\Controllers\AdminGrades@print_student_reports')->name('admin.print_student_reports')->middleware('preventManualAccess');

Route::get('admin/grade_reports/{year}/{semester}/{id}/{course}/{printable}/{mode}/{section}', 'App\Http\Controllers\AdminGrades@grade_reports_picked')->name('admin.grade_reports_picked')->middleware('preventManualAccess');
//ENDADMINREPORTS


use App\Http\Controllers\TeacherUpload;


Route::get('/teacher', function () {
    return view('teacher.login_page_teacher');
});

Route::get('/upload-form', [TeacherUpload::class, 'uploadForm']);
Route::post('/process-excel', [TeacherUpload::class, 'processExcel'])->name('process.excel')->middleware('preventManualAccessTeacher');
Route::post('/process-upload', [TeacherUpload::class, 'processUpload'])->name('process.upload')->middleware('preventManualAccessTeacher');
Route::post('teacher/loging_in', 'App\Http\Controllers\TeacherUpload@loging_in')->name('teacher.loging_in');

Route::get('teacher/upload-form', 'App\Http\Controllers\TeacherUpload@uploadForm')->name('teacher.upload-form')->middleware('preventManualAccessTeacher');
Route::get('teacher/','App\Http\Controllers\TeacherUpload@index')->name('teacher.index');

Route::get('teacher/logout_admin','App\Http\Controllers\TeacherUpload@logout_admin')->name('teacher.logout_admin')->middleware('preventManualAccessTeacher');

Route::match(['get', 'post'], 'teacher/dark_mode', 'App\Http\Controllers\TeacherUpload@dark_mode')->name('teacher.dark_mode')->middleware('preventManualAccessTeacher');




//SECTIONTEACHER
Route::get('teacher/section', 'App\Http\Controllers\teacherSections@add_section')->name('teacher.section')->middleware('preventManualAccessTeacher');

Route::get('teacher/disabledPage', 'App\Http\Controllers\teacherSections@disabledPage')->name('teacher.disabledPage')->middleware('preventManualAccessTeacher');

Route::post('teacher/check_section_student', 'App\Http\Controllers\teacherSections@check_section_student')->name('teacher.check_section_student')->middleware('preventManualAccessTeacher');

Route::post('teacher/adding_section_student', 'App\Http\Controllers\teacherSections@adding_section_student')->name('teacher.adding_section_student')->middleware('preventManualAccessTeacher');
Route::get('teacher/add_section_student', 'App\Http\Controllers\teacherSections@add_section_student')->name('teacher.add_section_student')->middleware('preventManualAccessTeacher');
Route::get('teacher/add_section', 'App\Http\Controllers\teacherSections@add_section')->name('teacher.add_section')->middleware('preventManualAccessTeacher');
Route::match(['get', 'post'], 'teacher/checkIftitlesexistSection', 'App\Http\Controllers\teacherSections@checkIftitlesexistSection')->name('teacher.checkIftitlesexistSection')->middleware('preventManualAccessTeacher');
Route::match(['get', 'post'], 'teacher/adding_section', 'App\Http\Controllers\teacherSections@adding_section')->name('teacher.adding_section')->middleware('preventManualAccessTeacher');
Route::match(['get', 'post'], 'teacher/updating_section/{id}', 'App\Http\Controllers\teacherSections@updating_section')->name('teacher.updating_section')->middleware('preventManualAccessTeacher');
Route::match(['get', 'post'], 'teacher/delete_multiple_section', 'App\Http\Controllers\teacherSections@delete_multiple_section')->name('teacher.delete_multiple_section')->middleware('preventManualAccessTeacher');
Route::get('teacher/delete_section/{id}/{password}/{department}', 'App\Http\Controllers\teacherSections@delete_section')->name('teacher.delete_section')->middleware('preventManualAccessTeacher');
Route::match(['get', 'post'], 'teacher/update_section/{id}', 'App\Http\Controllers\teacherSections@update_section')->name('teacher.update_section')->middleware('preventManualAccessTeacher');

Route::get('teacher/edit_section/{academic}', 'App\Http\Controllers\teacherSections@edit_section')->name('teacher.edit_section')->middleware('preventManualAccessTeacher');

Route::match(['get', 'post'], 'teacher/gettingSectionTeacher', 'App\Http\Controllers\teacherSections@gettingSectionTeacher')->name('admin.gettingSectionTeacher')->middleware('preventManualAccessTeacher');
Route::match(['get', 'post'], 'teacher/gettingfillSubsTeacher', 'App\Http\Controllers\teacherSections@gettingfillSubsTeacher')->name('admin.gettingfillSubsTeacher')->middleware('preventManualAccessTeacher');

Route::match(['get', 'post'], 'teacher/checkIftitlesexistSubjectTeacher', 'App\Http\Controllers\teacherSections@checkIftitlesexistSubjectTeacher')->name('teacher.checkIftitlesexistSubjectTeacher')->middleware('preventManualAccessTeacher');

Route::get('teacher/section_list', 'App\Http\Controllers\teacherSections@edit_section')->name('teacher.edit_section')->middleware('preventManualAccessTeacher');


Route::get('teacher/update_section/{id}', 'App\Http\Controllers\teacherSections@update_section')->name('teacher.update_section')->middleware('preventManualAccessTeacher');

Route::match(['get', 'post'], 'teacher/updating_section_student/{id}', 'App\Http\Controllers\teacherSections@updating_section_student')->name('teacher.updating_section_student')->middleware('preventManualAccessTeacher');


Route::get('teacher/delete_section/{id}/{password}', 'App\Http\Controllers\teacherSections@delete_section')->name('teacher.delete_section')->middleware('preventManualAccessTeacher');
Route::match(['get', 'post'], 'teacher/checkpassword', 'App\Http\Controllers\teacherSections@checkpassword')->name('teacher.checkpassword')->middleware('preventManualAccessTeacher');
Route::get('teacher/success_message/{icon}/{title}', 'App\Http\Controllers\teacherSections@success_message')->name('teacher.success_message')->middleware('preventManualAccessTeacher');


Route::match(['get', 'post'], 'teacher/upload_finals/{id}', 'App\Http\Controllers\teacherSections@upload_finals')->name('teacher.upload_finals')->middleware('preventManualAccessTeacher');

Route::match(['get', 'post'], 'teacher/uploading_finals/{id}', 'App\Http\Controllers\teacherSections@uploading_finals')->name('teacher.uploading_finals')->middleware('preventManualAccessTeacher');


Route::get('teacher/settings', 'App\Http\Controllers\teacherSections@settings')->name('teacher.settings')->middleware('preventManualAccessTeacher');

Route::match(['get', 'post'], 'teacher/checkIfTeacherExist', 'App\Http\Controllers\teacherSections@checkIfTeacherExist')->name('teacher.checkIfTeacherExist')->middleware('preventManualAccessTeacher');

Route::match(['get', 'post'], 'teacher/updating_teachers/{id}', 'App\Http\Controllers\teacherSections@updating_teachers')->name('teacher.updating_teachers')->middleware('preventManualAccessTeacher');

Route::get('teacher/student_list', 'App\Http\Controllers\teacherSections@studentList')->name('teacher.studentList')->middleware('preventManualAccessTeacher');

//ENDSECTIONTEACHER



//teacherSection

Route::get('admin/teachers_section/{academic}', 'App\Http\Controllers\AdminteacherSection@teacherSection')->name('admin.teacherSection')->middleware('preventManualAccess');

Route::get('admin/section_list', 'App\Http\Controllers\AdminteacherSection@teacherSection')->name('admin.edit_section')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/disableSections', 'App\Http\Controllers\AdminteacherSection@disableSections')->name('admin.disableSections')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/disablingSectionTeacher', 'App\Http\Controllers\AdminteacherSection@disablingSectionTeacher')->name('admin.disablingSectionTeacher')->middleware('preventManualAccess');



Route::match(['get', 'post'], 'admin/disable_multiple_TeacherSection', 'App\Http\Controllers\AdminteacherSection@disable_multiple_TeacherSection')->name('admin.disable_multiple_TeacherSection')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/student_list_subject/{id}', 'App\Http\Controllers\AdminteacherSection@upload_finals')->name('admin.upload_finals')->middleware('preventManualAccess');

// ENDteacherSection


//BETA
Route::match(['get', 'post'], 'admin/add_student_beta', 'App\Http\Controllers\TeacherUpload@add_student_beta')->name('admin.add_student_beta')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/adding_beta', 'App\Http\Controllers\TeacherUpload@adding_beta')->name('admin.adding_beta')->middleware('preventManualAccess');

Route::match(['get', 'post'], 'admin/section_student_beta', 'App\Http\Controllers\TeacherUpload@section_student_beta')->name('admin.section_student_beta')->middleware('preventManualAccess');
Route::match(['get', 'post'], 'admin/updating_section_student_beta', 'App\Http\Controllers\TeacherUpload@updating_section_student_beta')->name('admin.updating_section_student_beta')->middleware('preventManualAccess');

//




//WELCOME LETTER FOR TEACHER
Route::match(['get', 'post'], 'teacher/welcome', 'App\Http\Controllers\teacherSections@welcome')->name('teacher.welcome')->middleware('preventManualAccessTeacher');


//END WELCOME LETTER FOR TEACHER


//StudentSubject

Route::match(['get', 'post'], 'admin/StudentSubject', 'App\Http\Controllers\StudentSubject@StudentSubject')->name('admin.StudentSubject')->middleware('preventManualAccess');