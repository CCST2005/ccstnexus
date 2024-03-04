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
          <div class="col-sm-8">
            <h1 class="m-0">Add section</h1>
            <p>{{$courseName}} / {{$subjectNameCode}} - {{$subjectName}} / {{$semester}} / {{ $section }}</p>
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

            <div class="card limitScroll" style="flex:50%;height: 100%;">
            
              <div class="card-header">
             
                <h3 class="card-title" style="display:flex; justify-content:space-between; width: 100%">Add student to your subject<span>S.Y. {{$acads}}</span></h3>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              
              <div class="" style="display:none" id="disable&delete" >
              <div><span style="opacity:80%">Selected student: <span id="countSelected"></span></span></div><br>
             
            </div>
              
                  
                 
              
         
              
              
               
              <form id="myForm" method="POST" action="{{ route('teacher.adding_section_student') }}">
              @csrf
              <table id="example3" class="table-bordered table table-bordered table-striped">
                
                <thead>
                <tr>
                  <th style="width: 2%;" ><input type="checkbox" id="checkbox" value="checkOnly" name="" onclick="selectAllCheckboxes()"></th>
                  
                  <th>Student no.</th>
                  <!-- <th>Email</th> -->
                  <th>Full name</th>
                  <th>Section</th>
           
                  <th>Birthday</th>
               
                  
                  
          
                </tr>
                </thead>
                <tbody class="">
                
                @foreach($students as $data)
                
                 
                  
                 

                  <tr id="{{$data->id}}filling">
                      <input type="hidden" name="{{$data->id}}firstname" id="{{$data->id}}firstname" value="{{ $data->lastname }}, {{ $data->firstname }} @php if($data->middlename != ''){echo $data->middlename[0] . '.';}else{echo $data->middlename;} @endphp ">
                      <input type="hidden" name="{{$data->id}}studno" id="{{$data->id}}studno" value="{{ $data->student_no }}">
                      <input type="hidden" name="{{$data->id}}section" id="{{$data->id}}section" value="{{ $data->sectioning }}">
                      <td><input id='{{$data->id}}button' type="checkbox" name="checkboxes[]" class="checkbox" onclick="checkIfselecteds()" value="{{ $data->id }}"></td>
                      <td><label for="{{$data->id}}button">{{ $data->student_no }}</label></td>
                      <td><label for="{{$data->id}}button">{{ $data->lastname }}, {{ $data->firstname }} {{ $data->middlename }}</label></td>
                      <td><label for="{{$data->id}}button">{{ $data->sectioning }}</td>

                      <td><label for="{{$data->id}}button">{{ $data->birth_month }}-{{ $data->birth_day }}-{{ $data->birth_year }}</label></td>
              
                      
                      
                      
                  
          
                  </tr>

               


                  
             
                @endforeach
                </tbody>
              
              <tfoot>
           
              </tfoot>
            </table>
           
              
            


            
            

            <input type="hidden"  id="track" name="course_id" value="{{ $track }}">
            <input type="hidden"  id="subject" name="subject_id" value="{{ $subject }}">
            <input type="hidden"  id="sectionID" name="section_id" value="{{ $sectionID  }}">
            <input type="hidden"  id="semester" name="semester" value="{{ $semesterID }}">
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
           
                
                
              </div>
              </div>
                <div style="flex:10%;display:flex; justify-content:center;flex-wrap:wrap;gap:10px; max-width: 90px">
                      
                      <button type="button" style="width:100%" class="btn btn-block btn-success" id="submit_buttons" onclick="filling();">Add <i class="fas fa-chevron-right" style="font-size:12px"></i><i  style="font-size:12px" class="fas fa-chevron-right"></i></button>
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
              var ArrayAll = {};
                        var countingChecks = 0;
              
              function filling(){

                var checkboxes = document.getElementById('myForm').querySelectorAll('input[type="checkbox"]');
                var values = Array.from(checkboxes)
                  .filter(checkbox => checkbox.checked)
                  .map(checkbox => checkbox.value);
                var tempvars = '';
                var name = '';
                var studno = '';
                var section = '';
                
              for(var i = 0; i != values.length; i++){
         
         
                if(values[i] != "checkOnly"){
                  
                
                tempvars = document.getElementById(values[i]+"button");
                
                if(tempvars.checked == true && !ArrayAll.hasOwnProperty(tempvars.value)){
                  name = document.getElementById(values[i]+"firstname");
                  studno = document.getElementById(values[i]+"studno");
                  section =document.getElementById(values[i]+"section");

                  ArrayAll[tempvars.value] = { 'name': name.value,  'stud': studno.value, 'section': section.value };

                  
                }
              }
                
              }
              // alert(JSON.stringify(ArrayAll));
              refreshStudentLIst();  
            }


            function checkingUncheck(){

              var checkboxes = document.getElementById('myForm').querySelectorAll('input[type="checkbox"]');
              var values = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
              var tempvars = '';
              var name = '';
              var studno = '';
              var section = '';

              for(var i = 0; i != values.length; i++){


              if(values[i] != "checkOnly"){
                

              tempvars = document.getElementById(values[i]+"button");

              if(tempvars.checked == true && !ArrayAll.hasOwnProperty(tempvars.value)){
                
                tempvars.checked = false;
                
              }
              }

              }
      
              }

              function deletings(id){
     
                delete ArrayAll[id];

                var temp = document.getElementById(id+"filling");
                if(temp){
                  temp.style = "display:";
                }
                  
                temp = document.getElementById(id+"button");
                if(temp){
                  temp.checked = false;
                }
                

                refreshStudentLIst();
              }

            function checkIfselecteds(){
              var tempvars = '';
                var checkboxes = document.getElementById('myForm').querySelectorAll('input[type="checkbox"]');
                var values = Array.from(checkboxes)
                  .filter(checkbox => checkbox.checked)
                  .map(checkbox => checkbox.value);

                  var countingNow = 0;
                  for(var i = 0; i != values.length; i++){
                    if(values[i] != "checkOnly"){
                    tempvars = document.getElementById(values[i]+"button");
                    if(tempvars.checked == true && !ArrayAll.hasOwnProperty(tempvars.value)){
                      countingNow++;
                    }
                  }
                  }
                  if(countingNow != countingChecks){
                    var unselect = document.getElementById("checkbox");
                unselect.checked = false;
                  }
              }



              function deleteAllList(){

                Object.entries(ArrayAll).forEach(([key, value]) => {
                  
             
                  var buttons = document.getElementById(key+"button");
                  if(buttons){
                    if(buttons.checked == true){
                    var temp = document.getElementById(key+"filling");
                    temp.style = "display:";
                    buttons.checked = false;
                  }
                  }
                  
                  
                

                });

                ArrayAll = {};
                refreshStudentLIst();  
              }

              function refreshStudentLIst(){
                var unselect = document.getElementById("checkbox");
                unselect.checked = false;
                var tableSelected = document.getElementsByClassName("tableSelected")[0]; // Use [0] to get the first element if there are multiple elements with the same class
                tableSelected.innerHTML = '';
                var counting = 0;
                Object.entries(ArrayAll).forEach(([key, value]) => {
                  
                  counting++;
                  var temp = document.getElementById(key+"filling");
                    if(temp){
                      temp.style = "display:none";
                    }
                 
                    tableSelected.innerHTML += "<tr><td><button class='btn btn-block btn-danger reducing' onclick='deletings("+ key +")'>x</button></td><td>" + value.stud + "</td><td>" + value.name + "</td><td>" + value.section + "</td></tr>";
                  
                  
                  
                

                });
                var reset_buttons = document.getElementById("reset_buttons");
                var save_button = document.getElementById("save_button");
                var selectFirst = document.getElementById("selectFirst");
                var number = counting;
                if(counting != 0){
                  reset_buttons.style = "display:";
                  selectFirst.style = "display:none";
                  countedStudent.innerHTML = ""+number;
                    save_button.style = "display:";
                }
                else{
                  reset_buttons.style = "display:none";
                  countedStudent.innerHTML = '';
                    save_button.style = "display:none";
                  selectFirst.style = "text-align:center;opacity:50%;width:100%;display:block";
                }
                
              }




              function confirm(){
                
                  var totalNumber = 0;
                  Object.entries(ArrayAll).forEach(([key, value]) => {
                    totalNumber++;
                });
              

                 
                  var section = '{{$section }}';
                  var subject = '{{$subjectName}}';

                  var sectionID = document.getElementById("sectionID");
                 
                  var track = '{{$courseName}}';
                  var semester = '{{$semester}}';
                  var htmlList = `
                  <br>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Academic program: </b>`+track+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Subject: </b>`+subject+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Semester: </b>`+semester+`</h5>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Section: </b>`+section+`</h5>
                    <br>
                    <h5 style="text-align:left"><b style="text-transform: uppercase;">Student list: </b>`+totalNumber+`</h5>
                    
                    <div class="tableSelectedsff">
                    <table  class="tableSelected">
                    <tr><th>Student no.</th><th>Full name</th><th>Section</th></tr>
                      ${Object.entries(ArrayAll).map(([key, item]) => `
                        
                        <tr><td>${item.stud}</td><td>${item.name}</td><td>${item.section}</td></tr>
                      `).join('')}
                    </table>
                    </div>  
                  `;


       
                  
                     
                    Swal.fire({
                        title: '',
                        width: '35%',
                        html: htmlList,
                        
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Save this section'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            checkingUncheck();
                            document.getElementById('myForm').submit();
                            
                        }
                    })
                    
                  }




                  document.addEventListener('DOMContentLoaded', function () {
                    // Initialize DataTable
                    const dataTable = $('#example3').DataTable({
                        // Disable sorting for the first column
                        paging: false,
                        scrollY: '300px', // Adjust the height as needed
           
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
                        checkingUncheck();
                    });
                });


                function selectAllCheckboxes() {
                  countingChecks = 0;
                  var checkboxes = document.getElementsByClassName('checkbox');
                  var checkbox = document.getElementById('checkbox');


                  for (var i = 0; i < checkboxes.length; i++) {
                    
                      

                      if(!ArrayAll.hasOwnProperty(checkboxes[i].value)){
                        if(checkbox.checked == true){
                          checkboxes[i].checked = true;
                          countingChecks++;
                        }
                        else{
                          checkboxes[i].checked = false;
                        }
                        
                      }
                      
                    
                    
                    
                  }
                }
              
            </script>
              

             
            



            <br>
           
            <TEXtarea style="display:none" name="storingData" id="storingData"></TEXtarea>
            <div style="position:absolute; bottom:10px;  left: 10px; right: 10px">
            
              <button style="display: none; " onclick="confirm()" type="button" style="width:100%" class="btn btn-block btn-success" id="save_button" >Save</button>
              
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