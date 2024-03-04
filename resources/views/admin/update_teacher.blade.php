@extends('admin.index_admin')




@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit teacher</h1>
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
                <h3 class="card-title">Edit {{ (empty($finding_user_acc->firstname)) ? 'N/A' : $finding_user_acc->firstname }}'s information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="card-body">
              <form id="myForm" method="POST" action="{{ route('admin.updating_teacher', ['id' => $finding_user_acc->id]) }}">
              @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="employee_no">Employee no.<sup class="sup">*</sup></label>
                            <input type="text" onkeyup="validateInput(this)" class="form-control" id="employee_no" name="employee_no" placeholder="Employee no." value="{{ (empty($finding_user_acc->employee_no)) ? 'N/A' : $finding_user_acc->employee_no }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="first_name">First name<sup class="sup">*</sup></label>

                            <input type="text" class="form-control"  id="first_name" name="first_name" placeholder="First name" value="{{ (empty($finding_user_acc->firstname)) ? 'N/A' : $finding_user_acc->firstname }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="middle_name">Middle name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="{{ (empty($finding_user_acc->middlename)) ? 'N/A' : $finding_user_acc->middlename }}" value="{{ $finding_user_acc->middlename }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="last_name">Last name<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" value="{{ (empty($finding_user_acc->lastname)) ? 'N/A' : $finding_user_acc->lastname }}">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                        <label>Sex<sup class="sup">*</sup></label>
                        <select name="sex"  class="form-control">
                          <option @if($finding_user_acc->sex == 'm') {{ 'selected' }} @endif value="m">Male</option>
                          <option @if($finding_user_acc->sex == 'f') {{ 'selected' }} @endif value="f">Female</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                    <div class="form-group">
                            <label for="gmail">Email<sup class="sup">*</sup></label>
                            <input type="email" class="form-control" id="gmail" name="gmail"  placeholder="Email" value="{{ (empty($finding_user_acc->email)) ? 'N/A' : $finding_user_acc->email }}">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="email">Username<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="email" name="email"  placeholder="username" value="{{ $finding_user_acc->username }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="password">New password<sup class="sup">*</sup></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="confirm_password">Confirm password<sup class="sup">*</sup></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password">
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-flex">
                    <a href="{{ route('admin.teacher') }}"><button type="button" class="btn bg-gradient-secondary" id="submit_buttons" onclick="">Back</button></a>
                    <button type="button" class="btn bg-gradient-success" id="submit_button" onclick="validateForm()">Update account</button>
                    
                </div>
            </form>
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
                     
                      


                  
                    
            
                    var employeeExist = false;
                        
                    var emailExist = false;
                    var UsernameExist = false;
                    var isValid = true;
                    // Function to validate the form

                    function validateForm(){
                        const email = document.getElementById("email");
                        const employee = document.getElementById('employee_no');
                        const employees = employee.value.replace(/[^0-9-]/g, '').trim();
                        const gmail = document.getElementById("gmail");

    

                        jQuery.ajax({
                                    
                                                    
                                    url: "{{ url('admin/checkIfTeacherExist') }}",
                                    data: {

                                


                                        datacheckEmployeeNo: employees,
                                        datacheckEmail: email.value,
                                        datacheckgmail: gmail.value,
                                    },
                                    type: 'post',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },

                                    success:function(result)
                                    {
                                        

                                        employeeExist = result.employeeNo;
                                        UsernameExist = result.username;
                                        emailExist = result.email;
                                        
                                        validateForm_second();
                                    
                                    }

                                
                                });


                        
                    }

                    
                    
                    function validateForm_second() {
                        

                        var id_admin = '{{ $finding_user_acc->id }}';
                        var messageHtml = 'Admin password';
                        
                        var pattern = /^[0-9-]+$/;
                        isValid = true;
                     

                        // Reset borders and error messages
                        resetValidation();

                        // Validation for First Name, Middle Name, and Last Name


                        // Validation for Email
                        const email = document.getElementById("email");
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
                        const employee = document.getElementById('employee_no');
                        const employees = employee.value;

                        var currentEmployeeNo = '{{ $finding_user_acc->employee_no }}';
                        var currentGmail = '{{ $finding_user_acc->email }}';
                        var currentUsername = '{{ $finding_user_acc->username }}';
                        



                        if(gmail.value != "" && employees != "" && value != "" && value2 != "" && email.value != "" ){
                           
                            
                            
                          
                            

                            
                            
                            if (!pattern.test(employees)) {
                                markAsInvalid(employee);
                                modals("The employee number must consist of numbers only. ");
                                isValid = false;
                            }
                            else if (employees.length > 20 || employees.length < 5) {
                                modals("The employee number should have a minimum of 5 digits and a maximum of 20 digits.");
                                markAsInvalid(employee);
                                isValid = false;
                            }
                            
                            else if (value.length < 2 || value.length > 70 || !/^[A-Za-zñÑ\s]+$/.test(value)) {
                                markAsInvalid(input);
                                modals("The first name should have a minimum of 5 characters and a maximum of 70 characters.");
                                isValid = false;
                            }
                            else if ((value1.length < 2 || value1.length > 70 || !/^[A-Za-zñÑ\s]+$/.test(value1)) && (value1.length != "")) {
                                markAsInvalid(input1);
                                modals("The middle name should have a minimum of 5 characters and a maximum of 70 characters.");
                                isValid = false;
                            }
                            else if (value2.length < 2 || value2.length > 70 || !/^[A-Za-zñÑ\s]+$/.test(value2)) {
                                markAsInvalid(input2);
                                modals("The last name should have a minimum of 5 characters and a maximum of 70 characters.");
                                isValid = false;
                            }
                            else if (email.value.length > 70 || email.value.length < 5) {
                                markAsInvalid(email);
                                modals("The username should have a minimum of 5 characters and a maximum of 70 characters.");
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
                            else if(employeeExist && employees != currentEmployeeNo){
                                markAsInvalid(employee);
                                modals("Employee number already exists.");
                                isValid = false;
                            }
                            else if(UsernameExist && email != currentUsername){
                                markAsInvalid(email);
                                modals("Username already exists.");
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
                                                
                                                
                                                    url: "{{ url('admin/checkpassword') }}",
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
  <script>
    new MultiSelectTag('roles')  
  
  </script>
@endsection