@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | edit department

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit department</h1>
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
                <h3 class="card-title">Update department ({{$existingEmployee->title}})</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="card-body">
              <form id="myForm" method="POST" action="{{ route('admin.updating_department', ['id' => $existingEmployee->id]) }}">
              @csrf
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="employee_no">Title<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{$existingEmployee->title}}" placeholder="Title">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="first_name">Description<sup class="sup"></sup></label>
                            <input type="text" class="form-control" id="desc"  name="desc"  value="{{$existingEmployee->description}}" placeholder="Description">
                        </div>
                    </div>

                   
                  
                
              
                </div>

      

                <div class="d-flex gap-flex">
                    <a href="{{ route('admin.departments') }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a>
                    <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Add department</button>
                    
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
                        
                    var emailExists = false;
                    var isValid = true;
                    var currentTitle = '{{$existingEmployee->title}}';
                    // Function to validate the form

                    function validateForm(){
                        
                        var title = document.getElementById('title').value;
                        const desc = document.getElementById("desc").value;
              

    

                            jQuery.ajax({
                                    
                                                    
                                    url: "{{ url('admin/checkIftitlesexist') }}",
                                    data: {
                         
                                        datacheckTitle: title,
                                       
                                    },
                                    type: 'post',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },

                                    success:function(result)
                                    {
                                        

                                       
                                        emailExists = result.title;
                          
                                        validateForm_second();
                                    
                                    }

                                
                                });


                        
                    }

                    
                    
                    function validateForm_second() {
                        
                        isValid = true;

                        // Reset borders and error messages
                        resetValidation();

                        // Validation for First Name, Middle Name, and Last Name


                        // Validation for Email
                        const title = document.getElementById("title");
                        const desc = document.getElementById("desc");

                        

                     

                        if( title.value != "" ){
                           
                            
                            
                          
                            

                            
                            
                            if (title.value.length > 100 || title.value.length < 1) {
                                markAsInvalid(title);
                                modals("The title should have a minimum of 5 digits and a maximum of 100 digits.");
                                isValid = false;
                            }
                            else if(emailExists && currentTitle != title.value){
                                markAsInvalid(title);
                                modals("Department title already exists.");
                                isValid = false;
                            }
                            else if (desc.value.length > 200) {
                                modals("The description should have a minimum of 5 digits and a maximum of 200 digits.");
                                markAsInvalid(desc);
                                isValid = false;
                            }
                            
                            
                            
                            if (isValid) {
                            var id_admin = '{{ $existingEmployee->id }}';
                            var messageHtml = 'Admin password.';
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

  
@endsection