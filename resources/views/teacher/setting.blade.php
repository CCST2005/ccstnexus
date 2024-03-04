@extends('teacher.index_teacher')



@section('titlePage')

    CCSTNexus | settings

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Settings </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
  <style>
    @media only screen and (max-width: 1468px) {
      .removing{

        display: block;

      }
      .square-image,.sizings{
        width: 100%;
        max-width: 100%;
      }
      .square-container{
        
      }
    }

    @media only screen and (max-width: 450px) {
      
      .square-container{
        height: 100px !important;
                width: 100px !important;
      }
    }
  </style>
    
    <section class="content">
<br>
    <form id="myForm" method="POST" action="{{ route('teacher.updating_teachers', ['id' => $infos->id]) }}" enctype="multipart/form-data">
    @csrf
      <!-- Default box -->
     
      <div class="card">
        <div class="card-body row removing">
          <div class="col-5 d-flex align-items-center justify-content-center sizings" style="">
        
       
               
           
          <style>
              .square-container {
              
                overflow: hidden;
                
                background-position: center;
                background-size:cover;
                @php
                  $links = 'dist/img/profiles/' . $infos->image_file_name;
                @endphp
                background-image: url("{{ asset($links) }}");
                border-radius: 50%;
               
            
                height: 400px;
                width: 400px;
                
                 /* This property ensures the image retains its aspect ratio within the container */
              border-radius: 50%;
              }
              .square-containerf{
                
                padding: 6px;
                border-radius: 50%;
                border: 3px solid;
              }
           

            
            </style>

              <!-- HTML code -->
              <div class="square-containerf">
                <input type="hidden" name="imaging" value="{{$infos->image_file_name}}">
                <div class="square-container" id="okaysdf" onclick="triggerFileInput()">
                  <img style="opacity:0" id="profileImage" src="{{ asset($links) }}" class="square-image img-fluid mb-2" alt="white sample">
                </div>
              </div>
              <input type="file" id="fileInput" style="display: none;" onchange="displayImagePreview()" name="image" accept=" .jpg, .jpeg">

              <script>
                // JavaScript code
                function triggerFileInput() {
                  document.getElementById('fileInput').click();
                }

              function displayImagePreview() {
                var input = document.getElementById('fileInput');
                var image = document.getElementById('profileImage');
                var okaysdf = document.getElementById('okaysdf');

                if (input.files && input.files[0]) {
                  var reader = new FileReader();

                  reader.onload = function (e) {
                    image.src = e.target.result;
                    okaysdf.style.backgroundImage = 'url(' + e.target.result + ')';
                  };

                  reader.readAsDataURL(input.files[0]);
                }
              }
            </script>                   
            
       

          </div>
     
          <div style="margin-top: 20px" class="col-7 sizings">
          <div class="col-sm-6 sizings">
            <div class="form-group">
              <label for="">Employee no.</label>
              <input type="text" id="inputSubjecst" id="" readonly class="form-control" value="{{$infos->employee_no}}">
            </div>
         
            <div class="form-group">
              <label for="inputName">First name</label>
              <input type="text" id="first_name" class="form-control" name="first_name" placeholder="First name" value="{{$infos->firstname}}">
            </div>
            <div class="form-group">
              <label for="">Middle name</label>
              <input type="email" id="middle_name" class="form-control" name="middle_name" placeholder="Middle name" value="{{$infos->middlename}}" >
            </div>
            <div class="form-group">
              <label for="">Last name</label>
              <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last name" value="{{$infos->lastname}}">
            </div>
            <div class="form-group">
              <label>Sex</label>
              <select name="sex"  class="form-control">
                <option @if($infos->sex == 'm') {{ 'selected' }} @endif value="m">Male</option>
                <option @if($infos->sex == 'f') {{ 'selected' }} @endif value="f">Female</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Gmail</label>
              <input type="text" id="gmail" class="form-control" name="gmail" placeholder="Gmail" value="{{$infos->email}}">
            </div>

       
             
         
            <div class="form-group">
              <label for="">Change password</label>
              <input type="password" id="password" oninput="UnhideCon()" name="password" class="form-control" placeholder="••••••••••••">
            </div>
            <div class="form-group" id="hidingConfirm" style="display:none">
              <label for="">Comfirm password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="••••••••••••">
              </div>
              <div class="form-group">
                <input type="button" class="btn btn-primary" value="Save update" onclick="validateForm()">
              </div>
            </div>
          </div>
          <script>
              function UnhideCon(){
                var hidingConfirm = document.getElementById("hidingConfirm");
                var password = document.getElementById("password");

                if(password.value.length != 0){
                  hidingConfirm.style.display = "block";
                }
                else{
                  hidingConfirm.style.display = "none";
                }
                
              }
            </script>
          <script>
                     
                      


                  
                     const gmail = document.getElementById("gmail");
            
                    var employeeExist = false;
                        
                    var emailExist = false;
                    var UsernameExist = false;
                    var isValid = true;
                    // Function to validate the form

                    function validateForm(){
                       

                      jQuery.ajax({
                                    
                                                    
                                    url: "{{ url('teacher/checkIfTeacherExist') }}",
                                    data: {
                                
                                        datacheckgmail: gmail.value,
                                    },
                                    type: 'post',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },

                                    success:function(result)
                                    {
                                        

                                        
                                        emailExist = result.email;
                                        
                                        validateForm_second();
                                    
                                    }

                                
                                });
            
                        


                        
                    }

                    
                    
                    function validateForm_second() {
                        

                        var id_admin = '{{ $infos->id }}';
                        var messageHtml = 'Your password';
                        
                        var pattern = /^[0-9-]+$/;
                        isValid = true;
                     

                        // Reset borders and error messages
                        resetValidation();

                        // Validation for First Name, Middle Name, and Last Name


                        // Validation for Email
                      
                        const gmail = document.getElementById("gmail");
                        // Validation for Password and Confirm Password
                        const password = document.getElementById("password");
                        const confirmPassword = document.getElementById("confirm_password");

                        const input = document.getElementById('first_name');
                        const value = input.value.trim();

                        const input1 = document.getElementById('middle_name');
                        const value1 = input1.value.trim();

                        const input2 = document.getElementById('last_name');
                        const value2 = input2.value.trim();
               

                        
                        var currentGmail = '{{ $infos->email }}';
 
                       



                        if(gmail != "" && value != "" && value2 != "" ){
                           
                            
                            
                          
                            

                            
                            
                          
                          
                            
                        if (value.length < 2 || value.length > 100 || !/^[A-Za-zñÑ\s]+$/.test(value)) {
                                markAsInvalid(input);
                                modals("The first name should have a minimum of 5 characters and a maximum of 100 characters.");
                                isValid = false;
                            }
                            else if ((value1.length > 100 || !/^[A-Za-zñÑ\s]+$/.test(value1)) && (value1.length != "")) {
                                markAsInvalid(input1);
                                modals("The middle name should have a minimum of 5 characters and a maximum of 100 characters.");
                                isValid = false;
                            }
                            else if (value2.length < 2 || value2.length > 100 || !/^[A-Za-zñÑ\s]+$/.test(value2)) {
                                markAsInvalid(input2);
                                modals("The last name should have a minimum of 5 characters and a maximum of 100 characters.");
                                isValid = false;
                            }
                       
                            
                            else if ((password.value.length < 8 || password.value.length > 30) && password.value.trim() != "") {
                                markAsInvalid(password);
                                
                                modals("The password should have a minimum of 8 characters and a maximum of 30 characters.");
                                isValid = false;
                            }
                            else if(password.value !== confirmPassword.value){
                                markAsInvalid(password);
                                markAsInvalid(confirmPassword);
                                modals("Password not matched.");
                                isValid = false;
                            }
                         
                        

                          else if(emailExist && gmail.value != currentGmail){
                                markAsInvalid(gmail);
                                modals("Email already exists.");
                                isValid = false;
                            }
                            
                            if (isValid) {

                                deleting_admin(id_admin, messageHtml);
                                $(function () {
                                    $('[data-toggle="tooltip"]').tooltip()
                                    })
                                        function deleting_admin(id_admin, messageHtml)
                                        {
                                            var trues = "";
                                            
                                        (async () => {
                                        


                                                const { value: password } = await Swal.fire({
                                                title: 'Enter your password',
                                                input: 'password',
                                                html: '<b>' + messageHtml + '</b>',
                                                confirmButtonText: "Continue",
                                                inputPlaceholder: 'Enter your password',
                                                inputAttributes: {
                                                    maxlength: 30,
                                                    autocapitalize: 'off',
                                                    autocorrect: 'off',
                                                    
                                                }
                                                })

                                                if (password) {
                                                
                                                // Swal.fire(`Entered password: ${password}`);
                                                jQuery.ajax({
                                                
                                                
                                                    url: "{{ url('teacher/checkpassword') }}",
                                                    data: {
                                                        password: password,
                                                    },
                                                    type: 'post',
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },

                                                    success:function(result)
                                                    {
                                                        
                                                    trues = result.password;
                                                    id = id_admin;
                                                    checkingTrues(trues, id);
                                                    }

                                            
                                                });
                                                
                                                
                                                }
                                                
                                            
                                        })()
                                        
                                        }
                                        function checkingTrues(password, id){
                                        
                                        if(password != 'false'){
                                            document.getElementById('myForm').submit();
                                        }
                                        else{
                                            deleting_admin(id, '<span style="color:rgb(165, 73, 73)">Wrong password.</span>');
                                        }
                                    }

                                
                                
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
                    }

                    
                    function validateInput(input) {
                        input.value = input.value.replace(/[^0-9-]/g, '');
                        document.getElementById("email").value = input.value;
                    }

                    
                    
                </script>
        </div>
      </div>
      </form>
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
@endsection