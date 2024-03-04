@extends('admin.index_admin')



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
            <h1 class="m-0">Create section</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
          <div class="col-12">
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add section to the list</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="card-body">
              <form id="myForm" method="POST" action="{{ route('admin.adding_section') }}" enctype="multipart/form-data">
              @csrf
                <input type="hidden" class="form-control" id="idDept" name="idDept" placeholder="" value="{{$idDept}}">

                
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="employee_no">Academic year<sup class="sup">*</sup></label>
                            <input type="text" readonly class="form-control" value="{{ $yearID }}">
                        </div>
                    </div>
                   
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="last_name">Semester<sup class="sup">*</sup></label>
    
                            <select class="custom-select" id="semester" name="semester">
                        
                              
                            
                                    <option value="1">1st semester</option>
                                    <option value="2">2nd semester</option>
                            </select>
                        </div>
                    </div>
                <div class="col-sm-4">
                    
                    <div class="form-group">
                        <label for="last_name">Academic programs<sup class="sup">*</sup></label>

                        <select class="custom-select" id="track" name="track">
                    
                            <option value="">Select academic programs</option>
                            @foreach($collegeTrack as $depts)
                                <option value="{{$depts->id}}">{{$depts->course}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="employee_no">Section code<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Section code">
                        </div>
                    </div>
                    

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="employee_no">Description</label>
                            <input type="text" class="form-control" id="desc" name="desc" placeholder="Description">
                        </div>
                    </div>

                    <div class="col-sm-4">
                    <div class="form-group">
                        <label for="first_name">Adviser<sup class="sup">*</sup></label>
                        <div  class="dropdown">
                        <input class=" form-control" style="text-align:left;background-color:transparent" type="button" id="dropdownMenuButtons"  value="Choose adviser" readonly data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <input type="hidden" id="adviser" name="adviser">
                        
                        <div class="dropdown-menu "  aria-labelledby="dropdownMenuButtons">
                            <input onkeyup="getvalss(this)" class="form-control searchingSubs" style="" id="searchFills" placeholder="Search" type="text">
                            <div class="habaan" id="preqs">
                                
                            </div>
                        </div>
                        </div>
            
                    </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                                <label for="employee_no">Signature</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" accept=".png" id="image">
                                <label class="custom-file-label" for="image" >Choose signature</label>
                            </div>
                        </div>
                    </div>
                    
                  

                    <script>
                    // Add the following code if you want the name of the file appear on select
                    $(".custom-file-input").on("change", function() {
                    var fileName = $(this).val().split("\\").pop();
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                    });
                    </script>
                        

                    <script>


                        const Descriptionss = [
                            @foreach($teacher as $subjects)
                                '{{$subjects->employee_no}} - {{$subjects->firstname}} {{$subjects->lastname}}',
                            @endforeach
                        ];
                        const DescriptionsIDs = [
                            @foreach($teacher as $subjects)
                                '{{$subjects->id}}',
                            @endforeach
                        ];

                        function validateInput(input) {
                            input.value = input.value.replace(/[^0-9]/g, '').replace(/^-/,'');
                            
                        }
                        function resetss(){
                          
                          var preq = document.getElementById('preqs');

                          // Get all child elements of the parent
                          var childElements = preq.children;

                          
                          for (var i = childElements.length - 1; i >= 0; i--) {
                          
                              if (childElements[i].tagName.toLowerCase() !== 'input') {
                                  
                                  preq.removeChild(childElements[i]);
                                  
                              }
                          }
                      }
                      function changingings(){
                            var dropdownMenuButton =  document.getElementById('dropdownMenuButtons').value = 'Choose adviser';
                            var searchedvalue =  document.getElementById('adviser').value = '';
                        }
                        
                        function changeValueSearcheds(valueGets, vals){
                          
                          var searchedvalue = document.getElementById('adviser');
         
                          searchedvalue.value = valueGets;

                            // alert(searchedvalue.value);

                          var dropdownMenuButton = document.getElementById('dropdownMenuButtons');
                          dropdownMenuButton.value = vals;
                       

                      }
                      function refreshs(){
                                
                                

                       
                                resetss();
                                const searchTerm = '';

                                const find = Descriptionss.filter(fruit => fruit.includes(searchTerm));
                                
                                
                                for(var x = 0; x != find.length; x++){
                                
                                    var preq = document.getElementById('preqs');

                                    const buttonElement = document.createElement('button');
                                    const i = Descriptionss.indexOf(find[x]);
                                    buttonElement.setAttribute('onclick', 'changeValueSearcheds("'+DescriptionsIDs[i]+'", "'+find[x]+'")'); 
                                    buttonElement.setAttribute('value', DescriptionsIDs[i]);
                                    buttonElement.setAttribute('type', 'button');
                                    buttonElement.setAttribute('class', 'dropdown-item');
                                    buttonElement.innerText = find[x];


                                    preq.appendChild(buttonElement);
                                }
                               

                            }
                            refreshs();

                            function getvalss(searching){
                               
                                
                               resetss();
                               

                               const searchTerm = searching.value.toLowerCase(); 
                               const find = Descriptionss.filter(fruit => fruit.toLowerCase().includes(searchTerm)); 
                               
                               for (var x = 0; x < find.length; x++) {
                                   var preq = document.getElementById('preqs');

                                   const buttonElement = document.createElement('button');
                                   const i = Descriptionss.indexOf(find[x]);
                                   buttonElement.setAttribute('onclick', 'changeValueSearcheds("'+DescriptionsIDs[i]+'", "'+find[x]+'")'); 
                                   buttonElement.setAttribute('value', DescriptionsIDs[i]);
                                   buttonElement.setAttribute('type', 'button');
                                   buttonElement.setAttribute('class', 'dropdown-item');
                                   buttonElement.innerText = find[x];


                                   

                                   preq.appendChild(buttonElement);
                               }
                               

                           }
                    </script>
                    
                  
                
              
                </div>

      

                <div class="d-flex gap-flex">
                    <a href="{{ route('admin.section', ['department' => $idDept ,'year' => $yearID ,'semester' => $semesterID ,'course' => $courseID , ]) }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a>
                    <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Add section</button>
                    
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
                    // Function to validate the form

                    function validateForm(){
                        
                        var title = document.getElementById('title').value;
                
                        var idDept = document.getElementById('idDept').value;
                        var track = document.getElementById('track').value;
    

                            jQuery.ajax({
                                    
                                                    
                                    url: "{{ url('admin/checkIftitlesexistSection') }}",
                                    data: {
                         
                                        datacheckTitle: title,
                                        datacheckID: idDept,
                                        trackID: track,
                                       
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
                        const track = document.getElementById("track");
                        
                        const adviser = document.getElementById("adviser");
                     

                        if( title.value != "" && track.value != "" && adviser.value != ""){
                           
                            
                            
                          
                            

                            
                            
                            if (title.value.length > 100 || title.value.length < 1) {
                                markAsInvalid(title);
                                modals("The section code should have a minimum of 5 digits and a maximum of 100 digits.");
                                isValid = false;
                            }
                            else if(emailExists){
                                markAsInvalid(title);
                                modals("Section code already exists.");
                                isValid = false;
                            }
                            else if (desc.value.length > 200) {
                                modals("The description should have a minimum of 5 digits and a maximum of 200 digits.");
                                markAsInvalid(desc);
                                isValid = false;
                            }
                            
                            
                            
                            
                            if (isValid) {
                                Swal.fire({
                                    title: '',
                                    text: "Are you sure you want to add this section?",
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