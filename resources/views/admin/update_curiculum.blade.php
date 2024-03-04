@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | Edit curriculum

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit curriculum</h1>
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
                <h3 class="card-title">Update {{$curiculums->title}}</h3>
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
              <div class="card-body">
              <form id="myForm" method="POST" action="{{ route('admin.updating_curriculum', ['id' => $curiculums->id]) }}">
              @csrf
                
                <div class="row">
                    
                
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="employee_no">Title<sup class="sup">*</sup></label>
                            <input type="text" readonly class="form-control" id="title" value="{{$curiculums->title}}"  name="title" placeholder="Title">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="first_name">Description<sup class="sup"></sup></label>
                            <input type="text" class="form-control" id="desc" value="{{$curiculums->desc}}" name="desc" placeholder="Description">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="first_name">Academic year<sup class="sup">*</sup></label>
                            <input type="text" style="background-color:transparent" readonly class="form-control" id="year"  name="year" value="{{$curiculums->acadYr}}" placeholder="Academic year">
                        </div>
                    </div>

                    

                    
                    
                    

                   
                  
                
              
                </div>

      

                <div class="d-flex gap-flex">
                    
                    <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Update</button>
                    
                </div>
            </form>
                @if (session('success'))
                    <script>
                        $(document).ready(function () {
                            
                            
                                Swal.fire({
                                   
                                    title: "{{ session('success')['title'] }}",
                                    icon: "{{ session('success')['icon'] }}",
                                   
                                });
                            
                        });
                    </script>
                @endif
           
                <script>
                    
              
                


                  
                    
            
                    var employeeExist = false;
                    var currentTitles = '{{$curiculums->title}}';
                    var emailExists = false;
                    var isValid = true;
                    // Function to validate the form

                    function validateForm(){
                       
                        var title = document.getElementById('title').value;
                        const desc = document.getElementById("desc").value;
              

    

                            jQuery.ajax({
                                    
                                                    
                                    url: "{{ url('admin/checkIftitlesexistCurriculumCollege') }}",
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
          
                        var title = document.getElementById('title').value.trim();
                        var desc = document.getElementById('desc').value.trim();
             
                        if( title !== ""  ){


                            if(!title || title.length < 2 || title.length > 100){
                                modals("Subject title should have a minimum of 2 characters and a maximum of 100 characters.");
                                markAsInvalid(document.getElementById('title'));
                                isValid = false;
                            }

                         
                           

                            else if(emailExists && currentTitles != title){
                                modals("Title already exists.");
                                markAsInvalid(document.getElementById('title'));
                                isValid = false;
                            }
                        
                            
                                

                            
                            
                            
                            if (isValid) {
                            var id_admin = '{{ $curiculums->id }}';
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
              
              <!-- /.card-body -->
              <br>
              <div class="card-header">
                <h3 class="card-title">Subjects</h3>
              </div>
              <div class="card-body">
                <table id="example3" class="maxheight table-bordered table table-bordered table-striped">
                
                    <thead>
                    <tr>
                     
                      <th>Subject code</th>
                      <th>Title</th>
                      <!-- <th>Email</th> -->
                      
    
                  
                      
                      
              
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($subjectss as $data)
                  
                      <tr>
                      
                         
                          
                          <td>{{ $data['sub_code'] }}</td>
                          <td>{{ $data['title'] }}</td>
                          
                     
                  
                          
                          
                      
              
                      </tr>
                 
                    @endforeach
                    </tbody>
                  
                  <tfoot>
               
                  </tfoot>
                </table>
                <div class="d-flex gap-flex" style="padding-top:10px">
                <a href="{{ route('admin.editCourseCurriculum', ['id' => $previous, 'year' => $acadsNewVar]) }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a>
                    <a href="{{ route('admin.edit_subject_curriculum', ['id' => $curiculums->id, 'previous' => $previousID,  'courseID' => $courseID, 'year' =>  $acadsNewVar]) }}"><button type="button" class="btn bg-gradient-success" id="submit_button" onclick="">Edit subjects</button></a>
                    
                    
                </div>
              </div>
              </div>
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