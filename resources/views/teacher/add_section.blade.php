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
            <h1 class="m-0">Add your section </h1>
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
                <h3 class="card-title"  style="display:flex; justify-content:space-between; width: 100%"><span>Add your section to the list</span> <span>S.Y. {{$acads}}</span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="card-body">
              <form id="myForm" method="GET" action="{{ route('teacher.add_section_student') }}" enctype="multipart/form-data">
              @csrf
              
                <div class="row">

                    

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="last_name">Academic program<sup class="sup">*</sup></label>

                            <select  class="custom-select" onchange="fill_subs_(this);fill_strand(this);changinging();" id="track" name="track">
                        
                                <option value="">Select academic program</option>
                                @foreach($track as $depts)
                                    <option  value="{{$depts->id}}">{{$depts->course}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                   
                    <div class="col-sm-2">
                    <div class="form-group">
                        <label for="first_name">Section<sup class="sup">*</sup></label>
                        <div  class="dropdown">
                        <input class=" form-control" style="text-align:left;background-color:transparent" type="button" id="dropdownMenuButton"  value="Choose section" readonly data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     
                        <input type="hidden" id="searchedvalue" name="sections">
                        
                        <div class="dropdown-menu" id="" aria-labelledby="dropdownMenuButton">
                            <input onkeyup="getvals(this)" class="form-control searchingSubs" style="" id="searchFill" placeholder="Search" type="text">
                            <div class="habaan" id="preq">
                                
                            </div>
                        </div>
                        </div>
            
                    </div>
                    </div>


                    <div class="col-sm-4">
                    <div class="form-group">
                        <label for="first_name">Subject<sup class="sup">*</sup></label>
                        <div  class="dropdown">
                        <input class=" form-control" style="text-align:left;background-color:transparent" type="button" id="dropdownMenuButtons"  value="Choose Subject" readonly data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <input type="hidden" id="subject" name="subject">
                        
                        <div class="dropdown-menu "  aria-labelledby="dropdownMenuButtons">
                            <input onkeyup="getvalss(this)" class="form-control searchingSubs" style="" id="searchFills" placeholder="Search" type="text">
                            <div class="habaan" id="preqs">
                                
                            </div>
                        </div>
                        </div>
            
                    </div>
                    </div>
                    <span id="readEcam"></span>
                    
                    <!-- <div class="col-sm-4">
                        <div class="form-group">
                            <label for="last_name">Subject<sup class="sup">*</sup></label>

                            <select class="custom-select" id="subject" name="subject">
                        
                                <option value="">Select subject</option>
                                    @foreach($subject as $subjects)
                                        <option value="{{$subjects->id}}">{{$subjects->sub_code}} - {{$subjects->title}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div> -->


                    <script>

                            const Descriptionss = [
                              
                            ];
                            const DescriptionsIDs = [
                           
                            ];

                          


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
                            var dropdownMenuButton =  document.getElementById('dropdownMenuButtons').value = 'Choose subject';
                            var searchedvalue =  document.getElementById('subject').value = '';
                        }

                        function changeValueSearcheds(valueGets, vals){
                          
                                var searchedvalue = document.getElementById('subject');
               
                                searchedvalue.value = valueGets;

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

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="last_name">Semester<sup class="sup">*</sup></label>

                            <select class="custom-select"  id="semester" name="semester">

                            <option value="1">1st Semester</option>
                            <option value="2">2nd Semester</option>
                            </select>
                        </div>
                    </div>

                    <script>
                        function changinging(){
                            var dropdownMenuButton =  document.getElementById('dropdownMenuButton').value = 'Choose section';
                            var searchedvalue =  document.getElementById('searchedvalue').value = '';
                        }
                        function resets(){
                          
                                var preq = document.getElementById('preq');

                                // Get all child elements of the parent
                                var childElements = preq.children;

                                
                                for (var i = childElements.length - 1; i >= 0; i--) {
                                
                                    if (childElements[i].tagName.toLowerCase() !== 'input') {
                                        
                                        preq.removeChild(childElements[i]);
                                        
                                    }
                                }
                            }


                    const Descriptions = [];
                            const DescriptionsID = [];
                        function validateInput(input) {
                            input.value = input.value.replace(/[^0-9]/g, '').replace(/^-/,'');
                            
                        }

                        function fill_strand(level){

                        

                        var strandss =  document.getElementById('sections');
                     
                        jQuery.ajax({
                            
                                            
                            url: "{{ url('teacher/gettingSectionTeacher') }}",
                            data: {
                    
        
                                gradeLeve: level.value,
                            },
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            success:function(result)
                            {
                                
                              
                                var results = result.strands;
                                var ids = result.ids;
                               var temps = '';
                                var countings = 0;
                            
                                
                                while(DescriptionsID.length > 0) {
                                    DescriptionsID.pop();
                                }
                                while(Descriptions.length > 0) {
                                    Descriptions.pop();
                                }
                             
                                results.forEach(function(element) {



                                    
                                var option = document.createElement('option');
                          
                                DescriptionsID.push(ids[countings]);
                                Descriptions.push(element);

                        
                          
                              
                                countings++;
                                });

                               
                                refresh();
                                
                            }

                        
                        });
                    }


                    function fill_subs_(level){

                        

                        var strandss =  document.getElementById('sections');

                        jQuery.ajax({
                            
                                            
                            url: "{{ url('teacher/gettingfillSubsTeacher') }}",
                            data: {


                                gradeLeve: level.value,
                            },
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            success:function(result)
                            {
                                
                            
                                var results = result.strands;
                                var ids = result.ids;
                            var temps = '';
                                var countings = 0;
                            
                                
                                while(DescriptionsIDs.length > 0) {
                                    DescriptionsIDs.pop();
                                }
                                while(Descriptionss.length > 0) {
                                    Descriptionss.pop();
                                }
                            
                                results.forEach(function(element) {



                                    
                                var option = document.createElement('option');
                        
                                DescriptionsIDs.push(ids[countings]);
                                Descriptionss.push(element);


                        
                            
                                countings++;
                                });

                              
                            
                                refreshs();
                                
                            }


                        });
                        }
                    </script>
                    
                  
                
              
                </div>

      

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
                    
              
                


                  
                    var emailExistscode = false;
            
                    var employeeExist = false;
                        
                    var emailExists = false;
                    var isValid = true;

                    var subjectNote, trackNote, sectionNote, semesterNote = '';
                    // Function to validate the form

                    function validateForm(){
                        
                       
                        const subject = document.getElementById("subject");
                        const track = document.getElementById("track");
                        const section = document.getElementById("searchedvalue");
                        const semester = document.getElementById("semester");
                
                        jQuery.ajax({
                                    
                                                    
                                    url: "{{ url('teacher/checkIftitlesexistSubjectTeacher') }}",
                                    data: {
                         
                                        subject: subject.value,
                                        track: track.value,
                                        section: section.value,
                                        semester: semester.value,
                                    },
                                    type: 'post',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },

                                    success:function(result)
                                    {
                                        
                                        
                                        emailExistscode = result.condition;
                                        subjectNote = result.subject;
                                        trackNote = result.track;
                                        sectionNote = result.section;
                                        semesterNote = result.semester;
                          
                                        validateForm_second();
                                    
                                    }

                                
                                });
                                        
                                    
                                  


                        
                    }

                    function changeValueSearched(valueGets, vals){
                                var searchedvalue = document.getElementById('searchedvalue');
               
                                searchedvalue.value = valueGets;

                                var dropdownMenuButton = document.getElementById('dropdownMenuButton');
                                dropdownMenuButton.value = vals;
                             

                            }

                    function refresh(){
                                
                                

                       
                                resets();
                                const searchTerm = '';

                                const find = Descriptions.filter(fruit => fruit.includes(searchTerm));
                                
                                
                                for(var x = 0; x != find.length; x++){
                                
                                    var preq = document.getElementById('preq');

                                    const buttonElement = document.createElement('button');
                                    const i = Descriptions.indexOf(find[x]);
                                    buttonElement.setAttribute('onclick', 'changeValueSearched("'+DescriptionsID[i]+'", "'+find[x]+'")'); 
                                    buttonElement.setAttribute('value', DescriptionsID[i]);
                                    buttonElement.setAttribute('type', 'button');
                                    buttonElement.setAttribute('class', 'dropdown-item');
                                    buttonElement.innerText = find[x];


                                    preq.appendChild(buttonElement);
                                }
                               

                            }
                    
                    function validateForm_second() {
                        
                        isValid = true;

                        // Reset borders and error messages
                        resetValidation();

                        // Validation for First Name, Middle Name, and Last Name


                        // Validation for Email
            
                       
                        const subject = document.getElementById("subject");
                        const track = document.getElementById("track");
                        const section = document.getElementById("searchedvalue");
                     

                        if( track.value != "" && subject.value != "" && section.value != "" ){
                           
                            
                            if(!emailExistscode){
                                nextPagingLoading();
                                document.getElementById('myForm').submit();
                            }
                            else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Opps!',
                                        html: '<i>' + trackNote + ' / ' + sectionNote + ' / ' + subjectNote + ' / ' + semesterNote + '</i> <b>already exists.</b>',
                                        confirmButtonText: "Try again",
                                        } )
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


                    

                            

                           

                    function getvals(searching){
                               
                                
                                resets();
                                

                                const searchTerm = searching.value.toLowerCase(); 
                                const find = Descriptions.filter(fruit => fruit.toLowerCase().includes(searchTerm)); 
                                
                                for (var x = 0; x < find.length; x++) {
                                    var preq = document.getElementById('preq');

                                    const buttonElement = document.createElement('button');
                                    const i = Descriptions.indexOf(find[x]);
                                    buttonElement.setAttribute('onclick', 'changeValueSearched("'+DescriptionsID[i]+'", "'+find[x]+'")'); 
                                    buttonElement.setAttribute('value', DescriptionsID[i]);
                                    buttonElement.setAttribute('type', 'button');
                                    buttonElement.setAttribute('class', 'dropdown-item');
                                    buttonElement.innerText = find[x];


                                    

                                    preq.appendChild(buttonElement);
                                }
                                

                            }

                            function resetings(mine){
                                var resetID = document.getElementById('resetID');
                                var dropdownMenuButton = document.getElementById('dropdownMenuButton');
                                var searchedvalue = document.getElementById('searchedvalue');
                                dropdownMenuButton.value = 'Choose pre-requisite';
                                searchedvalue.value = '';

                                  
                                  resetID.style.display = "none";
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