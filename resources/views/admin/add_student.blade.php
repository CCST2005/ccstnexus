@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | add student

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create account</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-12">
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add student account</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
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
             
              
              <form id="myForm" method="POST" action="{{ route('admin.adding_student') }}">
                <div class="card-body">
                @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="employee_no">Student no.<sup class="sup">*</sup></label>
                                <input type="text" onkeyup="validateInput(this)" class="form-control" id="student_no" name="student_no" placeholder="Employee no.">
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
                                <input type="email" class="form-control" id="gmail" name="gmail"  placeholder="Email">
                            </div>
                        </div>
                    
                        <div class="col-sm-4"  style="display:none">
                            <div class="form-group">
                                <label for="email">Username<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="username" readonly name="username"  placeholder="username">
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
                                <input type="text" class="form-control" id="first_name" onkeyup="changeNameselect()" name="first_name" placeholder="First name">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="middle_name">Middle name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Last name<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Birthday<sup class="sup">*</sup></label>
                                <input type="date" onchange="passwordFill(this)" class="form-control" id="bday" name="bday" placeholder="Birthplace">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Birthplace<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="bdayplace" name="bdayplace" placeholder="Birthplace">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Age<sup class="sup">*</sup></label>

                                <select class="custom-select" disabled id="age" name="age">
                              
                                      <option value="">Select birthday first</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Grade level<sup class="sup">*</sup></label>
                                
                                <select class="custom-select" onchange="fill_strand(this)"  id="level" name="level">
                              
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="College">College</option>

                                </select>
                               
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name" > <span id="strandName">Academic track</span> <sup class="sup">*</sup></label>
                                
                                <select class="custom-select"  id="strand" name="strand">
                              
                                    @foreach ($listStrand as $listStrands)
                                        <option value="{{ $listStrands->id }}">{{ $listStrands->course }}</option>
                                    @endforeach       

                                </select>
                            </div>
                        </div>



                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="citizenship">Citizenship<sup class="sup">*</sup></label>
                                
                                <select class="custom-select" id="citizenship" name="citizenship">
                                    
                                    @foreach ($citizenships as $citizenship)
                                        <option value="{{ $citizenship }}">{{ $citizenship }}</option>
                                    @endforeach                                         
                                </select>

                                <script>
                                    
                                    var citizenship = document.getElementById("citizenship");
                                    citizenship.value = "Filipino";
                                    
                                </script>
                            </div>
                        </div>
                            

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="citizenship">Sex<sup class="sup">*</sup></label>
                                <select class="custom-select"  name="sex">
                              
                                    <option value="Male">Male</option>
                                    <option value="Male">Female</option>    

                                </select>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="citizenship">Civil status<sup class="sup">*</sup></label>
                                <select class="custom-select"  name="sivil_status">
                              
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>    

                                </select>
                            </div>
                        </div>



                        
                        <script>
                            var dateToday = {{ $currentYear }}-15;
                          
                            function passwordFill(value){

                                const ages = document.getElementById("age");
                                
                               
                                const bday = document.getElementById("bday");
                                var dob = new Date(value.value);
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
                                password.value = value.value;

                                cpassword.value = value.value;


                                 dob = new Date(value.value);

                                
                                 currentDate = new Date();

                                
                        
                                

                                
                                var age = currentDate.getFullYear() - dob.getFullYear();

                               
                                if (currentDate.getMonth() < dob.getMonth() || (currentDate.getMonth() === dob.getMonth() && currentDate.getDate() < dob.getDate())) {
                                    age--;
                                }

                               

                                ages.value = age;

                                var ageMinus = age-1;
                                var ageAdd = age+1;

                               

                                var option = document.createElement('option');
                                option.value = ageMinus;
                                option.text = ageMinus;
                                ages.add(option);

                                option = document.createElement('option');
                                option.value = age;
                                option.selected = true;
                                option.text = age;
                                ages.add(option);

                                option = document.createElement('option');
                                option.value = ageAdd;
                                option.text = ageAdd;
                                ages.add(option);
                               

                               

                            }
                        </script>
                        
                        
                       
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Region<sup class="sup">*</sup></label>
                                
                                <select name="region" class="form-control tags_input" id="region"></select>
                                <input type="hidden" class="" value="" name="region-text" id="region-text" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Province<sup class="sup">*</sup></label>
                                <select name="province" class="form-control tags_input" id="province"><option value="">Select region first</option></select>
                                <input type="hidden" class="" value="" name="province-text" id="province-text" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">City<sup class="sup">*</sup></label>
                                <select name="city" class="form-control tags_input" id="city"><option value="">Select province first</option></select>
                                <input type="hidden" class="" name="city-text" value="" id="city-text" required>
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Barangay<sup class="sup">*</sup></label>
                                <select name="barangay" class="form-control tags_input" id="barangay"><option value="">Select city first</option></select>
                                <input type="hidden" class="" name="barangay-text" id="barangay-text" value="" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">House number/Street<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="house" name="house" placeholder="House number/Street">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Contact No.<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="contact_student" name="contact_student" placeholder="Contact No.">
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
                                <input type="text" class="form-control" id="mfirst_name" name="mfirst_name" placeholder="Mother's first name">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="middle_name">Middle name</label>
                                <input type="text" class="form-control" id="mmiddle_name" name="mmiddle_name" placeholder="Mother's middle name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Last name<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="mlast_name" name="mlast_name" placeholder="Mother's last name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Occupation<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="moccupation" name="moccupation" placeholder="Mother's occupation">
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
                                <input type="text" class="form-control" id="ffirst_name" name="ffirst_name" placeholder="Father's first name">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="middle_name">Middle name</label>
                                <input type="text" class="form-control" id="fmiddle_name" name="fmiddle_name" placeholder="Father's middle name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Last name<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="flast_name" name="flast_name" placeholder="Father's last name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Occupation<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="foccupation" name="foccupation" placeholder="Father's occupation">
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

                            efirst_name.disabled = true;
                            emiddle_name.disabled = true;
                            elast_name.disabled = true;
                            erelation.disabled = true;
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

                            efirst_name.disabled = true;
                            emiddle_name.disabled = true;
                            elast_name.disabled = true;
                            erelation.disabled = true;
                            efirst_name.style = "opacity: 50%";
                            emiddle_name.style = "opacity: 50%";
                            elast_name.style = "opacity: 50%";
                            erelation.style = "opacity: 50%";
                        }
                        else{
                            efirst_name.value = '';
                            emiddle_name.value = '';
                            elast_name.value = '';
                            erelation.value = '';

                            efirst_name.disabled = false;
                            emiddle_name.disabled = false;
                            elast_name.disabled = false;
                            erelation.disabled = false;
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
                                <input type="text" class="form-control" id="efirst_name" name="efirst_name" placeholder="Guardian's first name">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="middle_name">Middle name</label>
                                <input type="text" class="form-control" id="emiddle_name" name="emiddle_name" placeholder="Guardian's middle name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Last name<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="elast_name" name="elast_name" placeholder="Guardian's last name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Relation<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="erelation" name="erelation" placeholder="Relation">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Address<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="eaddress" name="eaddress" placeholder="Address">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="last_name">Contact No.<sup class="sup">*</sup></label>
                                <input type="text" class="form-control" id="econtact" name="econtact" placeholder="Address">
                            </div>
                        </div>
                       
                        
                    </div>
                </div>
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
                                
                                    
                                @foreach($list_credentials as $value)
                                    
                                        <div>
                                            <div style="display:none">
                                            
                                                <input type="checkbox" type="checkbox" name="credentials[]" value="{{$value->id}}" id="customCheckbox{{$value->id}}">
                                            </div>
                                                
                                                    <button type="button" class="greenss form-control" id="buttonCred{{$value->id}}" onclick="GivingValues({{$value->id}})">{{$value->credentials}}</button>
                                               
                                        </div>
                                   
                                @endforeach
                                </div></div>
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
                                
                                
                            
                     
                               
                        
                        
                        
                  
                 
                </div>

                <div class="card-header"style="font-size:16px; border:none; padding-bottom:0px">
                    <h3 class="card-title font-weight-bold" style="color: #3c8dbc !important">Previous education</h3>
                </div>
                <div class="card-body">
                
                            
                          
                  
                    <div class="col-sm-4">
                        <label for="middle_name">Elementary<sup class="sup">*</sup></label>
                        <div class="input-group">
                            
                            <input type="text" class="form-control" placeholder="School name" name="elem" id="elem" aria-label="Text input with dropdown button">
                            <select id="yearPicker1" onchange="yeargrads(this);" name="elemyr"  class="form-control yeargrad">
                                    <option value="" selected>Year graduated</option>
                            </select>

                           
        

                            <script>
                                // Get the current year
                                var currentYear = new Date().getFullYear();

                                // Set the range of years (adjust as needed)
                                var startYear = currentYear - 10;
                                var endYear = currentYear;

                                // Get the select element
                                var yearPicker = document.getElementById("yearPicker1");

                                // Populate the dropdown with years
                                for (var year = endYear; year >= startYear; year--) {
                                    if(currentYear != year){
                                        var option = document.createElement("option");
                                        option.value = year + "-" + (year+1);
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
                            <input type="text" class="form-control" placeholder="School name" name="highschool" id="highschool" aria-label="Text input with dropdown button">
                            <select id="yearPicker" onchange="yeargrads(this)" name="highschoolyr"  id="highschoolyr" class="form-control yeargrad">
                                    <option value="" selected>Year graduated</option>
                            </select>

                            <script>
                                // Get the current year
                                var currentYear = new Date().getFullYear();

                                // Set the range of years (adjust as needed)
                                var startYear = currentYear - 10;
                                var endYear = currentYear;

                                // Get the select element
                                var yearPicker = document.getElementById("yearPicker");

                                // Populate the dropdown with years
                                for (var year = endYear; year >= startYear; year--) {
                                    if(currentYear != year){
                                        var option = document.createElement("option");
                                        option.value = year + "-" + (year+1);
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
                            <input type="text" oninput="checkifFill(this)" class="form-control" name="college" id="college" placeholder="School name" aria-label="Text input with dropdown button">
                            <select id="yearPicker2" onchange="yeargrads(this)" name="collegeyr" id="collegeyr" class="form-control yeargrad ">
                                    <option value="" selected>Year graduated</option>
                            </select>

                           
                            
                        </div>
                        <input type="text" class="form-control" id="previous" name="previousCourse" placeholder="Previous course" style="margin-top:5px;display:none" aria-label="Text input with dropdown button">
                        <script>
                                // Get the current year
                                var currentYear = new Date().getFullYear();

                                // Set the range of years (adjust as needed)
                                var startYear = currentYear - 10;
                                var endYear = currentYear;

                                // Get the select element
                                var yearPicker = document.getElementById("yearPicker2");
                                var previous = document.getElementById("previous");
                                // Populate the dropdown with years
                                for (var year = endYear; year >= startYear; year--) {
                                    if(currentYear != year){
                                        var option = document.createElement("option");
                                        option.value = year + "-" + (year+1);
                                        option.text = year + "-" + (year+1);
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
                    </div>
                </div>
                
             
                <div class="card-body">
                
                 
                    <div class="d-flex gap-flex">
                        <a href="{{ route('admin.teacher') }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a>
                        <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Add account</button>
                        
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
  <script>
                    function fill_strand(level){
                        var strandss =  document.getElementById('strand');
                        var strandName =  document.getElementById('strandName');
                        strandss.innerHTML = '';
                        jQuery.ajax({
                            
                                            
                            url: "{{ url('admin/gettingStrand') }}",
                            data: {
                    
        
                                gradeLeve: level.value,
                            },
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            success:function(result)
                            {
                                
                                if(level.value == '11' || level.value == '12'){
                                    strandName.innerHTML = "Academic programs";
                                }
                                else{
                                    strandName.innerHTML = "Academic programs";
                                }
                                var results = result.strands;
                                var ids = result.ids;
                                var countings = 0;
                                results.forEach(function(element) {
                                    
                                var option = document.createElement('option');
                                option.value = ids[countings];
                               
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
                        var counting = 0;
                        checkboxes.forEach(function (checkbox) {
                            if (checkbox.checked) {
                                counting++;
                            }
                        });


                        if(employeeExist){
                            
                            markAsInvalid(student_nos);
                                modals("Student number already exists.");
                                isValid = false;
                                return false;
                        }
                        else if(emailExist){
                             
                            markAsInvalid(gmails);
                                modals("This email already exists.");
                                isValid = false;
                                return false;
                        }
                        
                     

                        if(  
                            
                            student_no !== "" &&
                            gmail !== "" &&
                            first_name !== "" &&
                            
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
                            counting !== 0 && 
                            econtact !== "" && 
                            elem !== "" &&
                            elemyr !== ""
                            ){
                           


                            
                            
                            const contactStudentPattern = /^[0-9]+$/;
                            const namePattern = /^[A-Za-z\s]+$/;
                            const studentNoPattern = /^[0-9-]+$/;
                            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                            // Initialize an array to store validation errors
                   

                            if (!first_name || first_name.length < 2 || first_name.length > 30 || !namePattern.test(first_name)) {
                                modals("Student's first name should have a minimum of 5 characters and a maximum of 30 characters.");

                                first_name = document.getElementById('first_name');
                                
                                markAsInvalid(first_name);
                                isValid = false;
                            } else if (middle_name && (middle_name.length < 2 || middle_name.length > 30 || !namePattern.test(middle_name))) {
                                modals("Student's middle name should have a minimum of 2 characters and a maximum of 30 characters.");
                                middle_name = document.getElementById('middle_name');
                                
                                markAsInvalid(middle_name);
                                isValid = false;
                            } else if (!last_name || last_name.length < 2 || last_name.length > 30 || !namePattern.test(last_name)) {
                                last_name = document.getElementById('last_name');
                                modals("Student's last name should have a minimum of 2 characters and a maximum of 30 characters.");
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
                            } else if (!gmail || gmail.length < 5 || gmail.length > 30 || !emailPattern.test(gmail)) {
                                gmail = document.getElementById('gmail');
                                modals("Student's email should have a minimum of 5 characters and a maximum of 30 characters, and be a valid email address.");
                                markAsInvalid(gmail);
                                isValid = false;
                            } else if (!region_text || region_text.length < 2 || region_text.length > 30) {
                                region_text = document.getElementById('region_text');
                                modals("The region should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(region_text);
                                isValid = false;
                            } else if (!city_text || city_text.length < 2 || city_text.length > 30) {
                                city_text = document.getElementById('city_text');
                                modals("The city should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(city_text);
                                isValid = false;
                            } else if (!province_text || province_text.length < 2 || province_text.length > 30) {
                                city_text = document.getElementById('city_text');
                                modals("The province should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(city_text);
                                isValid = false;
                            } else if (!barangay_text || barangay_text.length < 2 || barangay_text.length > 30) {
                                barangay_text = document.getElementById('barangay_text');
                                modals("The barangay should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(barangay_text);
                                isValid = false;
                            } else if (!house || house.length < 2 || house.length > 30) {
                                house = document.getElementById('house');
                                modals("The house should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(house);
                                isValid = false;
                            } else if (!contact_student || contact_student.length < 5 || contact_student.length > 20 || !contactStudentPattern.test(contact_student)) {
                                contact_student = document.getElementById('contact_student');
                                modals("Student's contact number should be a required number between 5 and 20 characters.");
                                markAsInvalid(contact_student);
                                isValid = false;
                            } else if (!mfirst_name || mfirst_name.length < 2 || mfirst_name.length > 30 || !namePattern.test(mfirst_name)) {
                                mfirst_name = document.getElementById('mfirst_name');
                                modals("Mother's first name should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(mfirst_name);
                                isValid = false;
                            } else if (mmiddle_name && (mmiddle_name.length < 2 || mmiddle_name.length > 30 || !namePattern.test(mmiddle_name))) {
                                mmiddle_name = document.getElementById('mmiddle_name');
                                modals("Mother's middle name should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(mmiddle_name);
                                isValid = false;
                            } else if (!mlast_name || mlast_name.length < 2 || mlast_name.length > 30 || !namePattern.test(mlast_name)) {
                                mlast_name = document.getElementById('mlast_name');
                                modals("Mother's last name should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(mlast_name);
                                isValid = false;
                            } else if (moccupation && (moccupation.length < 2 || moccupation.length > 30 || !namePattern.test(moccupation))) {
                                moccupation = document.getElementById('moccupation');
                                modals("Mother's occupation should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(moccupation);
                                isValid = false;
                            } else if (!ffirst_name || ffirst_name.length < 2 || ffirst_name.length > 30 || !namePattern.test(ffirst_name)) {
                                ffirst_name = document.getElementById('ffirst_name');
                                modals("Father's first name should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(ffirst_name);
                                isValid = false;
                            } else if (fmiddle_name && (fmiddle_name.length < 2 || fmiddle_name.length > 30 || !namePattern.test(fmiddle_name))) {
                                fmiddle_name = document.getElementById('fmiddle_name');
                                modals("Father's middle name should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(fmiddle_name);
                                isValid = false;
                            } else if (!flast_name || flast_name.length < 2 || flast_name.length > 30 || !namePattern.test(flast_name)) {
                                flast_name = document.getElementById('flast_name');
                                modals("Father's last name should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(flast_name);
                                isValid = false;
                            } else if (foccupation && (foccupation.length < 2 || foccupation.length > 30 || !namePattern.test(foccupation))) {
                                foccupation = document.getElementById('foccupation');
                                modals("Father's occupation should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(foccupation);
                                isValid = false;
                            } else if (!efirst_name || efirst_name.length < 2 || efirst_name.length > 30 || !namePattern.test(efirst_name)) {
                                efirst_name = document.getElementById('efirst_name');
                                modals("Guardian's first name should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(efirst_name);
                                isValid = false;
                            } else if (emiddle_name && (emiddle_name.length < 2 || emiddle_name.length > 30 || !namePattern.test(emiddle_name))) {
                                emiddle_name = document.getElementById('emiddle_name');
                                modals("Guardian's middle name should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(emiddle_name);
                                isValid = false;
                            } else if (!elast_name || elast_name.length < 2 || elast_name.length > 30 || !namePattern.test(elast_name)) {
                                elast_name = document.getElementById('elast_name');
                                modals("Guardian's last name should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(elast_name);
                                isValid = false;
                            } else if (!erelation || erelation.length < 2 || erelation.length > 30 || !namePattern.test(erelation)) {
                                erelation = document.getElementById('erelation');
                                modals("Guardian's relation should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(erelation);
                                isValid = false;
                            } else if (!eaddress || eaddress.length < 2 || eaddress.length > 30 || !namePattern.test(eaddress)) {
                                eaddress = document.getElementById('eaddress');
                                modals("Guardian's address should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(eaddress);
                                isValid = false;
                            }


                            if (!elem || elem.length < 2 || elem.length > 30) {
                                elem = document.getElementById('elem');
                                modals("Elementary should have a minimum of 2 characters and a maximum of 30 characters.");
                                markAsInvalid(elem);
                                isValid = false;
                            }

                            if (!elemyr || elemyr.length < 2 || elemyr.length > 30) {
                                elemyr = document.getElementById('yearPicker1');
                                modals("The elementary year of graduation should be between 2 and 30 characters in length.");
                                markAsInvalid(elemyr);
                                isValid = false;
                            }

                            if (highschool != "") {
                                if( highschool.length < 2 || highschool.length > 30){
                                    highschool = document.getElementById('highschool');
                                    modals("High school should have a minimum of 2 characters and a maximum of 30 characters.");
                                    markAsInvalid(highschool);
                                    isValid = false;
                                }
                                
                            }
                            if(highschool != ""){

                                if( highschoolyr.length < 2 || highschoolyr.length > 30){
                                    highschoolyr = document.getElementById('yearPicker');
                                    modals("The high school year of graduation should be between 2 and 30 characters in length.");
                                    markAsInvalid(highschoolyr);
                                    isValid = false;
                                }

                            }

                            if(college != ""){

                                if( college.length < 2 || college.length > 30){
                                    college = document.getElementById('college');
                                    modals("College should have a minimum of 2 characters and a maximum of 30 characters.");
                                    markAsInvalid(college);
                                    isValid = false;
                                }

                            }

                            if(college != ""){

                                if( collegeyr.length < 2 || collegeyr.length > 30){
                                    collegeyr = document.getElementById('yearPicker2');
                                    modals("The College year of graduation should be between 2 and 30 characters in length.");
                                    markAsInvalid(collegeyr);
                                    isValid = false;
                                }

                            }

                            if(college != ""){

                                if( previousCourse.length < 2 || previousCourse.length > 30){
                                    previousCourse = document.getElementById('previous');
                                    modals("Previous course should have a minimum of 2 characters and a maximum of 30 characters.");
                                    markAsInvalid(previousCourse);
                                    isValid = false;
                                }

                            }





                            
                            
                
                            
                            if (isValid) {
                                Swal.fire({
                                    title: '',
                                    text: "Are you sure you want to add this account?",
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, add it!'
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('myForm').submit();
                                    }
                                })
                                
                            }
    



                        
                        
                    }
                    
                    else{
                   
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
@endsection