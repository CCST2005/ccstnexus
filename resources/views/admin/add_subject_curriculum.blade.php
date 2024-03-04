@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | add subject 

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add subject to {{$curiculumn->title}}</h1>
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
                <h3 class="card-title">Choose what subject to add</h3>
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
              <form id="myForm" method="POST" action="{{ route('admin.adding_subject_curriculum') }}">
              @csrf
                <div class="row">
                    
                   
                            
                <input type="hidden" class="" id="id" value="{{ $curiculumn->id }}" name="id">
                  
                    
                

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="roles">Subjects<sup class="sup">*</sup></label>
                        <select class="tags_input" name="roles[]" id="roles" multiple>
                            @php
                                $selected = "";
                            @endphp
                        
                            @foreach($subjects as $roles)
                                {{$selected = "";}}
                                @foreach($roles_registrar as $roles_registrarr)
                                    @if($roles_registrarr->sub_code == $roles->id)
                                        
                                        {{$selected = "selected";}}
                                    @endif
                                @endforeach
                                <option value="{{ $roles->id }}" {{$selected}} >{{$roles->title}} - {{$roles->sub_code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <script>
                    new MultiSelectTag('roles')  
                
                </script>
                    

                    
                    
                    

                   
                  
                
              
                </div>

      

                <div class="d-flex gap-flex">
                    <a href="{{ route('admin.College_curriculum') }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a>
                    <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Confirm</button>
                    
                </div>
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
                       
                        
                          
                                        validateForm_second();
                                    
                               


                        
                    }

                    
                    
                    function validateForm_second() {
                        
                        isValid = true;

                        // Reset borders and error messages
                        resetValidation();

                        // Validation for First Name, Middle Name, and Last Name


                        // Validation for Email
          
                        var selectElement = document.getElementById('roles');
                        var selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
                  
             
                        if( selectedValues != ""  ){

                            
                            
                        
                            
                                

                            
                            
                            
                            if (isValid) {
                                Swal.fire({
                                    title: '',
                                    text: "Are you sure you want to add this subject/s?",
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