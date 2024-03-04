@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | View students

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">View students</h1>
            <p> {{$courseName}} / {{$subjectNameCode}} - {{$subjectName}} / {{$semester}} / {{ $section }}</p>
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
                <h3 class="card-title"  style="display:flex; justify-content:space-between; width: 100%"><span>Upload your student's final grades</span> <span>S.Y. {{$acads}}</span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="card-body">
              
              <div>
              
                    <h1 style="padding: 0px; margin: 0px">{{ count($selectedStud) }} Student/s</h1>
                    <div style="display: flex; gap: 0px">

                    <p style="padding: 0px; margin: 0px;display:flex; align-items:center; gap:5px ">
                        <span style="height:10px !important; width:10px !important; background-color: #FFCF81"></span>INCOMPLETE: <span id="INCf"></span></p>
                    
                    <p style="padding: 0px; margin: 0px;margin-left:18px;display:flex; align-items:center; gap:5px ">
                        <span style="height:10px !important; width:10px !important; background-color: rgb(240, 64, 64)"></span>FAILED: <span  id="FAILEDf"></span></p>
                    
                    <p style="padding: 0px; margin: 0px;margin-left:18px;display:flex; align-items:center; gap:5px ">
                        <span style="height:10px !important; width:10px !important; background-color: #30bb2f"></span>PASSED: <span  id="PASSEDf"></span></p>
                    
                </div>
              </div>
              <div style="display:none !important; width: 100%; display:flex; justify-content: end; margin-bottom:10px"><button type="button" class="btn bg-gradient-info" id="" onclick="uploads();"><i class="fas fa-file-upload"></i> Import grades</button></div>
           
                <script>
                    function uploads(){
                        var htmlList = `
                        
                            <form id="Myforming" action="{{ route('process.upload') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="container mt-5" style="text-align: left !important; margin-bottom: 20px">
                                    <h3>Instructions</h3>
                                    <ul class="list-group" >
                                        <li style="border: 0px !important; padding-bottom: 5px" class="list-group-item">
                                            Step 1: First, verify that the student number, name, and final grade of all the students you are handling are listed in the file.</li>
                                        <li style="border: 0px !important; padding-bottom: 5px " class="list-group-item">
                                            Step 2: Locate the grading system file provided by the school, ensuring that it is in either Excel or CSV format.</li>
                                        <li style="border: 0px !important; padding-bottom: 5px " class="list-group-item">
                                            Step 3: Click the upload button after selecting the file.</li>
                                    </ul>
                                    <br>
                                    
                                    <input class="form-control" name="filing" required style="height: 45px" type="file" id="formFile" accept=".xlsx, .xls, .csv">
                                </div>


                            </form>
                        `;


            
                        
                            
                            Swal.fire({
                                title: '',
                                width: '35%',
                                html: htmlList,
                            
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Upload'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    var formFile =  document.getElementById('formFile');
                                    if (formFile.files.length > 0) {
                                        
                                        document.getElementById('Myforming').submit();

                                        let timerInterval;
                                        Swal.fire({
                                        title: "Uploading..",
                                        allowOutsideClick: false,
                                        html: "Please wait for a while.",
                                        timer: 200000,
                                        timerProgressBar: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                            const timer = Swal.getPopup().querySelector("b");
                                            timerInterval = setInterval(() => {
                                            timer.textContent = `${Swal.getTimerLeft()}`;
                                            }, 100);
                                        },
                                        willClose: () => {
                                            clearInterval(timerInterval);
                                        }
                                        }).then((result) => {
                                        /* Read more about handling dismissals below */
                                        if (result.dismiss === Swal.DismissReason.timer) {
                                            
                                        }
                                        });
                                        
                                    }
                                    else{
                                        result.isConfirmed = false;
                                    }
                                  
                                    
                                }
                            })
                    }
                </script>

                <script>
                    
                    
                    function findEmptyInput() {
                        var inputs = document.querySelectorAll('input[type="number"]');
                        var finging = 0;
                        var findings = document.getElementById('findings');
                        for (var i = 0; i < inputs.length; i++) {
                            if (inputs[i].value === "" || inputs[i].value === '0') {
                                // Scroll to the empty input
                                finging++;
                                inputs[i].scrollIntoView({ behavior: 'smooth', block: 'center' });

                                setTimeout(function() {
                                    inputs[i].focus();
                                }, 300);
                                break;  // Stop after the first empty input is found
                            }
                        }
                        if(finging == 0){
                            findings.style.display = "none";
                        }
                        else{
                            findings.style.display = "flex";
                        }
                    }


                function checkColor(id){
                    var INCs = 0;
                    var FAILEDs = 0;
                    var PASSEDs = 0;

                    var inputGrade = document.getElementById(id+"inputGrade");
                    var remarksTag = document.getElementById(id+"remarksTag");
                    var remarks = '';
                    var eqvs = document.getElementById(id+"eqv");
                    var eqv = 'N/A';
                    if(inputGrade.value != '' ){
                        // inputGrade.style.borderColor = "#30bb2f";
                        
                        if(inputGrade.value == 0){
                            eqv = 'N/A';
                        }
                        else if(inputGrade.value <= 74.00){
                            eqv = '5.00';
                        }
                        else if(inputGrade.value <= 75.00){
                            eqv = '3.00';
                        }
                        else if(inputGrade.value <= 78.00){
                            eqv = '2.75';
                        }
                        else if(inputGrade.value <= 81.00){
                            eqv = '2.50';
                        }
                        else if(inputGrade.value <= 84.00){
                            eqv = '2.25';
                        }
                        else if(inputGrade.value <= 87.00){
                            eqv = '2.00';
                        }
                        else if(inputGrade.value <= 91.00){
                            eqv = '1.75';
                        }
                        else if(inputGrade.value <= 94.00){
                            eqv = '1.50';
                        }
                        else if(inputGrade.value <= 97.00){
                            eqv = '1.25';
                        }
                        else if(inputGrade.value <= 100.00){
                            eqv = '1.00';
                        }
                        else{
                            eqv = 'N/A';
                        }

                        if(inputGrade.value != 0){
                            if(inputGrade.value <= 74.4){
                                remarks = 'FAILED';
                                // inputGrade.style.borderColor = "rgb(240, 64, 64)";
                                // eqvs.style.color = "rgb(240, 64, 64)";
                                remarksTag.style.color = "rgb(240, 64, 64)";
                              
                            }
                            else if(inputGrade.value == 101){
                                remarks = 'INC';
                            
                      
                            // eqvs.style.color = "gray";
                            remarksTag.style.color = "#FFCF81";
                            }
                            else{
                                
                                remarks = 'PASSED';
                           
                                // inputGrade.style.borderColor = "#30bb2f";
                                remarksTag.style.color = "#30bb2f";
                                // eqvs.style.color = "#30bb2f";
                            
                            }
                        }
                        else if(inputGrade.value == 101){
                            remarks = 'INC';
                            
                      
                            // eqvs.style.color = "gray";
                            remarksTag.style.color = "#FFCF81";
                            }
                        else{
                            remarks = 'INC';
                            
                      
                            // eqvs.style.color = "gray";
                            remarksTag.style.color = "#FFCF81";
                        }
                       
                        
                        eqvs.innerHTML = eqv;
                        remarksTag.innerHTML = remarks;
                    }
                    else{
                        // inputGrade.style.borderColor = "rgb(240, 64, 64)";
                        // eqvs.style.color = "rgb(240, 64, 64)";
                        remarks = 'INC';
           
                        remarksTag.style.color = "#FFCF81";
                       

                        eqvs.innerHTML = eqv;
                        remarksTag.innerHTML = remarks;
                    }
                    var PASSEDf = document.getElementById("PASSEDf");
                    var FAILEDf = document.getElementById("FAILEDf");
                    var INCf = document.getElementById("INCf");

               
                    var findings = document.getElementById('findings');
                    var inputs = document.querySelectorAll('input[type="number"]');
                    var finging = 0;
                    for (var i = 0; i < inputs.length; i++) {
                      
                              
                                finging++;
                                if(inputs[i].value != '' ){
                                    if(inputs[i].value != 0 && inputs[i].value != 101  ){
                                        if(inputs[i].value <= 74.4){
                                        
                                
                                            FAILEDs++;
                                        
                                        }
                                    else{
                                      
                                        PASSEDs++;
                                    
                                    
                                    }
                                }
                                else{
                                    
                                    INCs++;
                                }

                            }
                            else{
                           
                                INCs++;
                            }
                            $(document).ready(function() {
                                if(finging == 0){
                            findings.style.display = "none";
                                }
                                else{
                                    findings.style.display = "flex";
                                }
                            });
                        
                       
                    }
                    PASSEDf.innerHTML = PASSEDs;
                    FAILEDf.innerHTML = FAILEDs;
                    INCf.innerHTML = INCs;
                    
            
                }
              </script>
   
              <form id="myForm" method="POST" action="{{ route('teacher.uploading_finals', ['id' => $idko]) }}">
              @csrf
              <table id="example3" class="table-bordered table table-bordered table-striped">
                
                <thead>
                <tr>
                 
                  
                  <th>Student no.</th>
                  <!-- <th>Email</th> -->
                  <th>Full name</th>
                  
           
                  {{-- <th>Birthday</th> --> --}}

                  <th style="width: 20px !important" >Final grade</th>
                  
                  {{-- <th style="width:  20px !important" >Eqv.</th>
                  <th style="max-width:  80px;" >Remarks</th> --}}
          
                </tr>
                </thead>
                <tbody>
                
                @foreach($students as $data)
                
                 
                  
                 
                @if(in_array($data->id, $selectedStud))

                @php
                        if (session('gradesUploaded')) {
                            if (isset(session('gradesUploaded')[$data->student_no])) {
                                $valuesGrade = session('gradesUploaded')[$data->student_no];
                            } else { 
                        
                              
                            } 
                        } else {
                            
                            $valuesGrade = $gradesFinal[$data->id];
                        }
                    @endphp

                    @php
                        if ($valuesGrade == '' || $valuesGrade == '0') {
                           
                            $colors = "width: 100px; border-color: rgb(240, 64, 64)";
                            $type = "text";
                            if( $valuesGrade == '0'){
                                $displaying = "display:block";
                            }
                            else{
                                $displaying = "display:none";
                            }
                            $valuesGrade = '0';
                        } else {
                            $colors = "width: 100px; border-color: #30bb2f;";
                            $type = "number";
                            if( $valuesGrade == '0'){
                                $displaying = "display:block";
                            }
                            else{
                                $displaying = "display:none";
                            }
                        }
                        $colors = 'width: 100px;';


                        if($ditTable == '1'){

                        $readonly = '';

                        }
                        else{
                            $readonly = 'readonly';
                        }
                     
                    @endphp



                  
                    
                        
                 
                  <tr id="{{$data->id}}row" class="opacitysTR" >
                 
                    
              
                        
                          
                       
                     
                    
                      <input type="hidden" name="{{$data->id}}firstname" id="{{$data->id}}firstname" value="{{ $data->firstname }} @php if($data->middlename != ''){echo $data->middlename[0] . '.';}else{echo $data->middlename;} @endphp {{ $data->lastname }}">
                      <input type="hidden" name="{{$data->id}}studno" id="{{$data->id}}studno" value="{{ $data->student_no }}">
                      <input type="hidden" name="{{$data->id}}section" id="{{$data->id}}section" value="{{ $data->sectioning }}">
                      
                      <td><label for="{{$data->id}}button">{{ $data->student_no }}</label></td>
                      <td><label for="{{$data->id}}button" id="{{$data->id}}inputGradeNames">{{ $data->lastname }}, {{ $data->firstname }} {{ $data->middlename }}</label></td>
                      

                      <!-- <td><label for="{{$data->id}}button">{{ $data->birth_month }}-{{ $data->birth_day }}-{{ $data->birth_year }}</label></td> -->
                      
                        
                      

                      
                      <td style="display:">
                    
                            <div style="position:relative; width: 100%; height: 100%;">
                                <input style="position:absolute;{{$displaying}}" onmouseover="bigImg(this)" id="{{$data->id}}buttonIncom" onclick="hideIncomplete(this, '{{$data->id}}inputGrade')" readonly onmouseout="normalImg(this)" class="btn btn-block btn-warning changingsColor" value="Incomplete">
                            
                                <input {{$readonly}} max="100" type="number" name="{{$data->id}}inputGrade" step="any" id="{{$data->id}}inputGrade" onchange="limitInput(this, 60, 100, '{{$data->id}}')" onkeyup="checkColor('{{$data->id}}');"  style="{{$colors}}border: none; background: transparent" class="form-control" value="{{$valuesGrade}}"  placeholder="00.00">

                            </div>
                            
                           
 


                           <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    checkColor('{{$data->id}}');
                                });
                           </script>
                      </td>
                      
                      <td style="display:none"><label id="{{$data->id}}eqv"></label></td>
                      <td style="display:none"><label id="{{$data->id}}remarksTag"></label></td>
                   
                  </tr>
                  @endif
               


                  
             
                @endforeach
                </tbody>
              
              <tfoot>
           
              </tfoot>
            </table>
            
              
            <style>
                .changingsColor:hover{
                    transition: .2s ease;
                    background-color:#28a745 !important;
                    border-color: #28a745 !important;
                }
            </style>

            
            <script>
                function hideIncomplete(incomplete, chcnge){
                    incomplete.style.display = "none";
                    document.getElementById(chcnge).value = 0;
                }
                function bigImg(changing){
                    changing.value = "Unlock";
                }
                function normalImg(changing){
                    changing.value = "Incomplete";
                }
               function limitInput(inputElement, min, max, idsf) {
                let value = parseInt(inputElement.value);

                const inputValue = event.target.value;

                // Remove leading zeros
                const sanitizedValue = inputValue.replace(/^0+/, '');

                inputElement.value = sanitizedValue;
                value = sanitizedValue;
                // Check if the entered value is a number
                if (isNaN(value) || value == 0) {
                const subject = document.getElementById(idsf+"buttonIncom").style.display = "block";
             
                inputElement.value = 101;
                } else {
                // Check if the value is less than the minimum
                if (value < min) {
                    inputElement.value = min;
                }

                // Check if the value is greater than the maximum
                if (value > max) {
                    inputElement.value = max;
                }
                }
                checkColor(idsf);
            }
                document.addEventListener('DOMContentLoaded', function () {
                    // Initialize DataTable
                    const dataTable = $('#example3').DataTable({
                        // Disable sorting for the first column
                        paging: false,
                        
                        // Adjust the height as needed
                        order: [[1, 'asc']], // Assuming you want to sort by the second column initially
                        columnDefs: [
                            { targets: [0], orderable: false },
                            { targets: [1], orderable: false },
                            { targets: [2], orderable: false },
                            { targets: [3], orderable: false },
                            { targets: [4], orderable: false }
                        ],
                      
                    });

                    // Get the DataTables search input
                    const dataTablesInput = $('input[type="search"]');

                    // Get all checkboxes
                    const checkboxes = $('input[type="checkbox"]');

                    // Add an event listener to the DataTables search input
                    dataTablesInput.on('input', function () {
                      
                        // Clear the search input
                        dataTable.search('').draw();

                        // Uncheck all checkboxes
                        checkingUncheck();
                    });
                });
            </script>
            

            <input type="hidden"  id="track" name="course_id" value="{{ $track }}">
            <input type="hidden"  id="subject" name="subject_id" value="{{ $subject }}">
            <input type="hidden"  id="sectionID" name="section_id" value="{{ $sectionID  }}">
            <input type="hidden"  id="semester" name="semester" value="{{ $semesterID }}">

            <div class="card-body" style="padding-left: 0px">
                
                 
                <div class="d-flex gap-flex"  style="flex-wrap: wrap-reverse;justify-content: space-between">
                    <div class="d-flex gap-flex" style="flex-wrap: wrap">
                        <a href="{{route('admin.teacherSection', ['academic' => 'original'])}}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" >Back</button></a>
                        @if($ditTable == '100')
                        <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Save grades</button>
                        @endif
                    </div>
                  
                 <input type="hidden" name="" id="findings">
                </div>
            </div>
            <script>
                function askfirst(){
                    if (isValid) {
                            Swal.fire({
                                title: '',
                                text: "Are you sure you want to exit?",
                                icon: 'question',
                                showCancelButton: true,
                                allowOutsideClick: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Cancel',
                                cancelButtonText: 'Confirm'
                                }).then((result) => {
                                if (!result.isConfirmed) {
                                    
                                    window.location.href ="{{route('teacher.edit_section', ['academic' => 'original'])}}";
                              
                                }
                            })
                            
                        }
                }
            </script>
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
                        
                        
                        var inputs = document.querySelectorAll('input[type="number"]');
                        
                        // Initialize a counter for zero values
                        var zeroCount = 0;

                        // Iterate through each input element
                        inputs.forEach(function(input) {
                            // Check if the value is 0
                            if (parseFloat(input.value) === 0) {
                                zeroCount++;
                            }
                        });

                        // Display the result
                        if(zeroCount != 0){
                            modals("Some student(s) have not received grades.");
                        }
                        else{

                            var inputs = document.querySelectorAll('input[type="number"]');

                            var names = [];

                            inputs.forEach(function(input) {
                                // Check if the value is 0
                                if (parseFloat(input.value) === 101) {

                                    names.push(document.getElementById(input.id + 'Names').innerHTML);
                                    zeroCount++;
                                }
                            });

                            if(names.length != 0){
                                
                                if(names.length > 1){
                                    var grammars = 'Are you sure that these students are incomplete?';
                                }
                                else{
                                    var grammars = 'Are you sure that this student is incomplete?';
                                }
                                var htmlList = `
                                    <br>
                                    <h5 style="text-align:left"><b style="text-transform: uppercase;">${grammars}</b></h5>
                                    <br>
                                    <div class="tableSelectedsff">
                                        <table class="tableSelected">
                                            
                                            ${Object.entries(names).map(([key, item]) => `
                                                <tr><td>• ${item}</td></tr>
                                            `).join('')}
                                        </table>
                                    </div>
                                `;


                                Swal.fire({
                                title: '',
                                width: '35vw',
                                html: htmlList,
                                
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, save grade(s)'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    var numberInputs = document.querySelectorAll('input[type="number"]');

                                    // Loop through each number input element
                                    numberInputs.forEach(function(input) {
                                        // Check if the value of the input element is "101"
                                        if (input.value === '101') {
                                            // If yes, set the value to "0"
                                            input.value = '0';
                                        }
                                    });
                                    document.getElementById('myForm').submit();
                                    
                                }
                            });
                            }else{
                                var numberInputs = document.querySelectorAll('input[type="number"]');

                                // Loop through each number input element
                                numberInputs.forEach(function(input) {
                                    // Check if the value of the input element is "101"
                                    if (input.value === '101') {
                                        // If yes, set the value to "0"
                                        input.value = '0';
                                    }
                                });
                                document.getElementById('myForm').submit();
                            }
                            

                        }

                       

                        
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
                        title: 'Oopss!',
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