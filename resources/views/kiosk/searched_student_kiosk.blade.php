@extends('kiosk.index_admin')



@section('titlePage')

    CCSTNexus | add student

@endsection

@section('content')
<style>
    .showingsj h3{
        opacity: 80%;
    }
    .showingsj h4{
        color: #dc3545;
    }
    .showingsj h5{
        width: 100%;
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #ffffff42;
        padding-bottom: 4px;
    }
</style>
<a href="{{ route('kiosk.index') }}" style="z-index:99999999999999999999999999999;position: fixed;top:40px;left:40px;color:white;font-size:40px"><i class="fas fa-reply"></i></a>

<div class="content-wrapper" style="height: 100dvh !important;margin:0px !important;padding:0px !important;">
    <!-- Content Header (Page header) -->
  
    <!-- /.content-header -->

    <!-- Main content -->
    
    <section class="content" >
      <div class="container-fluid" style="padding: 0px; margin:0px">
        <div class="row">
          
          <div class="col-12" style="padding: 0px; margin:0px">
            
            <!-- /.card -->

            <div class="card" style="box-shadow: none !important;">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="padding: 0px;height: 100dvh !important">
              @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
             
             
<!-- <button onclick="filling()">Fill all</button> -->
              <form id="myForm" method="POST" action="{{ route('kiosk.updating_student', ['id' => $finding_user_acc->id]) }}">

              <br>
