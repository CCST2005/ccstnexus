@extends('teacher.index_teacher')



@section('titlePage')

    CCSTNexus | add section

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add student</h1>
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
             
                <h3 class="card-title">Add student to your section</h3>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              
              <div class="" style="display:none" id="disable&delete" >
              <div><span style="opacity:80%">Selected student: <span id="countSelected"></span></span></div>
              <h3 class="card-title">Add student to your section</h3>
            </div>
              
                  
                 
              <form id="myForm" method="get" action="{{ route('teacher.check_section_student') }}">
              @csrf
              
              <input type="text" readonly id="sections" name="sections" value="{{ $section }}">
            <input type="text" readonly id="track" name="track" value="{{ $track }}">
            <input type="text" readonly id="subject" name="subject" value="{{ $subject }}">
               

              <table id="example3" class="table-bordered table table-bordered table-striped">
                
                <thead>
                <tr>
                  <th style="width: 2%"></th>
                  
                  <th>Student no.</th>
                  <!-- <th>Email</th> -->
                  <th>Full name</th>
                  
                  <th>Sex</th>
                  <th>Birthday</th>
                  
                  
                  
          
                </tr>
                </thead>
                <tbody>
                
                @foreach($students as $data)
                
                 
                  
                  <tr >
                  
                      <td><input type="checkbox" name="checkboxes[]" onclick="updateCount(this)" value="{{ $data->id }}"></td>
                      <td>{{ $data->student_no }}</td>
                      <td>{{ $data->firstname }} {{ $data->middlename }} {{ $data->lastname }}</td>
                      <td>{{ $data->sex }}</td>

                      <td>{{ $data->birth_month }}-{{ $data->birth_day }}-{{ $data->birth_year }}</td>
                  
                      
                      
                      
                  
          
                  </tr>
             
                @endforeach
                </tbody>
              
              <tfoot>
           
              </tfoot>
            </table>
            
            

                <div class="d-flex gap-flex">
                    
                    <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Continue</button>
                    
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
                    var totalChecked = 0;
                    function updateCount(checkbox) {
                      var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                      var totalCheckedElement = document.getElementById('totalChecked');
                      
                      var totalChecked = Array.from(checkboxes).filter(function (c) {
                          return c.checked;
                      }).length;

                      if(totalChecked != 0){
                        var hide = document.getElementById('disable&delete');
                        hide.style = "display: ";
                        var counts = document.getElementById('countSelected').innerHTML = totalChecked;

                      }
                      else{
                        var hide = document.getElementById('disable&delete');
                        hide.style = "display: none";
                      }

                    

                    
                  }
                


                  
                    
            
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
                        
                       
                        const subject = document.getElementById("subject");
                        const track = document.getElementById("track");
                        const section = document.getElementById("sections");
                        

                     

                        if( totalChecked != 0 &&  track.value != "" && subject.value != "" && section.value != ""){
                        
                                        document.getElementById('myForm').submit();
                                 
                                
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