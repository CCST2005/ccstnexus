@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | add college curriculum

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create College curriculum</h1>
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
                <h3 class="card-title">Add curriculum to the list</h3>
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
              <form id="myForm" method="POST" action="{{ route('admin.adding_college_curriculum') }}">
              @csrf
                <div class="row">
                    
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="employee_no">Course<sup class="sup">*</sup></label>
                            <select id="course" name="course" onchange="changeTItle()" class="form-control  ">
                                    @foreach($courseComplete as $cours)
                                        <option value="{{ $cours['id'] }}">{{ $cours['course'] }}</option>
                                    @endforeach
                            </select>

                            <script>
                               
                                var titles = {
                                    @foreach($courseComplete as $cours)
                                        @php 
                                            $id = $cours['id'];
                                            $title = $cours['semester'];
                                        @endphp
                                        "{{$id}}": "{{$title}}",
                                    @endforeach
                                };

                                var yearsing = {
                                    @foreach($courseComplete as $cours)
                                        @php 
                                            $id = $cours['id'];
                                            $year = $cours['year'];
                                        @endphp
                                        "{{$id}}": "{{$year}}",
                                    @endforeach
                                };


                                var titling = {
                                    @foreach($courseComplete as $cours)
                                        @php 
                                            $id = $cours['id'];
                                            $titling = $cours['course'];
                                        @endphp
                                        "{{$id}}": "{{$titling}}",
                                    @endforeach
                                };



                                var checkings = {
                                    @foreach($courseComplete as $cours)
                                        @php 
                                            $id = $cours['id'];
                                            $check = $cours['check'];
                                        @endphp
                                        "{{$id}}": "{{$check}}",
                                    @endforeach
                                };

                                
                            </script>
                            
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="employee_no" id="trying_id">Title<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="title" readonly name="title" placeholder="Title">
                        </div>
                    </div>
                    <input type="hidden" id="courseCurrent" name="courseCurrent">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="first_name">Description<sup class="sup"></sup></label>
                            <input type="text" class="form-control" id="desc"  name="desc" placeholder="Description">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="first_name">Academic year<sup class="sup">*</sup></label>
                            <input type="text" style="background-color:transparent" readonly class="form-control" id="year"  name="year" value="{{ $cours['year'] }}" placeholder="Academic year">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="first_name" id="cannot">You cannot add more curriculum to this course due to its year length. Here is the link for modifications. <a href="" id="linkModify"></a></label>
                            
                        </div>
                    </div>

                    

                    
                   
                    
                                <script>
                                     @foreach($courseComplete as $cours)
                                       @if($cours['check'] == 'non')

                                       Swal.fire({
                                            title: "Opps!",
                                            text: "No courses available for the academic year {{ $cours['year'] }}.",
                                            icon: "error",
                                            allowOutsideClick: false,
                                            showCancelButton: false,
                                            confirmButtonText: 'Back',
                                            
                                            }).then((result) => {
                                            if (result.isConfirmed) {
                                                var newPageURL = "{{ route('admin.College_curriculum') }}";

                                                window.location.href = newPageURL;
                                            }
                                        });

                                       @endif
                                    @endforeach
                                    
                                </script>
                   
                  
                
              
                </div>

      

                <div class="d-flex gap-flex">
                    <a href="{{ route('admin.College_curriculum', ['year' => $acadsNewVar]) }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a>
                    <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Add curriculum</button>
                    
                </div>

                <script>
                         @if (session('success'))
                            var id = document.getElementById("course");     
                            id.value = "{{ session('success')['courseCurrent'] }}";
                          
                         @endif
                        function changeTItle(){
                                    var title = document.getElementById("title");
                                    var courseCurrent = document.getElementById("courseCurrent");
                                    var id = document.getElementById("course").value;
                                    
                                    var year = document.getElementById("year");
                                    
                                    
                                    title.value = titles[id];
                                    year.value = yearsing[id];
                                    courseCurrent.value = id;
                                    checkingLims();
                    
                                
                                }
                                changeTItle();

                                

                            function checkingLims(){
                                var id = document.getElementById("course").value;
                                var add_curs = document.getElementById("submit_buttons");
                                var trying_id = document.getElementById("trying_id");
                                var cannot = document.getElementById("cannot");
                                var linkModify = document.getElementById("linkModify");

                                if(checkings[id] == 1){
                                    add_curs.disabled = true;

                                    cannot.style.display = "block";
                                    linkModify.href = "editCourseCurriculum/"+id;
                                    linkModify.innerHTML = titling[id];
                                }
                                else{
                                    add_curs.disabled = false;
                                    cannot.style.display = "none";
                                    linkModify.href = "";
                                }
                          
                            }
                           
                                    
                               
                    </script>
            </form>
            @if (session('success'))
                    <script>
                        $(document).ready(function () {
                            
                            
                                Swal.fire({
                                    title: "{{ session('success')['title'] }}",
                                    text: "{{ session('success')['text'] }}",
                                    icon: "{{ session('success')['icon'] }}",
                                    
                                });
                            
                        });
                    </script>
                @endif
           
                <script>
                    
              
                


                  
                    
            
                    var employeeExist = false;
                        
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

                         
                           

                            else if(emailExists){
                                modals("Title already exists.");
                                markAsInvalid(document.getElementById('title'));
                                isValid = false;
                            }
                        
                            
                                

                            
                            
                            
                            if (isValid) {
                                Swal.fire({
                                    title: '',
                                    text: "Are you sure you want to add this department?",
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

  
@endsection