<br>

              <div class="card-body">
                <h1 style="margin:0px;padding:0px;text-shadow: 3px 3px 7px rgba(0, 0, 0, .5);"><b>CCST REGISTRATION KIOSK (STEP 3)</b></h1>
                <h4 style="text-shadow: 3px 3px 7px rgba(0, 0, 0, .5);">Edit {{ (empty($finding_user_acc->firstname)) ? 'N/A' : $finding_user_acc->firstname }}'s information</h4>
                <br><br>
                @csrf
                    <div class="row" >
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="employee_no">Student no.<sup class="sup">*</sup></label>
                                <input readonly type="text" onkeyup="validateInput(this)" class="form-control" value="{{ $finding_user_acc->student_no }}" id="student_no" name="student_no" placeholder="Employee no.">
                            </div>
                        </div>
                        <script>
                            function validateInput(input) {
                                input.value = input.value.replace(/[^0-9-]/g, '');
                                
                            }
                        </script>
                        
       
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="gmail">Email<sup class="sup">*</sup></label>
                                <input type="email" class="form-control" value="{{ $finding_user_acc->email }}" id="gmail" name="gmail"  placeholder="Email">
                            </div>
                        </div>

                        <div class="col-sm-4" style="display:none">
                            <div class="form-group">
                                <label for="gmail">Password<sup class="sup">*</sup></label>
                                <input type="email" class="form-control" value="{{ $finding_user_acc->password }}" id="s" name="password"  placeholder="Email">
                            </div>
                        </div>

                        
                    
                        <div class="col-sm-4"  style="display:none">
                            <div class="form-group">
                                <label for="email">Username<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="username" value="{{ $finding_user_acc->username }}" readonly name="username"  placeholder="username">
                            </div>
                        </div>
                        <div class="col-sm-4" style="display:none">
                            <div class="form-group">
                                <label for="password">Password<sup class="sup">*</sup></label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-sm-4" style="display:none">
                            <div class="form-group">
                                <label for="confirm_password">Confirm password<sup class="sup">*</sup></label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password">
                            </div>
                        </div>
                    </div>


                </div>
                              
                <div class="card-header" >
                    <h2 class="card-title font-weight-bold" style="color: #3c8dbc !important"><span id="names">Student</span>'s  information</h2>
                </div>
                <div class="card-body">
                
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="first_name">First name<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" readonly value="{{ $finding_user_acc->firstname }}" id="first_name" onkeyup="changeNameselect()" name="first_name" placeholder="First name">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="middle_name">Middle name</label>
                                <input type="text" class="form-control" id="middle_name"  placeholder="{{ (empty($finding_user_acc->middlename)) ? 'N/A' : $finding_user_acc->middlename }}" value="{{ $finding_user_acc->middlename }}" name="middle_name" placeholder="Middle name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Last name<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" readonly value="{{ $finding_user_acc->lastname }}" id="last_name" name="last_name" placeholder="Last name">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Birthday<sup class="sup">*</sup></label>
                                <input type="date" onchange="passwordFill(this)"   value="{{ $formattedDate }}" class="form-control" id="bday" name="bday" placeholder="Birthplace">
                            </div>
                        </div>

                       

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Birthplace<sup class="sup">*</sup></label>
                                @if($finding_user_acc->birthplace == 'EmptyN/A')
                                    @php
                                        $finding_user_acc->birthplace = "";
                                    @endphp
                                @endif
                                <input type="text" class="form-control" value="{{ $finding_user_acc->birthplace }}" id="bdayplace" name="bdayplace" placeholder="Birthplace">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Age<sup class="sup">*</sup></label>

                                <select class="custom-select" disabled id="age" name="age">
                              
                                      <option  value="">Select birthday first</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Grade level<sup class="sup">*</sup></label>
                                
                                <select class="custom-select" onchange="levels(this)"  id="level" name="level">
                              
                                 
                                    <option  {{($level == 'College') ? 'selected' : '' }}  value="College"> College</option>

                                </select>
                               
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name" > <span id="strandName">Course</span> <sup class="sup">*</sup></label>
                                <input type="text" readonly value="{{ $studentRealCOurse }}" class="form-control" id="strand" name="strand">

                            </div>
                        </div>



                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="citizenship">Citizenship<sup class="sup">*</sup></label>
                                
                                <select class="custom-select" id="citizenship" name="citizenship">
                                    
                                    @foreach ($citizenships as $citizenship)
                                    @if(strtolower($citizenship) == 'filipino')
                                        @php
                                            $select = "selected";
                                        
                                           
                                        @endphp
                                    @else
                                        @php
                                            $select = "";
                                        
                                           
                                        @endphp
                                        @endif
                                        <option {{$select}} value="{{ $citizenship }}">{{ $citizenship }}</option>
                                    @endforeach                                         
                                </select>

                                <!-- <script>
                                    
                                    var citizenship = document.getElementById("citizenship");
                                    citizenship.value = "{{$finding_user_acc->citizenship}}";
                               
                                </script> -->
                            </div>
                        </div>
                            

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="citizenship">Gender<sup class="sup">*</sup></label>
                                <select class="custom-select" id="sexs" name="sex">
                                    @php 
                                        $sex = $finding_user_acc->sex;
                                    @endphp
                                    <option  {{($sex == 'Male') ? 'selected' : '' }}  value="Male">Male</option>
                                    <option {{($sex == 'Female') ? 'selected' : '' }} value="Female">Female</option>    

                                </select>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="citizenship">Civil status<sup class="sup">*</sup></label>
                                <select class="custom-select" id="sivil_statuss" name="sivil_status">
                                    @php 
                                        $status = $finding_user_acc->sivil_status;
                                    @endphp
                                    <option {{($status == 'Single') ? 'selected' : '' }} value="Single">Single</option>
                                    <option {{($status == 'Married') ? 'selected' : '' }} value="Married">Married</option>    

                                </select>
                            </div>
                        </div>



                        
                        <script>
                            var dateToday = {{ $currentYear }}-15;
                          
                            function passwordFill(value){

                                datebirth(value.value);
                               

                            }
                            
                          
                            function datebirth(value){
                                const ages = document.getElementById("age");
                                
                               
                                const bday = document.getElementById("bday");
                                var dob = new Date(value);
                                bday.style.borderColor = "#6c757d";
                                var year = dob.getFullYear();
                                if(year > dateToday){
                                    bday.style.borderColor = "rgb(165, 73, 73)";
                           
                                    
                                   return false;
                                }
                                while (ages.options.length > 0) {
                                    ages.remove(0);
                                    }
                                ages.remove(0);
                                const password = document.getElementById("password");
                                const cpassword = document.getElementById("confirm_password");
                                

                     
                                

                                ages.disabled = false;
                                password.value = value;

                                cpassword.value = value;


                                 dob = new Date(value);

                                
                                 currentDate = new Date();

                                
                        
                                

                                
                                var age = currentDate.getFullYear() - dob.getFullYear();

                               
                                if (currentDate.getMonth() < dob.getMonth() || (currentDate.getMonth() === dob.getMonth() && currentDate.getDate() < dob.getDate())) {
                                    age--;
                                }

                               

                                ages.value = age;

                                var ageMinus = age-1;
                                var ageAdd = age+1;

                                var currentAge = '{{$finding_user_acc->age}}';

                                var option = document.createElement('option');
                                option.value = ageMinus;
                                if(currentAge == ageMinus){
                                    option.selected = true;
                                }
                                option.text = ageMinus;
                                ages.add(option);

                                option = document.createElement('option');
                                option.value = age;
                                if(currentAge == age){
                                    option.selected = true;
                                }
                                else{
                                    option.selected = true;
                                }
                                option.text = age;
                                ages.add(option);
                      

                                option = document.createElement('option');
                                option.value = ageAdd;
                                if(currentAge == ageAdd){
                                    option.selected = true;
                                }
                                option.text = ageAdd;
                                ages.add(option);
                               

                            }
                            datebirth('{{ $formattedDate }}');
                        </script>
                        
                        
                       
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Region<sup class="sup">*</sup></label>
                                @if($finding_user_acc->region == 'EmptyN/A')
                                    @php
                                        $finding_user_acc->region = "";
                                    @endphp
                                @endif
                                <input type="text" disabled value="{{ $finding_user_acc->region }}" class="form-control" id="regionHide">

                                <select style="display:none" name="region" class="form-control tags_input" id="region"></select>
                                <input type="hidden" class="" value="{{ $finding_user_acc->region }}" name="region-text" id="region-text" required>
                                <span onclick="resets()"
                                @if($finding_user_acc->region == null)
                                  
                                   style="display: none"
                                @endif
                                
                                id="reseting" class="resets">Reset address</span>
                        
                                @if($finding_user_acc->region == null)
                                  
                                    <script>document.addEventListener("DOMContentLoaded", function () {
                                        // Your code to be executed when the DOM is ready
                                        resets();
                                    });</script>
                                @endif


                                
                            </div>
                            <script>
                                var trueSwitch = false;
                                var houses = "{{ $finding_user_acc->block_lot }}";
                                var provinces = "{{ $finding_user_acc->province }}";
                                var regions = "{{ $finding_user_acc->region }}";
                                var barangays = "{{ $finding_user_acc->barangay }}";
                                var citys = "{{ $finding_user_acc->city }}";
                                function resets(){

                                   var regionHide = document.getElementById("regionHide");
                                   var provinceHide = document.getElementById("provinceHide");
                                   var barangayHide = document.getElementById("barangayHide");
                                   var house = document.getElementById("house");
                                   var cityHide = document.getElementById("cityHide");
                                   var reseting = document.getElementById("reseting");


                                   var region = document.getElementById("region");
                                   var province = document.getElementById("province");
                                   var barangay = document.getElementById("barangay");
                            
                                   var city = document.getElementById("city");


                                   if(!trueSwitch){
                                    regionHide.style.display = "none";
                                   provinceHide.style.display = "none";
                                   barangayHide.style.display = "none";
                                   cityHide.style.display = "none";
                                   house.value = "";
                                   house.readOnly = false;
                                   region.style.display = "block";
                                   province.style.display = "block";
                                   barangay.style.display = "block";
                                   city.style.display = "block";
                                   trueSwitch = true;
                                   reseting.innerHTML = "Back to default";
                                   }
                                   else{


                                    regionHide.value = regions;
                                    provinceHide.value = provinces;
                                    barangayHide.value = barangays;
                                    cityHide.value = citys;


                                    regionHide.style.display = "block";
                                    provinceHide.style.display = "block";
                                    barangayHide.style.display = "block";
                                    cityHide.style.display = "block";
                                    trueSwitch = false;
                                    house.readOnly = true;
                                    region.style.display = "none";
                                    province.style.display = "none";
                                    barangay.style.display = "none";
                                    city.style.display = "none";
                                    house.value = houses;
                                    reseting.innerHTML = "Reset address";
                                   }

                                }
                            </script>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Province<sup class="sup">*</sup></label>
                                <input type="text" disabled value="{{ $finding_user_acc->province }}" class="form-control" id="provinceHide">

                                <select style="display:none" name="province" class="form-control tags_input" id="province"><option value="">Select region first</option></select>
                                <input type="hidden" class="" value="{{ $finding_user_acc->province }}" name="province-text" id="province-text" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">City<sup class="sup">*</sup></label>
                                <input type="text" disabled value="{{ $finding_user_acc->city }}" class="form-control" id="cityHide">

                                <select style="display:none" name="city" class="form-control tags_input" id="city"><option value="">Select province first</option></select>
                                <input type="hidden" class="" name="city-text" value="{{ $finding_user_acc->city }}" id="city-text" required>
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Barangay<sup class="sup">*</sup></label>
                                <input type="text"disabled value="{{ $finding_user_acc->barangay }}" class="form-control" id="barangayHide">

                                <select style="display:none" name="barangay" class="form-control tags_input" id="barangay"><option value="">Select city first</option></select>
                                <input type="hidden" class="" name="barangay-text" id="barangay-text" value="{{ $finding_user_acc->barangay }}" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                
                                <label disabled for="last_name">House number/Street<sup class="sup">*</sup></label>
                                <input type="text" value="{{ $finding_user_acc->block_lot }}" readonly class="form-control" id="house" name="house" placeholder="House number/Street">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Contact No.<sup class="sup">*</sup></label>
                                <input type="number" class="form-control" value="{{ $finding_user_acc->ContactNo }}"  id="contact_student" name="contact_student" placeholder="Contact No.">
                            </div>
                        </div>
                        
                    </div>
                    
        

                   
                </div>
                
                <div class="card-header"style="font-size:16px; border:none; padding-bottom:0px">
                    <h3 class="card-title font-weight-bold" style="color: #3c8dbc !important">Mother's information</h3>
                </div>
                
                <div class="card-body">
                
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="first_name">First name<sup class="sup">*</sup></label>
                                @if($finding_user_acc->mother_fname == 'EmptyN/A')
                                    @php
                                        $finding_user_acc->mother_fname = "";
                                    @endphp
                                @endif
                                <input type="text"  value="{{ $finding_user_acc->mother_fname }}" class="form-control" id="mfirst_name" name="mfirst_name" placeholder="Mother's first name">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="middle_name">Middle name</label>
                                <input type="text" class="form-control" placeholder="{{ (empty($finding_user_acc->mother_mname)) ? 'N/A' : $finding_user_acc->mother_mname }}" value="{{ $finding_user_acc->mother_mname }}" id="mmiddle_name" name="mmiddle_name" placeholder="Mother's middle name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Last name<sup class="sup">*</sup></label>
                                @if($finding_user_acc->mother_lname == 'EmptyN/A')
                                    @php
                                        $finding_user_acc->mother_lname = "";
                                    @endphp
                                @endif
                                <input type="text" class="form-control" id="mlast_name" value="{{ $finding_user_acc->mother_lname }}" name="mlast_name" placeholder="Mother's last name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Occupation<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="moccupation" value="{{ $finding_user_acc->m_occupation }}" name="moccupation" placeholder="Mother's occupation">
                            </div>
                        </div>
                    
                        
                    </div>
                </div>
                     
                <div class="card-header"style="font-size:16px; border:none; padding-bottom:0px">
                    <h3 class="card-title font-weight-bold" style="color: #3c8dbc !important">Father's information</h3>
                </div>
                
                <div class="card-body">
                
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="first_name">First name<sup class="sup">*</sup></label>
                                @if($finding_user_acc->father_fname == 'EmptyN/A')
                                    @php
                                        $finding_user_acc->father_fname = "";
                                    @endphp
                                @endif
                                <input type="text" class="form-control"  value="{{ $finding_user_acc->father_fname }}" id="ffirst_name" name="ffirst_name" placeholder="Father's first name">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="middle_name">Middle name</label>
                                <input type="text" class="form-control" id="fmiddle_name"  placeholder="{{ (empty($finding_user_acc->father_mname)) ? 'N/A' : $finding_user_acc->father_mname }}" value="{{ $finding_user_acc->father_mname }}"name="fmiddle_name" placeholder="Father's middle name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Last name<sup class="sup">*</sup></label>
                                @if($finding_user_acc->father_lname == 'EmptyN/A')
                                    @php
                                        $finding_user_acc->father_lname = "";
                                    @endphp
                                @endif
                                <input type="text" class="form-control" id="flast_name" value="{{ $finding_user_acc->father_lname }}" name="flast_name" placeholder="Father's last name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Occupation<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="foccupation" value="{{ $finding_user_acc->f_occupation }}" name="foccupation" placeholder="Father's occupation">
                            </div>
                        </div>
                    
                        
                    </div>
                </div>

                <div class="card-header"style="font-size:16px; border:none; padding-bottom:0px">
                    <h3 class="card-title font-weight-bold" style="color: #3c8dbc !important">Incase of emergency</h3>
                </div>
                <div class="card-header"style="font-size:16px; border:none; padding-bottom:0px">
                <input type="radio" name="sameAs" id="SamAsO" value="o" onclick="pickingS('o')" checked> <label for="SamAsO">Others</label>
                <input style="margin-left: 10px" type="radio" name="sameAs" id="SamAsM" value="m" onclick="pickingS('m')"> <label for="SamAsM">My mother</label><input name="sameAs" value="f" onclick="pickingS('f')" style="margin-left: 10px" type="radio" name="" id="SamAsF"> <label for="SamAsF">My father</label>
                </div>
                <script>
                    function pickingS(vals){
                       
                        var mfirst_name = document.getElementById('mfirst_name');
                        var mmiddle_name = document.getElementById('mmiddle_name');
                        var mlast_name = document.getElementById('mlast_name');
                        var moccupation = document.getElementById('moccupation');

                        var optionNone = document.getElementById('optionNone');
                        var optionFather = document.getElementById('optionFather');
                        var optionMother = document.getElementById('optionMother');

                        var ffirst_name = document.getElementById('ffirst_name');
                        var fmiddle_name = document.getElementById('fmiddle_name');
                        var flast_name = document.getElementById('flast_name');
                        var foccupation = document.getElementById('foccupation');

                        var efirst_name = document.getElementById('efirst_name');
                        var emiddle_name = document.getElementById('emiddle_name');
                        var elast_name = document.getElementById('elast_name');
                        var erelation = document.getElementById('erelation');

                        var SamAsO = document.getElementById('SamAsO');
                     
                        if(vals == 'm' && mfirst_name.value != "" && mlast_name.value != ""){
                            efirst_name.value = mfirst_name.value;
                            emiddle_name.value = mmiddle_name.value;
                            elast_name.value = mlast_name.value;
                            erelation.value = 'Mother';
                            optionMother.selected = true;
                            efirst_name.readOnly  = true;
                            emiddle_name.readOnly  = true;
                            elast_name.readOnly  = true;
                
                            efirst_name.style = "opacity: 50%";
                            emiddle_name.style = "opacity: 50%";
                            elast_name.style = "opacity: 50%";
                            erelation.style = "opacity: 50%";

                        }
                        else if(vals == 'f' && ffirst_name.value != "" && flast_name.value != ""){
                  
                            efirst_name.value = ffirst_name.value;
                            emiddle_name.value = fmiddle_name.value;
                            elast_name.value = flast_name.value;
                            erelation.value = 'Father';
                            optionFather.selected = true;
                            efirst_name.readOnly  = true;
                            emiddle_name.readOnly  = true;
                            elast_name.readOnly  = true;
                         
                            efirst_name.style = "opacity: 50%";
                            emiddle_name.style = "opacity: 50%";
                            elast_name.style = "opacity: 50%";
                            erelation.style = "opacity: 50%";
                        }
                        else if(vals == 'o'){
                            efirst_name.value = '';
                            emiddle_name.value = '';
                            elast_name.value = '';
                            erelation.value = '';
                            optionNone.selected = true;
                            efirst_name.readOnly  = false;
                            emiddle_name.readOnly  = false;
                            elast_name.readOnly  = false;
                     
                            efirst_name.style = "";
                            emiddle_name.style = "";
                            elast_name.style = "";
                            erelation.style = "";


                            
                        }
                    }
                </script>
                <div class="card-body">
                
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="first_name">First name<sup class="sup">*</sup></label>
                                @if($finding_user_acc->emergency_fname == 'EmptyN/A')
                                    @php
                                        $finding_user_acc->emergency_fname = "";
                                    @endphp
                                @endif
                                <input type="text" value="{{ $finding_user_acc->emergency_fname }}" class="form-control" id="efirst_name" name="efirst_name" placeholder="Guardian's first name">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="middle_name">Middle name</label>
                                <input type="text" class="form-control"  placeholder="{{ (empty($finding_user_acc->emergency_mname)) ? 'N/A' : $finding_user_acc->emergency_mname }}" value="{{ $finding_user_acc->emergency_mname }}" id="emiddle_name" name="emiddle_name" placeholder="Guardian's middle name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                            @if($finding_user_acc->emergency_lname == 'EmptyN/A')
                                    @php
                                        $finding_user_acc->emergency_lname = "";
                                    @endphp
                                @endif
                                <label for="last_name">Last name<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="elast_name"  value="{{ $finding_user_acc->emergency_lname }}"  name="elast_name" placeholder="Guardian's last name">
                            </div>
                        </div>
                        @if($finding_user_acc->emergency_relation == 'EmptyN/A')
                                    @php
                                        $finding_user_acc->emergency_relation = "";
                                    @endphp
                                @endif
                        <!-- <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Relation<sup class="sup">*</sup></label>
                                
                                <input type="text" class="form-control"  value="{{ $finding_user_acc->emergency_relation }}" id="erelation" name="erelation" placeholder="Relation">
                            </div>
                        </div> -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                    // Get the select element
                                    const selectElement = document.getElementById("erelation");
                              
                                    // Select the option with value "son"
                                    const optionValueToSelect = '{{$finding_user_acc->emergency_relation}}';
                                    for (let i = 0; i < selectElement.options.length; i++) {
                                        if (selectElement.options[i].value.toLowerCase() === optionValueToSelect.toLowerCase()) {
                                            selectElement.selectedIndex = i;
                                            break;
                                        }
                                    }
                                });
                                </script>

                                <label for="last_name">Relation<sup class="sup">*</sup></label>
                                <select name="erelation"  class="form-control tags_input" id="erelation">
                                    <option id="optionNone" selected value="">Choose relation</option>
                                    <option id="optionFather" value="father">Father</option>
                                    <option id="optionMother" value="mother">Mother</option>
                                    <option value="son">Son</option>
                                    <option value="daughter">Daughter</option>
                                    <option value="grandfather">Grandfather</option>
                                    <option value="grandmother">Grandmother</option>
                                    <option value="uncle">Uncle</option>
                                    <option value="aunt">Aunt</option>
                                    <option value="cousin">Cousin</option>
                                    <option value="Wife">Wife</option>
                                    <option value="Husband">Husband</option>
                                    <option value="brother">brother</option>
                                    <option value="sister">sister</option>
                                </select>
                                
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                            @if($finding_user_acc->emergency_address == 'EmptyN/A')
                                    @php
                                        $finding_user_acc->emergency_address = "";
                                    @endphp
                                @endif
                                <label for="last_name">Address<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="eaddress" value="{{ $finding_user_acc->emergency_address }}"  name="eaddress" placeholder="Address">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Contact No.<sup class="sup">*</sup></label>
                                <input type="number" class="form-control" id="econtact"value="{{ $finding_user_acc->emergency_contact }}"  name="econtact" placeholder="Contact No.">
                            </div>
                        </div>
                       
                        
                    </div>
                </div>

                <!-- HIDECRED -->
                <div style="display:none">

                   
                <div class="card-header"style="font-size:16px; border:none; padding-bottom:0px">
                    <h3 class="card-title font-weight-bold" style="color: #3c8dbc !important">Credentials</h3>
                </div>
                
                <div class="card-body">
                
                    
                        
                        
                   

                        
                
                   
                
                    

                  
                                <label for="roles">Credentials  submited<sup class="sup">*</sup></label>
                                <div style="opacity:60%">
                                    <span style="font-size:10px">Legend</span>
                                </div>
                                <div class="flexing" style="margin-bottom:20px">
                                
                                    <div class="flexing ">
                                        <span  class="square selected_cred"></span><span>Submited</span>
                                    </div>
                                    <div class="flexing">
                                        <span  class="square"></span><span>Not yet</span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                <div  class="inline-buttons">
                                <script>
                           
                                    
                                    function GivingValues(vales){
                                        var idname = document.getElementById('buttonCred'+vales);
                                        var checkbox = document.getElementById('customCheckbox'+vales);

                                      

                                        if(checkbox.checked == true){
                                        
                                        
                                            
                                          
                                            checkbox.checked = false;
                                            idname.classList.remove("selected_cred");
                                            idname.classList.add("unselected_cred");
                                            idname.classList.add("greenss");
                                        }
                                        else{
                                    
                                            checkbox.checked = true;
                                            idname.classList.add("selected_cred");
                                            idname.classList.remove("unselected_cred");
                                            idname.classList.remove("greenss");
                                        }

                                        // let checkboxes = document.querySelectorAll('input[name="credentials[]"]');

                                        // // Iterate over each checkbox and alert its value if it is checked
                                        // checkboxes.forEach(function (checkbox) {
                                        //     if (checkbox.checked) {
                                        //         alert(checkbox.value);
                                        //     }
                                        // });
                                    }



                                </script>
                                <script>
                                    
                                </script>
                                @foreach($list_credentials as $value)
                                    
                                        <div>
                                            <div style="display:none">
                                                
                                                <input type="checkbox" type="checkbox" name="credentials[]" value="{{$value->id}}" id="customCheckbox{{$value->id}}">
                                            </div>
                                                
                                                    <button type="button" class="greenss form-control" id="buttonCred{{$value->id}}" onclick="GivingValues({{$value->id}})">{{$value->credentials}}</button>
                                               
                                        </div>
                                        @foreach($credentialsStuds as $creds)
                                            @if($creds == $value->credentials)
                                                    <script>
                                                        GivingValues('{{$value->id}}');
                                                    </script>
                                                   
                                            @endif
                                        @endforeach
                                @endforeach
                                </div></div>
                                
                                
                                
                            
                     
                               
                        
                        
                        
                  
                 
                </div>
                <!-- HIDECRED -->
                </div>  
                <div class="card-header"style="font-size:16px; border:none; padding-bottom:0px">
                    <h3 class="card-title font-weight-bold" style="color: #3c8dbc !important">Previous education</h3>
                </div>
                <div class="card-body">
                
                            
                          
                  
                    <div class="col-sm-4">
                        <label for="middle_name">Elementary<sup class="sup">*</sup></label>
                        <div class="input-group">
                            
                            <input type="text" placeholder="{{ (empty($previous->elementary)) ? 'N/A' : $previous->elementary }}" value="{{ (empty($previous->elementary)) ? '' : $previous->elementary }}" class="form-control" placeholder="School name" name="elem" id="elem" aria-label="Text input with dropdown button">
                            <select id="yearPicker1" onchange="yeargrads(this);" name="elemyr"  class="form-control yeargrad">
                                    <option value="" selected>Year graduated</option>
                            </select>

                           
        

                            <script>
                                // Get the current year
                                var currentYear = new Date().getFullYear();

                                // Set the range of years (adjust as needed)
                                var startYear = currentYear - 30;
                                var endYear = currentYear;
                                var currentEnds = '{{ trim((empty($previous->elementaryYr))) ? "" : trim($previous->elementaryYr) }}';
                                var yearsPass ="";
                           
                                // Get the select element
                                var yearPicker = document.getElementById("yearPicker1");
                      
                                // Populate the dropdown with years
                                for (var year = endYear; year >= startYear; year--) {
                                    if(currentYear != year){
                                        var option = document.createElement("option");
                                        option.value = year + "-" + (year+1);
                                        yearsPass = year + "-" + (year+1);
                                        
                                        if(currentEnds == yearsPass){
                                            option.selected = true;
                                     
                                        }
                                        option.text = year + "-" + (year+1);
                                        yearPicker.add(option);
                                    }
                                   
                                }

                                
                            </script>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-4">
                        <label for="middle_name">High school</label>
                        <div class="input-group">
                            <input type="text" placeholder="{{ (empty($previous->highschool)) ? 'N/A' : $previous->highschool }}" value="{{ (empty($previous->highschool)) ? '' : $previous->highschool }}" class="form-control" placeholder="School name" name="highschool" id="highschool" aria-label="Text input with dropdown button">
                            <select id="yearPicker" onchange="yeargrads(this)" name="highschoolyr"  id="highschoolyr" class="form-control yeargrad">
                                    <option value="" selected>Year graduated</option>
                            </select>

                            <script>
                                // Get the current year
                                var currentYear = new Date().getFullYear();

                                // Set the range of years (adjust as needed)
                                var startYear = currentYear - 30;
                                var endYear = currentYear;
                               
                                var currentEnds = '{{ (empty($previous->highschoolYr)) ? "" : $previous->highschoolYr }}';
                                var yearsPass ="";
                                // Get the select element
                                var yearPicker = document.getElementById("yearPicker");

                                // Populate the dropdown with years
                                for (var year = endYear; year >= startYear; year--) {
                                    if(currentYear != year){
                                        var option = document.createElement("option");
                                        option.value = year + "-" + (year+1);
                                        yearsPass = year + "-" + (year+1);
                                        if(currentEnds == yearsPass){
                                            option.selected = true;
                                        }
                                        option.text = year + "-" + (year+1);
                                        yearPicker.add(option);
                                    }
                                   
                                }

                                function yeargrads(graduated){
                                    if(graduated.value.trim() == ""){
                                        graduated.style.opacity = '80%';
                                    }
                                    else{
                                        graduated.style.opacity = '100%';
                                       
                                    }
                                }
                                            
                            </script>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-4">
                        <label for="middle_name">College</label>
                        <div class="input-group">
                            <input type="text" placeholder="{{ (empty($previous->college)) ? 'N/A' : $previous->college }}" value="{{ (empty($previous->college)) ? '' : $previous->college }}" oninput="checkifFill(this)" class="form-control" name="college" id="college" placeholder="School name" aria-label="Text input with dropdown button">
                            <select id="yearPicker2" onchange="yeargrads(this)" name="collegeyr" id="collegeyr" class="form-control yeargrad ">
                                    <option value="" selected>Year graduated</option>
                            </select>

                           
                            
                        </div>
                        <input type="text" class="form-control" value="{{ (empty($previous->collegeCourse)) ? '' : $previous->collegeCourse }}"  id="previous" name="previousCourse" placeholder="Previous course" style="margin-top:5px;display:none" aria-label="Text input with dropdown button">
                      
                        <script>
                                // Get the current year
                                var currentYear = new Date().getFullYear();

                                // Set the range of years (adjust as needed)
                                var startYear = currentYear - 30;
                                var endYear = currentYear;
                                var currentEnds = '{{ (empty($previous->collegeYr)) ?"": $previous->collegeYr }}';
                                var yearsPass ="";
                                // Get the select element
                                var yearPicker = document.getElementById("yearPicker2");
                                var previous = document.getElementById("previous");
                                // Populate the dropdown with years
                                for (var year = endYear; year >= startYear; year--) {
                                    if(currentYear != year){
                                        var option = document.createElement("option");
                                        option.value = year + "-" + (year+1);

                                        option.text = year + "-" + (year+1);

                                        yearsPass = year + "-" + (year+1);
                                        if(currentEnds == yearsPass){
                                            option.selected = true;
                                        }
                                        yearPicker.add(option);
                                    }
                                   
                                }

                                
                                function checkifFill(valey){
                                    if(valey.value.trim() != ""){
                                        previous.style.display = "block";
                                    }
                                    else if(valey.value.trim() == ""){
                                        previous.style.display = "none";
                                    }
                                   
                                }
                                
                            </script>
                              @if(!empty($previous->college))
                                <script>
                                    previous.style.display = "block";
                                </script>
                            @endif
                    </div>
                </div>
            
             
                <div class="card-body">
                
                 
                    <div class="d-flex gap-flex">
                        <!-- <a href="{{ route('kiosk.update_student_kiosk') }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a> -->
                        <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Save all information</button>
                        
                    </div>
                </div>
                
             </form>
             
           
                
                
              
              
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @if (session('success'))
    <script>
        $(document).ready(function () {
            
            
                Swal.fire({
                    
                    text: "{{ session('success')['title'] }}",
                    icon: "{{ session('success')['icon'] }}",
                });
            
        });
    </script>
