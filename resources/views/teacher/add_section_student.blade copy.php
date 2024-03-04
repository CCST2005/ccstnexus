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
            <h1 class="m-0">{{$courseName}} / {{$subjectName}}</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-12 wrapping" style="display:flex; gap: 10px;">
            
            <!-- /.card -->

            <div class="card limitScroll" style="flex:60%;height: 100%;">
            
              <div class="card-header">
             
                <h3 class="card-title">Add student to your subject</h3>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              
              <div class="" style="display:none" id="disable&delete" >
              <div><span style="opacity:80%">Selected student: <span id="countSelected"></span></span></div><br>
             
            </div>
              
                  
                 
              
              @csrf
              
              
               
              <form id="myForm" method="POST" action="{{ route('teacher.adding_section_student') }}">
              <table id="example3" class="table-bordered table table-bordered table-striped">
                
                <thead>
                <tr>
                  <th style="width: 2%;" ><input type="checkbox" id="checkbox" name="" onclick="selectAllCheckboxes()" id=""></th>
                  
                  <th>Student no.</th>
                  <!-- <th>Email</th> -->
                  <th>Full name</th>
                  
                  <th>Section</th>
                  <th>Birthday</th>
                  <th>Section</th>
                  
                  
          
                </tr>
                </thead>
                <tbody>
                
                @foreach($students as $data)
                
                 
                  
                 

                  <tr id="{{$data->id}}filling">
                  
                      <td><input id='{{$data->id}}button' type="checkbox" name="checkboxes[]" class="checkbox" onclick="updateCount('{{ $data->id }}', '{{ $data->firstname }} @php if($data->middlename != ''){echo $data->middlename[0] . '.';}else{echo $data->middlename;} @endphp {{ $data->lastname }}', '{{ $data->student_no }}', '{{ $data->sectioning }}', '$data->sectionId')" value="{{ $data->id }}"></td>
                      <td><label for="{{$data->id}}button">{{ $data->student_no }}</label></td>
                      <td><label for="{{$data->id}}button">{{ $data->firstname }} {{ $data->middlename }} {{ $data->lastname }}</label></td>
                      <td><label for="{{$data->id}}button">{{ $data->firstname }} {{ $data->middlename }} {{ $data->lastname }}</label></td>

                      <td><label for="{{$data->id}}button">{{ $data->birth_month }}-{{ $data->birth_day }}-{{ $data->birth_year }}</label></td>
                      <td><label for="{{$data->id}}button">{{ $data->sectioning }}</td>
                      
                      
                      
                  
          
                  </tr>

               


                  
             
                @endforeach
                </tbody>
              
              <tfoot>
           
              </tfoot>
            </table>
           
              
            


            
            
            <input type="hidden"  id="sectionID" name="track" value="">
            <input type="hidden"  id="track" name="track" value="{{ $track }}">
            <input type="hidden"  id="subject" name="subject" value="{{ $subject }}">
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

                

                  // var tempStoring = {};            
                 var storing = {};
                 var finalStored = {};
             

                @foreach($students as $datas)
                  @php
                  $middle = '';
                  if($datas->middlename != ''){
                      $middle = $datas->middlename[0] . '.';
                    }
                    else{
                      $middle = '';
                    }
                  @endphp
                    
                  @php
                  $names = $datas->firstname ." ". $middle ." ". $datas->lastname;
                  @endphp
                  storing['{{$datas->id}}'] = { 'name': '{{$names}}', 
                  'stud': '{{ $datas->student_no }}', 'section': '{{ $datas->sectioning }}' };
                @endforeach



                  var totalChecked = 0;

                 


                  function selectAllCheckboxes() {
       
                  var checkboxes = document.getElementsByClassName('checkbox');
                  var checkbox = document.getElementById('checkbox');


                  for (var i = 0; i < checkboxes.length; i++) {
                    
                      

                      if(!storing.hasOwnProperty(checkboxes[i].value)){
                        checkboxes[i].click();
                        
                      }
                      
                    
                    
                    
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
                
                        
                        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                      var totalCheckedElement = document.getElementById('totalChecked');
                      
                      var totalChecked = Array.from(checkboxes).filter(function (c) {
                          return c.checked;
                      }).length;
                     

                        if( totalChecked != 0 &&  track.value != "" && subject.value != "" ){
                        
                                      
                                 
                                
                            }
                            else{
                        modals("Choose student first.");
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
                <div style="flex:10%;display:flex; justify-content:center;flex-wrap:wrap;gap:10px; max-width: 90px">
                      
                      <button type="button" style="width:100%" class="btn btn-block btn-success" id="submit_buttons" onclick="nililipat();">Add <i class="fas fa-chevron-right" style="font-size:12px"></i><i  style="font-size:12px" class="fas fa-chevron-right"></i></button>
                      <button type="button" style="width:100%;display:none" class="btn btn-block btn-danger" id="reset_buttons" onclick="deleteAllList();"><i class="fas fa-chevron-left"  style="font-size:12px"></i><i  style="font-size:12px" class="fas fa-chevron-left"></i> Reset</button>
                  </div>
              <div class="card limitScroll"  style="position:relative;flex:30%;height: 100%;">
              <div class="card-header">
                
                  <h3 class="card-title" style="justify-content: space-between;display:flex;width:100%"><span>Student list</span><span id="countedStudent"></span></h3>
                </div>

              <div class="card-body ">

              <span id="selectFirst" style="text-align:center;opacity:50%;width:100%;display:block">Select student first</span>
                  <div class="tableSelecteds">
              <table class="tableSelected">
                
              
                
                
               
            </table>
            
            <script>
              var totalNumber = 0;
              function countingSelected(counting){
                  var countedStudent = document.getElementById("countedStudent");
                  var selectFirst = document.getElementById("selectFirst");
                  var save_button = document.getElementById("save_button");
                  var reset_buttons = document.getElementById("reset_buttons");
                  var number = counting;
                  if(number != 0){
                    countedStudent.innerHTML = ""+number;
                    save_button.style = "display:";
                    reset_buttons.style = "display:";
                  
                    selectFirst.style = "display:none";
                  }
                  else{
                    countedStudent.innerHTML = '';
                    save_button.style = "display:none";
                    reset_buttons.style = "display:none";
                    selectFirst.style = "text-align:center;opacity:50%;width:100%;display:block";
                  }
                  
              }

              function changeStyleOfAllRows() {
                  // Get all tr elements on the page
                  var rows = document.querySelectorAll('tr');

                  // Loop through each row and change its style
                  rows.forEach(function(row) {
                    row.style = 'display:';
                    // Add any other style changes as needed
                  });
                }
              function uncheckAllCheckboxes() {
                // Get all checkboxes on the page
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                
                // Loop through each checkbox and uncheck it
                checkboxes.forEach(function(checkbox) {
                  checkbox.checked = false;
                });
                
              }
              function deleteAllList(){
                storing = {};
           
           
                uncheckAllCheckboxes();
                changeStyleOfAllRows();
                filling();
              }
              function deletings(id){
     
                delete storing[id];

                var temp = document.getElementById(id+"filling");
                  temp.style = "display:";
                temp = document.getElementById(id+"button");
                temp.checked = false;

                filling();
              }
              function nililipat(){
               
             
                filling();
              }
              
              function filling() {
                finalStored = {};


                Object.entries(storing).forEach(([key, value]) => {
                  
                  
                  var buttons = document.getElementById(key+"button");
                  if(buttons.checked == true){
                 
                  
                    finalStored[key] = { 'name': value.name,  'stud': value.stud, 'section': value.section };

                  }
                  
                

                });


          
                var tableSelected = document.getElementsByClassName("tableSelected")[0]; // Use [0] to get the first element if there are multiple elements with the same class
                tableSelected.innerHTML = '';
                var counting = 0;
                Object.entries(finalStored).forEach(([key, value]) => {
                  
                  
                  var buttons = document.getElementById(key+"button");
                  if(buttons.checked == true){
                    var temp = document.getElementById(key+"filling");
                  temp.style = "display:none";
                  counting++;
                    tableSelected.innerHTML += "<tr><td><button class='btn btn-block btn-danger reducing' onclick='deletings("+ key +")'>x</button></td><td>" + value.name + "</td><td>" + value.stud + "</td><td>" + value.section + "</td></tr>";
                  }
                  
                

                });
                countingSelected(counting);
                totalNumber = counting;
                var storingData = document.getElementById("storingData");
                storingData.value = JSON.stringify(storing);
             
              }

            </script>
            <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize DataTable
        const dataTable = $('#example3').DataTable({
            // Disable sorting for the first column
            order: [[1, 'asc']], // Assuming you want to sort by the second column initially
            columnDefs: [
                { targets: [0], orderable: false }
            ]
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
            checkboxes.prop('checked', false);
        });
    });
</script>



            <br>
           
            <TEXtarea style="display:none" name="storingData" id="storingData"></TEXtarea>
            <div style="position:absolute; bottom:10px;  left: 10px; right: 10px">
            
              <button style="display: none; " onclick="confirm()" type="button" style="width:100%" class="btn btn-block btn-success" id="save_button" >Save</button>
              <script>
                function confirm(){
                  var tempArray = {

                    @foreach($students as $datas)
                      '{{$datas->sectioning}}': '{{$datas->sectionId}}',
                    @endforeach


                    };

                  // Count the occurrences of each section
                  var sectionCounts = Object.values(storing).reduce((counts, student) => {
                    counts[student.section] = (counts[student.section] || 0) + 1;
                    return counts;
                  }, {});

                  // Find the section with the maximum occurrence
                  var maxSection = Object.keys(sectionCounts).reduce((a, b) => (sectionCounts[a] > sectionCounts[b] ? a : b));
                  var section = maxSection;
                  var subject = '{{$subjectName}}';
                  var track = '{{$courseName}}';
                  var htmlList = `
                  <br>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Academic program: </b>`+track+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Subject: </b>`+subject+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Section: </b>`+section+`</h5>
                    <br>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Student list: </b>`+totalNumber+`</h5>
                    <table  class="tableSelected">
                    <tr><th>Student no.</th><th>Full name</th><th>Section</th></tr>
                      ${Object.entries(storing).map(([key, item]) => `
                        
                        <tr><td>${item.stud}</td><td>${item.name}</td><td>${item.section}</td></tr>
                      `).join('')}
                    </table>
                  `;

                  var sectioningID = document.getElementById("sectionID");
                  sectioningID.value = tempArray[section];
       
                  
                     
                    Swal.fire({
                        title: '',
                        width: '60%',
                        html: htmlList,
                        
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Save this section'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('myForm').submit();
                        }
                    })
                    
                  }
              </script>
            </div>
            
            </div>
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