@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | Choose student

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0">Choose student</h1>
            <p>{{$courseName}} / {{$semester}} / {{ $section }}</p>
            <a href='{{route("admin.sectioning")}}'>
                <button type="button" style="max-width:180px" class="btn btn-block btn-primary" id="submit_buttons">Select other section</button>
            </a>
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

            <div class="card limitScroll" style="flex:20%;height: 100%;">
            
              <div class="card-header">
             
                <h3 class="card-title" style="display:flex; justify-content:space-between; width: 100%">Choose student to add this section<span>S.Y. {{$acads}}</span></h3>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              
              <div class="" style="display:none" id="disable&delete" >
              <div><span style="opacity:80%">Selected student: <span id="countSelected"></span></span></div><br>
             
            </div>
              
                  
                 
              <script>
                var studentsInfo = {!! json_encode($studentsInfo) !!};
                
              </script>
         
              
              
               
              <form id="myForm" method="POST" action="{{ route('admin.adding_section_student') }}">
              @csrf
              <table id="example3" class="table-bordered table table-bordered table-striped">
                
                <thead>
                <tr>
                  
                  <th>Student no.</th>
                  <!-- <th>Email</th> -->
                  <th>Full name</th>
          
           
                  <th>Action</th>
                  
                  
          
                </tr>
                </thead>
                <tbody class="">
                
                @foreach($students as $data)
                
                 
                  
                 

                  <tr id="{{$data->id}}filling">
                      <input type="hidden" name="{{$data->id}}firstname" id="{{$data->id}}firstname" value="{{ $data->lastname }}, {{ $data->firstname }} @php if($data->middlename != ''){echo $data->middlename[0] . '.';}else{echo $data->middlename;} @endphp ">
                      <input type="hidden" name="{{$data->id}}studno" id="{{$data->id}}studno" value="{{ $data->student_no }}">
                      <input type="hidden" name="{{$data->id}}section" id="{{$data->id}}section" value="{{ $data->sectioning }}">
                      <td><label for="{{$data->id}}button">{{ $data->student_no }}</label></td>
                      <td><label for="{{$data->id}}button">{{ $data->lastname }}, {{ $data->firstname }} {{ $data->middlename }}</label></td>

                      <td><button type="button" style="width:100%" class="btn btn-block btn-success" id="submit_buttons" value="{{ strval($data->id) }}" onclick="filling(this);">Add</button></td>

                      
                      
                      
                  
          
                  </tr>

               


                  
             
                @endforeach
                </tbody>
              
              <tfoot>
           
              </tfoot>
            </table>
           
              
            


            
            <input type="hidden"  id="studentIDs" name="studentIDs" value="">
            <input type="hidden"  id="remarkINgs" name="remarks" value="{{ $sectionID  }}">
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
                <div style="flex:10%;display:none; justify-content:center;flex-wrap:wrap;gap:10px; max-width: 90px">
                      
                      <button type="button" style="width:100%" class="btn btn-block btn-success" id="submit_buttons" onclick="filling();">Add <i class="fas fa-chevron-right" style="font-size:12px"></i><i  style="font-size:12px" class="fas fa-chevron-right"></i></button>
                      <button type="button" style="width:100%;display:none" class="btn btn-block btn-danger" id="reset_buttons" onclick="deleteAllList();"><i class="fas fa-chevron-left"  style="font-size:12px"></i><i  style="font-size:12px" class="fas fa-chevron-left"></i> Reset</button>
                  </div>
              <div class="card limitScroll"  style="position:relative;flex:30%;height: 100%;">
              <div class="card-header">
                
                  <h3 class="card-title" style="justify-content: space-between;display:flex;width:100%"><span>Student information</span><span id="countedStudent"></span></h3>
                
                </div>

              <div class="card-body ">

              <span id="selectFirst" style="text-align:center;opacity:50%;width:100%;display:block">Select student first</span>
                  <div class="tableSelectedsff" id="tableSelectedsff" style="display:none">
                  <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Student no.</label>
                    <input type="text" class="form-control" id="stduentS" readonly placeholder="N/A">
                </div>
                
                  <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">First name</label>
                    <input type="text" class="form-control" id="fnames" readonly placeholder="N/A">
                </div>
                <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Middle name</label>
                    <input type="text" class="form-control" id="mnames" readonly placeholder="N/A">
                </div>
                <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="lnames" readonly placeholder="N/A">
                </div>
                <div class="mb-3">
                
                <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Birthday</label>
                    <input type="text" class="form-control" id="bdayS" readonly placeholder="N/A">
                </div>
                <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Birthplace</label>
                    <input type="text" class="form-control" id="BplaS" readonly placeholder="N/A">
                </div>
                <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Age</label>
                    <input type="text" class="form-control" id="ageS" readonly placeholder="N/A">
                </div>
                <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Sex</label>
                    <input type="text" class="form-control" id="sexS" readonly placeholder="N/A">
                </div>
                <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Address</label>
                    <input type="text" class="form-control" id="addS" readonly placeholder="N/A">
                </div>
                   
                
              
                
                
               
            
                        


            <script>
              var ArrayAll = {};
                        var countingChecks = 0;
              
              function filling(idStud){
                
                var tableRows = document.getElementsByTagName('tr');

                // Loop through each <tr> element
                for (var i = 0; i < tableRows.length; i++) {
                    // Set the style for each <tr> element
                    tableRows[i].style = "";
                   
                    // Add more styles as needed
                }


                var tr = document.getElementById(idStud.value + 'filling');
                tr.style = "background-color: #6c757d66";


                var idStud = idStud.value;
                var div = document.getElementById('tableSelectedsff');
                div.style = "diplay: block";

                var selectFirst = document.getElementById('selectFirst');
                selectFirst.innerHTML = "";

                var save_button = document.getElementById('save_button');
                save_button.value = idStud;
               


                var stduentS = document.getElementById('stduentS');
                var fnames = document.getElementById('fnames');
                var mnames = document.getElementById('mnames');
                var lnames = document.getElementById('lnames');
                var bdayS = document.getElementById('bdayS');
                var BplaS = document.getElementById('BplaS');
                var ageS = document.getElementById('ageS');
                var sexS = document.getElementById('sexS');
                var addS = document.getElementById('addS');

                stduentS.value = studentsInfo[idStud]['stduentS'];
                fnames.value = studentsInfo[idStud]['fnames'];
                mnames.value = studentsInfo[idStud]['mnames'];
                lnames.value = studentsInfo[idStud]['lnames'];
                bdayS.value = studentsInfo[idStud]['bdayS'];
                BplaS.value = studentsInfo[idStud]['BplaS'];
                ageS.value = studentsInfo[idStud]['ageS'];
                sexS.value = studentsInfo[idStud]['sexS'];
                addS.value = studentsInfo[idStud]['addS'];
                
            
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

              




              function confirm(studentsID){


                (async () => {
      


                    const { value: password } = await Swal.fire({
                        title: 'Add remarks',
                        input: 'text',
                        html: '' + 'optional' + '',
                        confirmButtonText: "Continue",
                        inputPlaceholder: 'Add remarks',
                        inputAttributes: {
                        maxlength: 30,
                        autocapitalize: 'off',
                        autocorrect: 'off',
                        
                        }
                    })

                    
                    Swal.fire({
                    title: "Are you sure you want to add this student?",
                    showDenyButton: false,
                    showCancelButton: true,
                    
                    confirmButtonText: "Yes, add this student",
                  
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var studentIDs = document.getElementById('studentIDs');
                        studentIDs.value = studentsID.value;
                    

                        var remarkINgs = document.getElementById('remarkINgs');

                        remarkINgs.value = password;
               


                     
                       document.getElementById('myForm').submit();
                    } 
                    });
                        


                       
                        
                    
                    
                
                })()
               
                         
                      
                    
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
            
              <button style="display: block; " onclick="confirm(this)" type="button" style="width:100%" class="btn btn-block btn-success" id="save_button" >Add this student</button>
              
            </div>
            
            </div>
              </div>
            </div>


            
              <!-- /.card-body -->
            </div>

            <!-- /.card -->
          </div>
          
          <div class="col-12 wrapping" style="">
            
            <!-- /.card -->

            <div class="card limitScroll" style="">
            
                    <div class="card-header">
                    
                        <h3 class="card-title" style="display:flex; justify-content:space-between; width: 100%">Student list<span></span></h3>
                    </div>
                    
                    <!-- /.card-header -->
                    <div class="card-body">

                        <h1>{{count($studSectionLIst)}} Student(s)</h1>
                        <button type="button" class="btn btn-block bg-primary" onclick="prints()" style="max-width: 150px; margin-bottom: 10px;display:flex;justify-content: center;align-items:center;gap:10px">Print section<i class="fas fa-print"></i></button>
                        <script>
                           function prints(){
                              var newTab = window.open("{{ route('admin.print_section_reports', ['semester' => $semesterID, 'year' => $acads, 'section' => $sectionID ]) }}", '_blank');
                              newTab.focus();
                          
                          }
                        </script>
                        <table id="example4" class="table-bordered table table-bordered table-striped">
                
                    <thead>
                    <tr>
               
                    <th style="display: none"></th>
                      <th>Student no.</th>
                      <!-- <th>Email</th> -->
                      <th>Last name</th>
                      <th>First name</th>
                      <th>Middle name</th>
                     
                      <th>Remarks</th>
                      <th style="width: 10%">Action</th>
                      
                      
              
                    </tr>
                    </thead>
                    <tbody>
         
                    @foreach($studSectionLIst as $data)
                    
                     
                      
                      
                      <tr>
                      
                          <td  style="display: none">{{ $data->creatingats }}</td>
                          
                          <td>{{ $data->student_no }}</td>
                          <td>{{ $data->lastname }}</td>
                          <td>{{ $data->firstname }}</td>
                          <td>{{ $data->middlename != '' ? $data->middlename : 'N/A'}}</td>
                      
                          

                          <td>{{ $data->remarkings }}</td>

                          <td>
                            <button type="button" class="btn btn-block bg-danger" onclick="deleteAll('Admin password', '{{$data->IDSectioning}}')"  style="max-width: 150px; margin-bottom: 10px;display:flex;justify-content: center;align-items:center;gap:10px">Remove</button> 
                          </td>
                          
                          
                      
              
                      </tr>
                 
                    @endforeach
                    </tbody>
                  
                  <tfoot>
               
                  </tfoot>
                </table>

                    </div>

            <!-- /.card -->
            </div>



            <!-- /.col -->
            </div>

          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>

          
          
       




      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <script>
    function deleteAll(wrongPassword, mode){
      
      (async () => {
      


        const { value: password } = await Swal.fire({
        title: 'Enter your password',
        input: 'password',
        html: '<b>' + wrongPassword + '</b>',
        confirmButtonText: "Continue",
        inputPlaceholder: 'Enter your password',
        inputAttributes: {
          maxlength: 30,
          autocapitalize: 'off',
          autocorrect: 'off',
          
        }
      })

      if (password) {

        var formData = $('#checkboxForm').serialize();

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
            if(trues != 'false'){

              var newPageURL = "{{ route('admin.deleteSectionStudents', ['id' => 'PLACEHOLDER_ID']) }}"
            .replace('PLACEHOLDER_ID', mode);
    
            window.location.href = newPageURL;
              
            }
            else{
              deleteAll('<span style="color:rgb(165, 73, 73)">Wrong password.</span>', mode);
            }
            
          }

  
        });
        
        
      }
      
  
      })()
    }
    $(document).ready(function() {
    // Initialize DataTable with sorting on the first column (index 0) in ascending order
    $('#example4').DataTable({
        "order": [[0, "desc"]]
    });
    });
  </script>
    @if (session('delete_success'))
    <script>
        $(document).ready(function () {
            
            
                Swal.fire({
                    title: "{{ session('delete_success')['title'] }}",
                    text: "{{ session('delete_success')['text'] }}",
                    icon: "{{ session('delete_success')['icon'] }}",
                });
            
        });
    </script>
@endif
@endsection