@endif
  <script>
    // new MultiSelectTag('roles')  
  
  </script>
  <script>          var id_admin = '{{ $finding_user_acc->id }}';
                    var messageHtml = 'Admin password.';
                    var currentEmployeeNo = "{{$finding_user_acc->student_no}}";
                    var currentgmail = "{{$finding_user_acc->email}}";
                    
                    function levels(level){
                        fill_strand(level.value);
                    }
                    var leveling = '{{$finding_user_acc->level}}';
                
                    function fill_strand(level){
                        var currentCourse = '{{$course}}';
                        var strandss =  document.getElementById('strand');
                        var strandName =  document.getElementById('strandName');
                        strandss.innerHTML = '';
                        jQuery.ajax({
                            
                                            
                            url: "{{ url('admin/gettingStrand') }}",
                            data: {
                    
        
                                gradeLeve: level,
                            },
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            success:function(result)
                            {
                                
                                if(level == '11' || level == '12'){
                                    strandName.innerHTML = "Academic program";
                                }
                                else{
                                    strandName.innerHTML = "Academic program";
                                }
                                var results = result.strands;
                                var ids = result.ids;
                                var countings = 0;
                                results.forEach(function(element) {
                                    
                                var option = document.createElement('option');

                                
                                option.value = ids[countings];
                                if(ids[countings] == currentCourse && (level != '11' || level != '12')){
                                    option.selected = true;
                                }

                                option.text = element;
                                strandss.add(option);
                              
                                countings++;
                                });

                                
                            
                            }

                        
                        });
                    }
               
                   
                    function changeNameselect(){
                        const input = document.getElementById('first_name');
                        const value = input.value.trim();
                        var label = document.getElementById('names');
                        var values = properCase(value);
                        if(value !== ""){
                            label.innerHTML = values;
                        }
                        else{
                            label.innerHTML = "Student";
                        }

                    }

                    
                


                  
                    var nameOriginal = '';
            
                    var employeeExist = false;
                        
                    var emailExist = false;
                    var UsernameExist = false;
                    var isValid = true;
                    // Function to validate Father's orm

                    function validateForm(){
                        // var selectElement = document.getElementById('roles');
                        // var selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
            
                        const student_no = document.getElementById("student_no").value.trim();
                       
                        const gmail = document.getElementById("gmail").value.trim();
           
    

                            jQuery.ajax({
                                    
                                                    
                                    url: "{{ url('admin/checkIfStudentExist') }}",
                                    data: {
                                        datacheckEmployeeNo: student_no,
                
                                        datacheckgmail: gmail,
                                    },
                                    type: 'post',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },

                                    success:function(result)
                                    {
                                        

                                        employeeExist = result.employeeNo;
                                      
                                        emailExist = result.email;
                                        nameOriginal = result.name;
                                        
                                        validateForm_second();
                                    
                                    }

                                
                                });

          
                        
                    }

                    
                    
                    function validateForm_second(checking) {
         
                       
                        const gmails = document.getElementById("gmail");
                        const student_nos = document.getElementById("student_no");
                        // var selectElement = document.getElementById('roles');
                        // var selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
                        
                        var pattern = /^[0-9-]+$/;
                        isValid = true;
                     

                        // Reset borders and error messages
                        resetValidation();

                        // Validation for First Name, Middle Name, and Last Name

                        var student_no = document.getElementById('student_no').value.trim();
                        var gmail = document.getElementById('gmail').value.trim();

                        var first_name = document.getElementById('first_name').value.trim();
                        var middle_name = document.getElementById('middle_name').value.trim();
                        var last_name = document.getElementById('last_name').value.trim();
                        var bdayplace = document.getElementById('bdayplace').value.trim();
                        var bday = document.getElementById('bday').value.trim();
                        var age = document.getElementById('age').value.trim();
                        var region_text = document.getElementById('region-text').value.trim();
                        var city_text = document.getElementById('city-text').value.trim();
                        var province_text = document.getElementById('province-text').value.trim();
                        var barangay_text = document.getElementById('barangay-text').value.trim();
                        var house = document.getElementById('house').value.trim();
                        var contact_student = document.getElementById('contact_student').value.trim();

                        var mfirst_name = document.getElementById('mfirst_name').value.trim();
                        var mmiddle_name = document.getElementById('mmiddle_name').value.trim();
                        var mlast_name = document.getElementById('mlast_name').value.trim();
                        var moccupation = document.getElementById('moccupation').value.trim();        

                        var ffirst_name = document.getElementById('ffirst_name').value.trim();
                        var fmiddle_name = document.getElementById('fmiddle_name').value.trim();
                        var flast_name = document.getElementById('flast_name').value.trim();
                        var foccupation = document.getElementById('foccupation').value.trim();

                        var efirst_name = document.getElementById('efirst_name').value.trim();
                        var emiddle_name = document.getElementById('emiddle_name').value.trim();
                        var elast_name = document.getElementById('elast_name').value.trim();
                        var erelation = document.getElementById('erelation').value.trim();
                        var eaddress = document.getElementById('eaddress').value.trim();
                        let checkboxes = document.querySelectorAll('input[name="credentials[]"]');
                        
                 

                        var elem = document.getElementById('elem').value.trim();
                        var elemyr = document.getElementById('yearPicker1').value.trim();

                        var highschool = document.getElementById('highschool').value.trim();
                        var highschoolyr = document.getElementById('yearPicker').value.trim();

                        var college = document.getElementById('college').value.trim();
                        var collegeyr = document.getElementById('yearPicker2').value.trim();      
                        var previousCourse = document.getElementById('previous').value.trim();   
                        var econtact = document.getElementById('econtact').value.trim();   
                        var econtactTags = document.getElementById('econtact');  

                        var counting = 0;
                        checkboxes.forEach(function (checkbox) {
                            if (checkbox.checked) {
                                counting++;
                            }
                        });


                        if(employeeExist && currentEmployeeNo != student_no){
                            
                            markAsInvalid(student_nos);
                                modals("This student number already used by " + nameOriginal);
                                isValid = false;
                                return false;
                        }
                        else if(emailExist && currentgmail != gmail){
                             
                            markAsInvalid(gmails);
                                modals("This email already exists.");
                                isValid = false;
                                return false;
                        }
                        
                     

                        if(  
                            
                            student_no !== "" &&
                            gmail !== "" &&
                            first_name !== "" &&
                            econtact !== "" &&
                            last_name !== "" &&
                            bdayplace !== "" &&
                            bday !== "" &&
                            age !== "" &&
                            region_text !== "" &&
                            city_text !== "" &&
                            province_text !== "" &&
                            barangay_text !== "" &&
                            house !== "" &&
                            contact_student !== "" &&
                            mfirst_name !== "" &&
                            
                            mlast_name !== "" &&
                            moccupation !== "" &&
                            ffirst_name !== "" &&
                            
                            flast_name !== "" &&
                            foccupation !== "" &&
                            efirst_name !== "" &&
                            
                            elast_name !== "" &&
                            erelation !== "" &&
                            eaddress !== "" &&
                         
                          
                            elem !== "" &&
                            elemyr !== ""
                            ){
                           

                     
                            
                            
                            const contactStudentPattern = /^[0-9]+$/;
                            const namePattern = /^[A-Za-zÑñ\s/.\-]+$/;
                            const studentNoPattern = /^[0-9-]+$/;
                            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                            // Initialize an array to store validation errors
                   

                            if (!first_name || first_name.length < 2 || first_name.length > 90 || !namePattern.test(first_name)) {
                                modals("Student's first name should have a minimum of 5 characters and a maximum of 90 characters.");

                                first_name = document.getElementById('first_name');
                                
                                markAsInvalid(first_name);
                                isValid = false;
                            } else if (middle_name && (middle_name.length < 2 || middle_name.length > 90 || !namePattern.test(middle_name))) {
                                modals("Student's middle name should have a minimum of 2 characters and a maximum of 90 characters.");
                                middle_name = document.getElementById('middle_name');
                                
                                markAsInvalid(middle_name);
                                isValid = false;
                            } else if (!last_name || last_name.length < 2 || last_name.length > 90 || !namePattern.test(last_name)) {
                                last_name = document.getElementById('last_name');
                                modals("Student's last name should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(last_name);
                                isValid = false;
                            } 
                            
                            
                            else if (!bdayplace || bdayplace.length < 2 || bdayplace.length > 150) {
                                bdayplace = document.getElementById('bdayplace');
                                modals("Student's birthplace should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(bdayplace);
                                isValid = false;
                            }else if (!age ||  age.length != 2) {
                                age = document.getElementById('age');
                                modals("Student's age should have 2 digits only.");
                                markAsInvalid(age);
                                isValid = false;
                            }
                            
                            
                            else if (!student_no || student_no.length < 5 || student_no.length > 20 || !studentNoPattern.test(student_no)) {
                                student_no = document.getElementById('student_no');
                                modals("The student number should have a minimum of 5 characters and a maximum of 20 characters.");
                                markAsInvalid(student_no);
                                isValid = false;
                            } else if (!gmail || gmail.length < 5 || gmail.length > 90 || !emailPattern.test(gmail)) {
                                gmail = document.getElementById('gmail');
                                modals("Student's email should have a minimum of 5 characters and a maximum of 90 characters, and be a valid email address.");
                                markAsInvalid(gmail);
                                isValid = false;
                            } else if (!region_text || region_text.length < 2 || region_text.length > 90) {
                                region_text = document.getElementById('region_text');
                                modals("The region should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(region_text);
                                isValid = false;
                            } else if (!city_text || city_text.length < 2 || city_text.length > 90) {
                                city_text = document.getElementById('city_text');
                                modals("The city should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(city_text);
                                isValid = false;
                            } else if (!province_text || province_text.length < 2 || province_text.length > 90) {
                                city_text = document.getElementById('city_text');
                                modals("The province should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(city_text);
                                isValid = false;
                            } else if (!barangay_text || barangay_text.length < 2 || barangay_text.length > 90) {
                                barangay_text = document.getElementById('barangay_text');
                                modals("The barangay should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(barangay_text);
                                isValid = false;
                            } else if (!house || house.length < 2 || house.length > 90) {
                                house = document.getElementById('house');
                                modals("The house should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(house);
                                isValid = false;
                            } else if (!contact_student || contact_student.length != 11 || !contactStudentPattern.test(contact_student)) {
                                contact_student = document.getElementById('contact_student');
                                modals("Student's contact number should be 11 digits only.");
                                markAsInvalid(contact_student);
                                isValid = false;
                            } else if (!mfirst_name || mfirst_name.length < 2 || mfirst_name.length > 90 || !namePattern.test(mfirst_name)) {
                                mfirst_name = document.getElementById('mfirst_name');
                                modals("Mother's first name should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(mfirst_name);
                                isValid = false;
                            } else if (mmiddle_name && (mmiddle_name.length < 2 || mmiddle_name.length > 90 || !namePattern.test(mmiddle_name))) {
                                mmiddle_name = document.getElementById('mmiddle_name');
                                modals("Mother's middle name should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(mmiddle_name);
                                isValid = false;
                            } else if (!mlast_name || mlast_name.length < 2 || mlast_name.length > 90 || !namePattern.test(mlast_name)) {
                                mlast_name = document.getElementById('mlast_name');
                                modals("Mother's last name should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(mlast_name);
                                isValid = false;
                            } else if (moccupation && (moccupation.length < 2 || moccupation.length > 90)) {
                                moccupation = document.getElementById('moccupation');
                                modals("Mother's occupation should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(moccupation);
                                isValid = false;
                            } else if (!ffirst_name || ffirst_name.length < 2 || ffirst_name.length > 90 || !namePattern.test(ffirst_name)) {
                                ffirst_name = document.getElementById('ffirst_name');
                                modals("Father's first name should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(ffirst_name);
                                isValid = false;
                            } else if (fmiddle_name && (fmiddle_name.length < 2 || fmiddle_name.length > 90 || !namePattern.test(fmiddle_name))) {
                                fmiddle_name = document.getElementById('fmiddle_name');
                                modals("Father's middle name should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(fmiddle_name);
                                isValid = false;
                            } else if (!flast_name || flast_name.length < 2 || flast_name.length > 90 || !namePattern.test(flast_name)) {
                                flast_name = document.getElementById('flast_name');
                                modals("Father's last name should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(flast_name);
                                isValid = false;
                            } else if (foccupation && (foccupation.length < 2 || foccupation.length > 90)) {
                                foccupation = document.getElementById('foccupation');
                                modals("Father's occupation should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(foccupation);
                                isValid = false;
                            } else if (!efirst_name || efirst_name.length < 2 || efirst_name.length > 90 || !namePattern.test(efirst_name)) {
                                efirst_name = document.getElementById('efirst_name');
                                modals("Guardian's first name should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(efirst_name);
                                isValid = false;
                            } else if (emiddle_name && (emiddle_name.length < 2 || emiddle_name.length > 90 || !namePattern.test(emiddle_name))) {
                                emiddle_name = document.getElementById('emiddle_name');
                                modals("Guardian's middle name should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(emiddle_name);
                                isValid = false;
                            } else if (!elast_name || elast_name.length < 2 || elast_name.length > 90 || !namePattern.test(elast_name)) {
                                elast_name = document.getElementById('elast_name');
                                modals("Guardian's last name should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(elast_name);
                                isValid = false;
                            } else if (!erelation || erelation.length < 2 || erelation.length > 90 || !namePattern.test(erelation)) {
                                erelation = document.getElementById('erelation');
                                modals("Guardian's relation should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(erelation);
                                isValid = false;
                            } else if (!eaddress || eaddress.length < 2 || eaddress.length > 200) {
                                eaddress = document.getElementById('eaddress');
                                modals("Guardian's address should have a minimum of 2 characters and a maximum of 200 characters.");
                                markAsInvalid(eaddress);
                                isValid = false;
                            }else if (!econtact || econtact.length != 11 || !contactStudentPattern.test(econtact)) {
                                contact_student = document.getElementById('econtact');
                                modals("Guardian's contact number should be 11 digits only.");
                                markAsInvalid(econtactTags);
                                isValid = false;
                            }



                            if (!elem || elem.length < 2 || elem.length > 90) {
                                elem = document.getElementById('elem');
                                modals("Elementary should have a minimum of 2 characters and a maximum of 90 characters.");
                                markAsInvalid(elem);
                                isValid = false;
                            }

                            if (!elemyr || elemyr.length < 2 || elemyr.length > 90) {
                                elemyr = document.getElementById('yearPicker1');
                                modals("The elementary year of graduation should be between 2 and 90 characters in length.");
                                markAsInvalid(elemyr);
                                isValid = false;
                            }

                            if (highschool != "") {
                                if( highschool.length < 2 || highschool.length > 90){
                                    highschool = document.getElementById('highschool');
                                    modals("High school should have a minimum of 2 characters and a maximum of 90 characters.");
                                    markAsInvalid(highschool);
                                    isValid = false;
                                }
                                
                            }
                            if(highschool != ""){

                                if( highschoolyr.length < 2 || highschoolyr.length > 90){
                                    highschoolyr = document.getElementById('yearPicker');
                                    modals("The high school year of graduation should be between 2 and 90 characters in length.");
                                    markAsInvalid(highschoolyr);
                                    isValid = false;
                                }

                            }

                            if(college != ""){

                                if( college.length < 2 || college.length > 90){
                                    college = document.getElementById('college');
                                    modals("College should have a minimum of 2 characters and a maximum of 90 characters.");
                                    markAsInvalid(college);
                                    isValid = false;
                                }

                            }

                            if(college != ""){

                                if( collegeyr.length < 2 || collegeyr.length > 90){
                                    collegeyr = document.getElementById('yearPicker2');
                                    modals("The College year of graduation should be between 2 and 90 characters in length.");
                                    markAsInvalid(collegeyr);
                                    isValid = false;
                                }

                            }

                            if(college != ""){

                                if( previousCourse.length < 2 || previousCourse.length > 90){
                                    previousCourse = document.getElementById('previous');
                                    modals("Previous course should have a minimum of 2 characters and a maximum of 90 characters.");
                                    markAsInvalid(previousCourse);
                                    isValid = false;
                                }

                            }





                            
                            
                
                            
                            if (isValid) {

// deleting_admin(id_admin, messageHtml);
// $(function () {
//     $('[data-toggle="tooltip"]').tooltip()
//     })
//         function deleting_admin(id_admin, messageHtml)
//         {
//             var trues = "";
            
//         (async () => {
        


//                 const { value: password } = await Swal.fire({
//                 title: 'Enter your password',
//                 input: 'password',
//                 html: '<b>' + messageHtml + '</b>',
//                 confirmButtonText: "Continue",
//                 inputPlaceholder: 'Enter your password',
//                 inputAttributes: {
//                     maxlength: 30,
//                     autocapitalize: 'off',
//                     autocorrect: 'off',
                    
//                 }
//                 })

//                 if (password) {
                
//                 // Swal.fire(`Entered password: ${password}`);
//                 jQuery.ajax({
                
                
//                     url: "{{ url('admin/checkpassword') }}",
//                     data: {
//                         password: password,
//                     },
//                     type: 'post',
//                     headers: {
//                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     },

//                     success:function(result)
//                     {
                        
//                     trues = result.password;
//                     id = id_admin;
//                     checkingTrues(trues, id);
//                     }

            
//                 });
                
                
//                 }
                
            
//         })()
        
//         }
//         function checkingTrues(password, id){
        
//         if(password != 'false'){
//             document.getElementById('myForm').submit();
//         }
//         else{
//             deleting_admin(id, '<span style="color:rgb(165, 73, 73)">Wrong password.</span>');
//         }
//     }           
                let sex = document.getElementById("sexs").value;
                let sivil_status = document.getElementById("sivil_statuss").value;

                let level = document.getElementById("level").value;
                let strand = document.getElementById("strand").value;
                let citizenship = document.getElementById("citizenship").value;
           

                let region = document.getElementById("region-text").value;
                let province = document.getElementById("province-text").value;
                let city = document.getElementById("city-text").value;
                let barangay = document.getElementById("barangay-text").value;


                let yearPicker2 = document.getElementById("yearPicker2").value;
                let yearPicker = document.getElementById("yearPicker").value;
                let yearPicker1 = document.getElementById("yearPicker1").value;

                let previous = document.getElementById("previous").value;

                var htmlList = `
                  <br>
                  
                    <div class="showingsj">
                    <h4 style="text-transform: uppercase;text-align:left" ><b>Please review the information before saving, incomplete or inaccurate details could potentially create difficulties during the enrollment process.</b></h4>
                    <br><br>
                    <h3 style="text-transform: uppercase;text-align:left" ><b>Student Information</b></h3>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Student no: </b>`+student_no.toUpperCase() +`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Email: </b>`+gmail.toUpperCase() +`</h5>

                    <h5 style="text-align:left"><b style="text-transform: uppercase;">First name: </b>`+first_name.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Middle name: </b>`+middle_name.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Last name: </b>`+last_name.toUpperCase() +`</h5>


                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Birthday: </b>`+bday.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Birthplace: </b>`+bdayplace.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Age: </b>`+age.toUpperCase()+`</h5>

        
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Citizenship: </b>`+citizenship.toUpperCase()+`</h5>


                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Gender: </b>`+sex.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Civil status: </b>`+sivil_status.toUpperCase()+`</h5>

                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Region: </b>`+region.toUpperCase()+`</h5>

                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Province: </b>`+province.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">City: </b>`+city.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Barangay: </b>`+barangay.toUpperCase()+`</h5>


                    <h5 style="text-align:left"><b style="text-transform: uppercase;">House number/Street: </b>`+house.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Contact No.: </b>`+contact_student.toUpperCase()+`</h5>

                    <br>
                    <h3 style="text-transform: uppercase;text-align:left" ><b>Mother's Information</b></h3>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">First name: </b>`+mfirst_name.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Middle name: </b>`+mmiddle_name.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Last name: </b>`+mlast_name.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Occupation: </b>`+moccupation.toUpperCase()+`</h5>

                    <br>
                    <h3 style="text-transform: uppercase;text-align:left" ><b>Father's Information</b></h3>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">First name: </b>`+ffirst_name.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Middle name: </b>`+fmiddle_name.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Last name: </b>`+flast_name.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Occupation: </b>`+foccupation.toUpperCase()+`</h5>


                    <br>
                    
                    <h3 style="text-transform: uppercase;text-align:left" ><b>Guardian's Information</b></h3>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">First name: </b>`+efirst_name.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Middle name: </b>`+emiddle_name.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Last name: </b>`+elast_name.toUpperCase()+`</h5>

                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Relation: </b>`+erelation.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Address: </b>`+eaddress.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Contact No.: </b>`+econtact.toUpperCase()+`</h5>

                    <br>
                    <h3 style="text-transform: uppercase;text-align:left" ><b>Previous education</b></h3>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Elementary: </b>`+elem.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Year graduated (elementary): </b>`+yearPicker1.toUpperCase()+`</h5>

                    <br>
             
           


                    <h5 style="text-align:left"><b style="text-transform: uppercase;">High school: </b>`+highschool.toUpperCase()+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Year graduated (high school): </b>`+yearPicker.toUpperCase()+`</h5>
                    <br>
                  
                    
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">College: </b>`+college.toUpperCase()+`</h5>


                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Year graduated (college): </b>`+yearPicker2.toUpperCase()+`</h5>


                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Previous course: </b>`+previous.toUpperCase()+`</h5>
                    </div>
                    
                
            
                    
                  `;


       
                  
                     
                    Swal.fire({
                        title: '',
                        width: '40%',
                        html: htmlList,
                        
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Save information'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            // alert(efirst_name);
                            document.getElementById('myForm').submit();
                            
                        }
                    })
    

}
    



                        
                        
                    }
                    
                    else{
                     // Get all form elements
                        var formElements = document.getElementById("myForm").elements;

                        // Loop through form elements
                        for (var i = 0; i < formElements.length; i++) {
                            var element = formElements[i];

                            // Check if the element is an input, select, or checkbox
                            if (element.tagName === "INPUT" || element.tagName === "SELECT" || element.tagName === "CHECKBOX") {
                                // Check if the value is empty
                                if (element.value.trim() === "") {

                                    if(element.id && element.id != 'emiddle_name'

                                    && element.id != 'fmiddle_name'
                                    && element.id != 'mmiddle_name'
                                    && element.id != 'middle_name'
                                    && element.id != 'highschool'
                                        && element.id != 'yearPicker'
                                        && element.id != 'yearPicker2'
                                        && element.id != 'college'
                                    ){
                                      element.style.borderColor = "rgb(165, 73, 73)";
                                    }
                                    
                             
                                }
                            }
                        }

                        modals("Please fill all the information needed.");
                        isValid = false;
                    }
                      
                        
                        
   
                      
                   
                    
                    }



                    function modals(message){

                        Swal.fire({
                        icon: 'error',
                        title: 'Invalid input',
                        text: message,
                        confirmButtonText: "Back",
                        }
                        
                        
                        )

                        

                    }

                    // Function to mark an input as invalid (add red border)
                    function markAsInvalid(inputElement) {
                        inputElement.style.borderColor = "rgb(165, 73, 73)";
                    }



                    // Function to reset input styles and error messages
                    function resetValidation() {
                        const inputs = document.querySelectorAll("input");
                        for (const input of inputs) {
                            input.style.borderColor = "";
                        }

                        var inputsf = document.querySelectorAll("select");
                        for (const input of inputsf) {
                            input.style.borderColor = "";
                        }
                    }

                    
                    

                    function validateInputAge(input) {
                        input.value = input.value.replace(/[^0-9]/g, '');
                        if(input.value.length > 2){

                       
                            document.getElementById("age").value = input.value[0] + input.value[1];
 
                        }
                        else if(input.value > 60){
                            input.value = '59';
                            
                        }
                        else{
                            document.getElementById("age").value = input.value;
                        }
                        
                    }



                    

                
var my_handlers = {
    // fill province
    fill_provinces: function() {
        //selected region
        var region_code = $(this).val();

        // set selected text to input
        var region_text = $(this).find("option:selected").text();
        let region_input = $('#region-text');
        region_input.val(region_text);
        //clear province & city & barangay input
        $('#province-text').val('');
        $('#city-text').val('');
        $('#barangay-text').val('');

        //province
        let dropdown = $('#province');
        dropdown.empty();
        dropdown.append('<option selected="true" disabled>Choose State/Province</option>');
        dropdown.prop('selectedIndex', 0);

        //city
        let city = $('#city');
        
        city.empty();
        city.append('<option selected="true" disabled>Select province first</option>');
        city.prop('selectedIndex', 0);

        //barangay
        let barangay = $('#barangay');
        barangay.empty();
        barangay.append('<option selected="true" disabled>Select city first</option>');
        barangay.prop('selectedIndex', 0);

        // filter & fill
        var url = "{{ asset('dist/js/ph-json/province.json') }}";
        $.getJSON(url, function(data) {
            var result = data.filter(function(value) {
                return value.region_code == region_code;
            });

            result.sort(function(a, b) {
                return a.province_name.localeCompare(b.province_name);
            });

            $.each(result, function(key, entry) {
                dropdown.append($('<option></option>').attr('value', entry.province_code).text(entry.province_name));
            })

        });
    },
    // fill city
    fill_cities: function() {
        //selected province
        var province_code = $(this).val();

        // set selected text to input
        var province_text = $(this).find("option:selected").text();
        let province_input = $('#province-text');
        province_input.val(province_text);
        //clear city & barangay input
        $('#city-text').val('');
        $('#barangay-text').val('');

        //city
        let dropdown = $('#city');
        dropdown.empty();
        dropdown.append('<option selected="true" disabled>Choose city/municipality</option>');
        dropdown.prop('selectedIndex', 0);

        //barangay
        let barangay = $('#barangay');
        barangay.empty();
        barangay.append('<option selected="true" disabled>Select city first</option>');
        barangay.prop('selectedIndex', 0);

        // filter & fill
        var url = "{{ asset('dist/js/ph-json/city.json') }}";
        $.getJSON(url, function(data) {
            var result = data.filter(function(value) {
                return value.province_code == province_code;
            });

            result.sort(function(a, b) {
                return a.city_name.localeCompare(b.city_name);
            });

            $.each(result, function(key, entry) {
                dropdown.append($('<option></option>').attr('value', entry.city_code).text(entry.city_name));
            })

        });
    },
    // fill barangay
    fill_barangays: function() {
        // selected barangay
        var city_code = $(this).val();

        // set selected text to input
        var city_text = $(this).find("option:selected").text();
        let city_input = $('#city-text');
        city_input.val(city_text);
        //clear barangay input
        $('#barangay-text').val('');

        // barangay
        let dropdown = $('#barangay');

        dropdown.empty();
        
        dropdown.append('<option selected="true" disabled>Choose barangay</option>');
        dropdown.prop('selectedIndex', 0);

        // filter & Fill
        var url = "{{ asset('dist/js/ph-json/barangay.json') }}";
        $.getJSON(url, function(data) {
            var result = data.filter(function(value) {
                return value.city_code == city_code;
            });

            result.sort(function(a, b) {
                return a.brgy_name.localeCompare(b.brgy_name);
            });

            $.each(result, function(key, entry) {

                
                    dropdown.append($('<option></option>').attr('value', entry.brgy_code).text(entry.brgy_name));
         
               
            })

        });
    },

    onchange_barangay: function() {
        // set selected text to input
        var barangay_text = $(this).find("option:selected").text();
        let barangay_input = $('#barangay-text');
        barangay_input.val(barangay_text);
    },

};

$(function() {
            // events
            $('#region').on('change', my_handlers.fill_provinces);
            $('#province').on('change', my_handlers.fill_cities);
            $('#city').on('change', my_handlers.fill_barangays);
            $('#barangay').on('change', my_handlers.onchange_barangay);

            // load region
            let dropdown = $('#region');
           
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Choose Region</option>');
            dropdown.prop('selectedIndex', 0);
            const url = "{{ asset('dist/js/ph-json/region.json') }}";
            // Populate dropdown with list of regions
            $.getJSON(url, function(data) {
                $.each(data, function(key, entry) {
                    
                        dropdown.append($('<option></option>').attr('value', entry.region_code).text(entry.region_name));
                    
                
                })
            });



        });
        
 
               
  

                    
                </script>
               <script>
                function filling(){
                    student_no.value = "1234567";
                    gmail.value = "pogi@gmail.com";
                    first_name.value = "Lawrence";
                    middle_name.value = "Domingo";
                    last_name.value = "Miranda";
                    bdayplace.value = "Bamban Tarlac";
           
                 
                    house.value = "Blk 86";
                    contact_student.value = "09182310664";
                    mfirst_name.value = "Raquel";
                    mmiddle_name.value = "";
                    mlast_name.value = "Miranda";
                    moccupation.value = "Ceo";
                    ffirst_name.value = "Jhosep";
                    fmiddle_name.value = "";
                    flast_name.value = "Miranda";
                    foccupation.value = "Engineer";
                    efirst_name.value = "Raquel";
                    emiddle_name.value = "";
                    elast_name.value = "Miranda";
                    erelation.value = "Mother";
                    eaddress.value = "Bamban Tarlac";
                    elem.value = "Lourdess";
                }


               </script>


<script>

    window.addEventListener('load', function () {
        warningFills();
    })

    function warningFills(){
        
        var formElements = document.getElementById("myForm").elements;

        // Loop through form elements
        for (var i = 0; i < formElements.length; i++) {
            var element = formElements[i];

            // Check if the element is an input, select, or checkbox
            if (element.tagName === "INPUT" || element.tagName === "SELECT" || element.tagName === "CHECKBOX") {
                // Check if the value is empty
                if (element.value.trim() === "") {

                    if(element.id && element.id != 'emiddle_name'

                    && element.id != 'fmiddle_name'
                    && element.id != 'mmiddle_name'
                    && element.id != 'middle_name'
                    && element.id != 'highschool'
                        && element.id != 'yearPicker'
                        && element.id != 'yearPicker2'
                        && element.id != 'college'
                        && element.id != 'strand'
                    ){
                    element.style.borderColor = "#ffc107";
                    }
                    
            
                }
            }
        }
        
    }
</script>

@endsection