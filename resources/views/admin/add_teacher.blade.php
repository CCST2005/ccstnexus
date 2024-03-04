@extends('admin.index_admin')


@section('titlePage')

    CCSTNexus | add teacher

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
                <h3 class="card-title">Add teacher account</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="card-body">
              <form id="myForm" method="POST" action="{{ route('admin.adding_teacher') }}">
              @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="employee_no">Employee no.<sup class="sup">*</sup></label>
                            <input type="text" onkeyup="validateInput(this)" class="form-control" id="employee_no" name="employee_no" placeholder="Employee no.">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="first_name">First name<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="first_name" onchange="changeNameselect()" onkeypress="changeNameselect()" name="first_name" placeholder="First name">
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
                    <div class="col-sm-2">
                        <div class="form-group">
                        <label>Sex<sup class="sup">*</sup></label>
                        <select name="sex" class="form-control">
                          <option value="m">Male</option>
                          <option value="f">Female</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="gmail">Email<sup class="sup">*</sup></label>
                            <input type="email" class="form-control" id="gmail" name="gmail"  placeholder="Email">
                        </div>
                    </div>
                   
                    <!-- <div class="col-sm-4">
                        <div class="form-group">
                            <label for="roles">What can <span id="label_roles">this user</span> do?<sup class="sup">*</sup></label>
                            <select class="tags_input" name="roles[]" id="roles" multiple>

                            {{-- @foreach($rolesListForregistrar as $roles)--}}
                                {{--<option value="{{$roles->role}}">{{$roles->role}}</option>--}}
                                {{-- @endforeach--}}
                            </select>
                        </div>
                    </div> -->
                
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="email">Username<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="email" readonly name="email"  placeholder="username">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="password">Password<sup class="sup">*</sup></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
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
                    <a href="{{ route('admin.teacher') }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a>
                    <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Add account</button>
                    
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
                    
                    function changeNameselect(){
                        // const input = document.getElementById('first_name');
                        // const value = input.value.trim();
                        // var label = document.getElementById('label_roles');
                        // if(value !== ""){
                        //     label.innerHTML = value;
                        // }
                        // else{
                        //     label.innerHTML = "this user";
                        // }

                    }
                


                  
                    
            
                    var employeeExist = false;
                        
                    var emailExist = false;
                    var UsernameExist = false;
                    var isValid = true;
                    // Function to validate the form

                    function validateForm(){
                        // var selectElement = document.getElementById('roles');
                        // var selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
            
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
                        // var selectElement = document.getElementById('roles');
                        // var selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
                        
                        var pattern = /^[0-9-]+$/;
                        isValid = true;
                     

                        // Reset borders and error messages
                        resetValidation();

                        // Validation for First Name, Middle Name, and Last Name


                        // Validation for Email
                        const email = document.getElementById("email");


                        const gmail = document.getElementById("gmail");
                        const gmails = gmail.value.trim();
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
                        

                     

                        if(gmails != "" && employees != "" && value != "" && value2 != "" && email.value != "" && password.value != "" && confirmPassword.value != ""){
                           
                            
                            
                          
                            

                            
                            
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
                            
                            else if (password.value.length < 8 || password.value.length > 30) {
                                markAsInvalid(password);
                                
                                modals("The password should have a minimum of 8 characters and a maximum of 70 characters.");
                                isValid = false;
                            }
                            else if(password.value !== confirmPassword.value){
                                markAsInvalid(password);
                                markAsInvalid(confirmPassword);
                                modals("Password not matched.");
                                isValid = false;
                            }
                            else if(employeeExist){
                                markAsInvalid(employee);
                                modals("Employee number already exists.");
                                isValid = false;
                            }
                            else if(UsernameExist){
                                markAsInvalid(email);
                                modals("Username already exists.");
                                isValid = false;
                            }

                          else if(emailExist){
                                markAsInvalid(gmail);
                                modals("Email already exists.");
                                isValid = false;
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
    // new MultiSelectTag('roles')  
  
  </script>
  
@endsection