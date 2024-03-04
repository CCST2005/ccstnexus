<?php

namespace App\Http\Controllers;
use App\Models\AdminStudent;
use App\Models\listStrand;

use App\Models\studentCourse;
use App\Models\studentStrand;
use DateTime;
use App\Models\student_credentials;
use App\Models\previousEducation;
use App\Models\listCourse;
use Carbon\Carbon;
use App\Models\credentialsOptionStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class AdminStudentController extends Controller

{


    private $sharedVariable;

    
    public function __construct()
    {
        $this->citizenships = [ 'Afghan', 'Albanian', 'Algerian', 'American', 'Andorran', 'Angolan', 'Antiguans', 'Argentinean', 'Armenian', 'Australian', 'Austrian', 'Azerbaijani', 'Bahamian', 'Bahraini', 'Bangladeshi', 'Barbadian', 'Barbudans', 'Batswana', 'Belarusian', 'Belgian', 'Belizean', 'Beninese', 'Bhutanese', 'Bolivian', 'Bosnian', 'Brazilian', 'British', 'Bruneian', 'Bulgarian', 'Burkinabe', 'Burmese', 'Burundian', 'Cambodian', 'Cameroonian', 'Canadian', 'Cape Verdean', 'Central African', 'Chadian', 'Chilean', 'Chinese', 'Colombian', 'Comoran', 'Congolese', 'Costa Rican', 'Croatian', 'Cuban', 'Cypriot', 'Czech', 'Danish', 'Djibouti', 'Dominican', 'Dutch', 'East Timorese', 'Ecuadorean', 'Egyptian', 'Emirian', 'Equatorial Guinean', 'Eritrean', 'Estonian', 'Ethiopian', 'Fijian', 'Filipino', 'Finnish', 'French', 'Gabonese', 'Gambian', 'Georgian', 'German', 'Ghanaian', 'Greek', 'Grenadian', 'Guatemalan', 'Guinea-Bissauan', 'Guinean', 'Guyanese', 'Haitian', 'Herzegovinian', 'Honduran', 'Hungarian', 'I-Kiribati', 'Icelander', 'Indian', 'Indonesian', 'Iranian', 'Iraqi', 'Irish', 'Israeli', 'Italian', 'Ivorian', 'Jamaican', 'Japanese', 'Jordanian', 'Kazakhstani', 'Kenyan', 'Kittian and Nevisian', 'Kuwaiti', 'Kyrgyz', 'Laotian', 'Latvian', 'Lebanese', 'Liberian', 'Libyan', 'Liechtensteiner', 'Lithuanian', 'Luxembourger', 'Macedonian', 'Malagasy', 'Malawian', 'Malaysian', 'Maldivan', 'Malian', 'Maltese', 'Marshallese', 'Mauritanian', 'Mauritian', 'Mexican', 'Micronesian', 'Moldovan', 'Monacan', 'Mongolian', 'Moroccan', 'Mosotho', 'Motswana', 'Mozambican', 'Namibian', 'Nauruan', 'Nepalese', 'New Zealander', 'Nicaraguan', 'Nigerian', 'Nigerien', 'North Korean', 'Northern Irish', 'Norwegian', 'Omani', 'Pakistani', 'Palauan', 'Panamanian', 'Papua New Guinean', 'Paraguayan', 'Peruvian', 'Polish', 'Portuguese', 'Qatari', 'Romanian', 'Russian', 'Rwandan', 'Saint Lucian', 'Salvadoran', 'Samoan', 'San Marinese', 'Sao Tomean', 'Saudi', 'Scottish', 'Senegalese', 'Serbian', 'Seychellois', 'Sierra Leonean', 'Singaporean', 'Slovakian', 'Slovenian', 'Solomon Islander', 'Somali', 'South African', 'South Korean', 'Spanish', 'Sri Lankan', 'Sudanese', 'Surinamer', 'Swazi', 'Swedish', 'Swiss', 'Syrian', 'Taiwanese', 'Tajik', 'Tanzanian', 'Thai', 'Togolese', 'Tongan', 'Trinidadian or Tobagonian', 'Tunisian', 'Turkish', 'Tuvaluan', 'Ugandan', 'Ukrainian', 'Uruguayan', 'Uzbekistani', 'Venezuelan', 'Vietnamese', 'Welsh', 'Yemenite', 'Zambian', 'Zimbabwean', ];
    }


    public function index(){
        if (!session()->has('user_logged')) {
            return view('admin.login_page_admin');
        }
        
        
        $all_student = AdminStudent::all();

       
        return view('admin.student_list', compact('all_student'));
    }

    public function add_student(){
       
        $currentYear = now()->year;
        $list_credentials = credentialsOptionStudent::all();
        $citizenships = $this->citizenships;
        $listStrand = listCourse::where('id_Dept', '7')->get();
        return view('admin.add_student', compact('list_credentials','citizenships', 'currentYear','listStrand'));
    }
    public function add_student_kiosk(){
       
        $currentYear = now()->year;
        $list_credentials = credentialsOptionStudent::all();
        $citizenships = $this->citizenships;
        $listStrand = listCourse::where('id_Dept', '7')->get();
        return view('kiosk.add_student', compact('list_credentials','citizenships', 'currentYear','listStrand'));
    }

    public function update_student (Request $request, $id)
    {
        $currentYear = now()->year;
        $list_credentials = credentialsOptionStudent::all();
        $citizenships = $this->citizenships;
        $listStrand = listCourse::where('id_Dept', '7')->get();
        
        $finding_user_acc = AdminStudent::where('id', $id)->first();

        $credentialsStuds = student_credentials::where('owner_id', $id)->get();
        $allcreds = array();
        foreach($credentialsStuds as $cred){
            $credents = credentialsOptionStudent::where('id', $cred->credentials_id)->first();

            array_push($allcreds, $credents->credentials);
        }
        $credentialsStuds = $allcreds;

        $level = $finding_user_acc->level;
        $birhtdate = new DateTime($finding_user_acc->birth_year . '-' . $finding_user_acc->birth_month . '-' . $finding_user_acc->birth_day);
        $formattedDate = $birhtdate->format("Y-m-d");

        if($level == '11' || $level == '12'){
            $course = studentStrand::where('ownerID', $id)->first();
            $course = $course->strand;
        }
        else{
            $course = studentCourse::where('ownerID', $id)->first();
            $course = $course->course;
        }

        $previous = previousEducation::where('id', $id)->first();
       
        
        return view('admin.update_student', compact('previous','credentialsStuds', 'course','level', 'finding_user_acc','list_credentials','citizenships', 'currentYear','listStrand', 'formattedDate'));
    }

    public function checkIfStudentExist (Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        
        $existingEmployee = AdminStudent::where('student_no', $request->input('datacheckEmployeeNo'))->first();

        $existingemail = AdminStudent::where('email', $request->input('datacheckgmail'))->first();

    

        if ($existingEmployee) {
            return response()->json(['employeeNo' => true, 'email' => false]);
        } 
        elseif ($existingemail){
            return response()->json([ 'employeeNo' => false, 'email' => true]);
        }
        else {
            return response()->json(['employeeNo' => false, 'email' => false]);
        }
    }

    public function adding_student(Request $request){


        $request->validate([
            'student_no' => 'required|string|between:5,20|unique:student_account,student_no|regex:/^[0-9-]+$/',
            'gmail' => 'required|string|between:5,30|email|unique:student_account,email',
            'age' => 'required|int|between:2,30',
            'first_name' => 'required|string|between:2,30',
            'middle_name' => 'nullable|string|between:2,30',
            'last_name' => 'required|string|between:2,30',
            'region-text' => 'required|string|between:2,30',
            'city-text' => 'required|string|between:2,30',
            'province-text' => 'required|string|between:2,30',
            'barangay-text' => 'required|string|between:2,30',
            'house' => 'required|string|between:2,30',
            'contact_student' => 'required|string|between:5,20',
            'mfirst_name' => 'required|string|between:2,30',
            'mmiddle_name' => 'nullable|string|between:2,30',
            'mlast_name' => 'required|string|between:2,30',
            'moccupation' => 'nullable|string|between:2,30',
            'ffirst_name' => 'required|string|between:2,30',
            'fmiddle_name' => 'nullable|string|between:2,30',
            'flast_name' => 'required|string|between:2,30',
            'foccupation' => 'nullable|string|between:2,30',
            'efirst_name' => 'required|string|between:2,30',
            'emiddle_name' => 'nullable|string|between:2,30',
            'elast_name' => 'required|string|between:2,30',
            'erelation' => 'required|string|between:2,30',
            'eaddress' => 'required|string|between:2,30',
            'bdayplace' => 'required|string|between:2,30',
            'citizenship' => 'required|string|between:2,30|regex:/^[A-Za-z\s]+$/',
            'sex' => 'required|string|between:2,30|regex:/^[A-Za-z\s]+$/',
            'sivil_status' => 'required|string|between:2,30|regex:/^[A-Za-z\s]+$/',

            'elem' => 'required|string|between:2,30',
            'highschool' => 'nullable|string|between:2,30',
            'college' => 'nullable|string|between:2,30',
            
            'elemyr' => 'required|between:2,30',
            
           
            


            'collegeyr' => [
                Rule::requiredIf(!empty(trim($request->input('college')))),
               
                
                

            ],

            'previousCourse' => [
                Rule::requiredIf(!empty(trim($request->input('college')))),
          
             

            ],

            'highschoolyr' => [
                Rule::requiredIf(!empty(trim($request->input('highschool')))),
              
               
                

            ]
        ]);

        


        // Trim the variables
        $age = trim($request->input('age'));
        $studentNo = trim($request->input('student_no'));
        $gmail = trim($request->input('gmail'));
        $password = trim($request->input('password'));
        $firstName = trim($request->input('first_name'));
        $middleName = trim($request->input('middle_name'));
        $lastName = trim($request->input('last_name'));
        $bdayplace = trim($request->input('bdayplace'));
        $bday = trim($request->input('bday'));
        $regionText = trim($request->input('region-text'));
        $cityText = trim($request->input('city-text'));
        $barangayText = trim($request->input('barangay-text'));
        $house = trim($request->input('house'));
        $contactStudent = trim($request->input('contact_student'));
        $mFirstName = trim($request->input('mfirst_name'));
        $mMiddleName = trim($request->input('mmiddle_name'));
        $mLastName = trim($request->input('mlast_name'));
        $mOccupation = trim($request->input('moccupation'));
        $fFirstName = trim($request->input('ffirst_name'));
        $fMiddleName = trim($request->input('fmiddle_name'));
        $fLastName = trim($request->input('flast_name'));
        $fOccupation = trim($request->input('foccupation'));
        $eFirstName = trim($request->input('efirst_name'));
        $eMiddleName = trim($request->input('emiddle_name'));
        $eLastName = trim($request->input('elast_name'));
        $eRelation = trim($request->input('erelation'));
        $eAddress = trim($request->input('eaddress'));
        $province = trim($request->input('province-text'));
        $sivil_status = trim($request->input('sivil_status'));
        $citizenship = trim($request->input('citizenship'));
        $sex = trim($request->input('sex'));
        $econtact = trim($request->input('econtact'));
        $level = trim($request->input('level'));
        $date = Carbon::parse($bday);
        
        $year = $date->year;
        $month = $date->month;
        $day = $date->day;


        if(trim($request->input('college')) == ""){

            $collegeyr = '';
            $previousCourse = '';
            $college = '';

        }
        else{
            $collegeyr = trim($request->input('collegeyr'));
            $previousCourse = trim($request->input('previousCourse'));
            $college = trim($request->input('college'));
        }

        if(trim($request->input('highschool')) == ""){

            $highschool = '';
            $highschoolyr = '';

        }
        else{
            $highschool = trim($request->input('highschool'));
            $highschoolyr = trim($request->input('highschoolyr'));
        }

        
        
    

        $randomNumber = random_int(1, 100);

        $numbers = preg_replace("/[^0-9]/", "", $request->input('student_no'));

        $uniID = $numbers . $randomNumber;

        $add_info_admin = new AdminStudent([
            'id' => $uniID,
            'username' => $studentNo,
            'password' => $bday,
            'verify_question' => '',
            'verify_answer' => '',

            'firstname' => $firstName,
            'middlename' => $middleName,
            'lastname' => $lastName,
            'student_no' => $studentNo,
            'image_file_name' => '',
            'darkmode' => 1,
            'disabled' => '0',
            'email' => $gmail,
            'region' => $regionText,
            'city' => $cityText,
            'province' => $province,
            'barangay' => $barangayText,
            'block_lot' => $house,
            'birth_month' => $month,
            'birth_year' => $year,
            'birth_day' => $day,
            'sex' => $sex,
            'sivil_status' => $sivil_status,
            'citizenship' => $citizenship,
            'age' => $age,
            'birthplace' => $bdayplace,
            'ContactNo' => $contactStudent,
            'father_fname' => $fFirstName,
            'father_mname' => $fMiddleName,
            'father_lname' => $fLastName,
            'mother_fname' => $mFirstName,
            'mother_mname' => $mMiddleName,
            'mother_lname' => $mLastName,
            'm_occupation' => $mOccupation,
            'f_occupation' => $fOccupation,
            'emergency_fname' => $eFirstName,
            'emergency_mname' => $eMiddleName,
            'emergency_lname' => $eLastName,
            'emergency_relation' => $eRelation,
            'emergency_contact' => $econtact,
            'emergency_address' => $eAddress,
            'level' => $level

        ]);
        $add_info_admin->save();

        

        $elem = trim($request->input('elem'));
       
        

        $elemyr = trim($request->input('elemyr'));

        $add_info_admin = new previousEducation([
            'id' => $uniID,
            'elementary' => $elem,
    
            'highschool' => $highschool,
            'college' => $college,

            'elementaryYr' => $elemyr,
            'highschoolYr' => $highschoolyr,
            'collegeYr' => $collegeyr,
            'collegeCourse' => $previousCourse,
 
        ]);

        $add_info_admin->save();





        $credentials = $request->input('credentials');
        if (empty($credentials)){
            return back();
        }


        if (!empty($credentials)) {
            foreach ($credentials as $value) {

                $add_info_admin = new student_credentials([

                    'owner_id' => $uniID,
                    'credentials_id' => $value,
                    
                ]);
        
                $add_info_admin->save();
                
            }
        }

        $strand = trim($request->input('strand'));
        
            $add_info_admins = new studentCourse([

                'ownerID' => $uniID,
                'course' => $strand,
                
            ]);
            $add_info_admins->save();
           
        
        


       

        $success = [

            'icon' => 'success',
            'title' => 'Added successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);





    }

    public function updating_student (Request $request, $id)
    {
     
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        $record_admin = AdminStudent::where('id', $id)->first();
        
        if($record_admin->email != trim($request->input('gmail'))) {
            $validates = 'required|string|between:5,30|email|unique:student_account,email';
        }
        else{
            $validates = "nullable";
        }

        if($record_admin->student_no != trim($request->input('student_no'))) {
            $validating = 'required|string|between:5,20|unique:student_account,student_no|regex:/^[0-9-]+$/';
        }
        else{
            $validating = "nullable";
        }




        $request->validate([
            'student_no' => $validating,
            'gmail' => $validates,

        
            'age' => 'required|int|between:2,30',
            'first_name' => 'required|string|between:2,30',
            'middle_name' => 'nullable|string|between:2,30',
            'last_name' => 'required|string|between:2,30',
            'region-text' => 'required|string|between:2,30',
            'city-text' => 'required|string|between:2,30',
            'province-text' => 'required|string|between:2,30',
            'barangay-text' => 'required|string|between:2,30',
            'house' => 'required|string|between:2,30',
            'contact_student' => 'required|string|between:5,20',
            'mfirst_name' => 'required|string|between:2,30',
            'mmiddle_name' => 'nullable|string|between:2,30',
            'mlast_name' => 'required|string|between:2,30',
            'moccupation' => 'nullable|string|between:2,30',
            'ffirst_name' => 'required|string|between:2,30',
            'fmiddle_name' => 'nullable|string|between:2,30',
            'flast_name' => 'required|string|between:2,30',
            'foccupation' => 'nullable|string|between:2,30',
            'efirst_name' => 'required|string|between:2,30',
            'emiddle_name' => 'nullable|string|between:2,30',
            'elast_name' => 'required|string|between:2,30',
            'erelation' => 'required|string|between:2,30',
            'eaddress' => 'required|string|between:2,30',
            'bdayplace' => 'required|string|between:2,30',
            'citizenship' => 'required|string|between:2,30|regex:/^[A-Za-z\s]+$/',
            'sex' => 'required|string|between:2,30|regex:/^[A-Za-z\s]+$/',
            'sivil_status' => 'required|string|between:2,30|regex:/^[A-Za-z\s]+$/',

            'elem' => 'required|string|between:2,30',
            'highschool' => 'nullable|string|between:2,30',
            'college' => 'nullable|string|between:2,30',
            
            'elemyr' => 'required|between:2,30',
            
           
            


            'collegeyr' => [
                Rule::requiredIf(!empty(trim($request->input('college')))),
               
                
                

            ],

            'previousCourse' => [
                Rule::requiredIf(!empty(trim($request->input('college')))),
          
             

            ],

            'highschoolyr' => [
                Rule::requiredIf(!empty(trim($request->input('highschool')))),
              
               
                

            ]
        ]);

        


        // Trim the variables
        $age = trim($request->input('age'));
        $studentNo = trim($request->input('student_no'));
        $gmail = trim($request->input('gmail'));
        
        $firstName = trim($request->input('first_name'));
        $middleName = trim($request->input('middle_name'));
        $lastName = trim($request->input('last_name'));
        $bdayplace = trim($request->input('bdayplace'));
        $bday = trim($request->input('bday'));
        $regionText = trim($request->input('region-text'));
        $cityText = trim($request->input('city-text'));
        $barangayText = trim($request->input('barangay-text'));
        $house = trim($request->input('house'));
        $contactStudent = trim($request->input('contact_student'));
        $mFirstName = trim($request->input('mfirst_name'));
        $mMiddleName = trim($request->input('mmiddle_name'));
        $mLastName = trim($request->input('mlast_name'));
        $mOccupation = trim($request->input('moccupation'));
        $fFirstName = trim($request->input('ffirst_name'));
        $fMiddleName = trim($request->input('fmiddle_name'));
        $fLastName = trim($request->input('flast_name'));
        $fOccupation = trim($request->input('foccupation'));
        $eFirstName = trim($request->input('efirst_name'));
        $eMiddleName = trim($request->input('emiddle_name'));
        $eLastName = trim($request->input('elast_name'));
        $eRelation = trim($request->input('erelation'));
        $eAddress = trim($request->input('eaddress'));
        $province = trim($request->input('province-text'));
        $sivil_status = trim($request->input('sivil_status'));
        $citizenship = trim($request->input('citizenship'));
        $sex = trim($request->input('sex'));
        $econtact = trim($request->input('econtact'));
        $level = trim($request->input('level'));
        $date = Carbon::parse($bday);
        
        $year = $date->year;
        $month = $date->month;
        $day = $date->day;


        if(trim($request->input('college')) == ""){

            $collegeyr = '';
            $previousCourse = '';
            $college = '';

        }
        else{
            $collegeyr = trim($request->input('collegeyr'));
            $previousCourse = trim($request->input('previousCourse'));
            $college = trim($request->input('college'));
        }

        if(trim($request->input('highschool')) == ""){

            $highschool = '';
            $highschoolyr = '';

        }
        else{
            $highschool = trim($request->input('highschool'));
            $highschoolyr = trim($request->input('highschoolyr'));
        }

        
        
    

        $randomNumber = random_int(1, 100);

        $numbers = preg_replace("/[^0-9]/", "", $request->input('student_no'));




        $record_admin = AdminStudent::where('id', $id)->first();


        $record_admin->username = $studentNo;

   

        $record_admin->firstname = $firstName;
        $record_admin->middlename = $middleName;
        $record_admin->lastname = $lastName;
        $record_admin->student_no = $studentNo;
    
        
        $record_admin->email = $gmail;
        $record_admin->region = $regionText;
        $record_admin->city = $cityText;
        $record_admin->province = $province;
        $record_admin->barangay = $barangayText;
        $record_admin->block_lot = $house;
        $record_admin->birth_month = $month;
        $record_admin->birth_year = $year;
        $record_admin->birth_day = $day;
        $record_admin->sex = $sex;
        $record_admin->sivil_status = $sivil_status;
        $record_admin->citizenship = $citizenship;
        $record_admin->age = $age;
        $record_admin->birthplace = $bdayplace;
        $record_admin->ContactNo = $contactStudent;
        $record_admin->father_fname = $fFirstName;
        $record_admin->father_mname = $fMiddleName;
        $record_admin->father_lname = $fLastName;
        $record_admin->mother_fname = $mFirstName;
        $record_admin->mother_mname = $mMiddleName;
        $record_admin->mother_lname = $mLastName;
        $record_admin->m_occupation = $mOccupation;
        $record_admin->f_occupation = $fOccupation;
        $record_admin->emergency_fname = $eFirstName;
        $record_admin->emergency_mname = $eMiddleName;
        $record_admin->emergency_lname = $eLastName;
        $record_admin->emergency_relation = $eRelation;
        $record_admin->emergency_contact = $econtact;
        $record_admin->emergency_address = $eAddress;
        $record_admin->level = $level;

        $record_admin->save();

        

        $elem = trim($request->input('elem'));
       
        

        $elemyr = trim($request->input('elemyr'));



        $record_admin = previousEducation::where('id', $id)->first();

      

        $record_admin->elementary = $elem;
    
        $record_admin->highschool = $highschool;
        $record_admin->college = $college;

        $record_admin->elementaryYr = $elemyr;
        $record_admin->highschoolYr = $highschoolyr;
        $record_admin->collegeYr = $collegeyr;
        $record_admin->collegeCourse = $previousCourse;
 
     

        $record_admin->save();





        $credentials = $request->input('credentials');
        if (empty($credentials)){
            return back();
        }

        

        if (!empty($credentials)) {
            student_credentials::where('owner_id', $id)->delete();

            foreach ($credentials as $value) {

                $add_info_admin = new student_credentials([

                    'owner_id' => $id,
                    'credentials_id' => $value,
                    
                ]);
        
                $add_info_admin->save();
                
            }
        }

        $strand = trim($request->input('strand'));
        if ($level == 'College') {
            studentCourse::where('ownerID', $id)->delete();
            $add_info_admins = new studentCourse([

                'ownerID' => $id,
                'course' => $strand,
                
            ]);
            $add_info_admins->save();
           
        }
        else{
            studentStrand::where('ownerID', $id)->delete();
            $add_info_admins = new studentStrand([

                'ownerID' => $id,
                'strand' => $strand,
                
            ]);
            $add_info_admins->save();

        }


       

        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);






    }

    public function gettingStrand(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }

        $strands = '';
        $items = array();
        $ids = array();
        if($request->input('gradeLeve') == '11' || $request->input('gradeLeve') == '12' ){

     
           
            $strands = listCourse::where('id_Dept', '7')->get();
            foreach($strands as $iteming){
                
                array_push($items, $iteming->course);
                array_push($ids, $iteming->id);
            }
        }
        else if($request->input('gradeLeve') == 'College'){
            
            $strands = listCourse::where('id_Dept', '6')->get();
            foreach($strands as $iteming){
                
                array_push($items, $iteming->course);
                array_push($ids, $iteming->id);
            }
        }
        
        


    
            
        return response()->json(['strands' => $items, 'ids' => $ids]);
       
    }



    public function delete_multiple_student(Request $request){
        
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
    
            
    
                $finding_user_acc = AdminStudent::where('id', $checkboxValue)->first();
                $finding_user_acc->delete();


                previousEducation::where('id', $checkboxValue)->delete();

                studentStrand::where('ownerID', $checkboxValue)->delete();

                studentCourse::where('ownerID', $checkboxValue)->delete();

                student_credentials::where('owner_id', $checkboxValue)->delete();
    
                $counts++;
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }


    public function delete_student(Request $request, $id, $password)
    {

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finding_user_acc = AdminStudent::where('id', $id)->first();

            $name = $finding_user_acc->firstname . " " . $finding_user_acc->lastname;

            $finding_user_acc->delete();

            
            previousEducation::where('id', $id)->delete();

            studentStrand::where('ownerID', $id)->delete();

            studentCourse::where('ownerID', $id)->delete();

            student_credentials::where('owner_id', $id)->delete();
           
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
            
    
             return redirect()->route('admin.registrar')->with('delete_success', $success);
           

        }
       

        
    }


    public function disabling_student(Request $request, $id)
    {

        $record_admin = AdminStudent::where('id', $id)->first();

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



    public function disable_multiple_student(Request $request){
        
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

                $record_admin = AdminStudent::where('id', $checkboxValue)->first();
                if($record_admin->disabled == '0'){
                    $record_admin->disabled = '1';
                    $counts++;
                    $record_admin->save();
                }
              
    
                
            }
    
            
    
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }

}
