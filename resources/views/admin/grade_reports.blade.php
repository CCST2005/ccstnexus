@extends('admin.index_admin')


@section('titlePage') CCSTNexus | Grade reports @endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Student list</h1>
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
            <form id="checkboxForm" action="" method="GET">
                  @csrf
                  <div class="card-header" style="display: flex; gap: 10px; flex-wrap: wrap" >
                        <div class="dropdown">
                          <select onchange="checkEmpties()" class="js-example-basic-single" style="min-width: 140px" id="sy" name="sy">
                            <option value="">Select year</option>
                          
                            @foreach($dropdownyearing as $year)
                                 @php
                                  if($year == $yearID){
                                    $selected = 'selected';
                                  }
                                  else{
                                    $selected = '';
                                  }

                                @endphp
                                <option {{$selected}} value="{{$year}}">{{$year}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div>
                          <select onchange="blankCourseSection();checkEmpties();" name="sem" id="semester" class="form-control">
                            @php
                              if($semID == 1){
                                $selected1 = 'selected';
                                $selected2 = '';
                              }
                              else {
                                $selected2 = 'selected';
                                $selected1 = '';
                              }
                            

                            @endphp
                            <option {{$selected1}} value="1">1st semester</option>
                            <option {{$selected2}} value="2">2nd semester</option>
                          </select>
                        </div>
                        <div class="dropdown">
                          <select onchange="sectionSelected(this);checkEmpties();" class="js-example-basic-single" style="min-width: 250px" id="course" name="course">
                            <option value="">Select course</option>
                          
                            @foreach($dropdownlistCourse as $year)
                                @php
                                  if($year[0] == $courseID){
                                    $selected = 'selected';
                                  }
                                  else{
                                    $selected = '';
                                  }

                                @endphp
                                <option {{$selected}} value="{{$year[0]}}">{{$year[1]}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="dropdown">
                          <select onchange="checkEmpties()" class="js-example-basic-single" style="min-width: 150px" id="section" name="section">
                            <option value="">Select section</option>
                          
                            
                          </select>
                        </div>
                        
                        <div>
                          <button type="submit" style="display: none" id="SearchButts" class="btn btn-block btn-primary">Search</button>
                        </div>

                      
                    </div>
                    <script>
                    function blankCourseSection(){
                      var sectionSelect = document.getElementById('section');
                      var course = document.getElementById('course');
                      sectionSelect.innerHTML = '<option value="">Select section</option>';
                      course.selectedIndex = 0;
                    }
                    var sectionings2ndsem = {
                        @foreach($dropdownlistCourse as $CourseId)
                          "{{$CourseId[0]}}": 
                          [
                            @foreach($dropdownlistAdminSection2ndSem as $sections)
                              @if($sections[0] == $CourseId[0])
                                {'section': ["{{$sections[1]}}", "{{$sections[2]}}"]},
                              @endif
                            @endforeach
                          ],
                        @endforeach
                      };


                      var sectionings1stSem = {
                        @foreach($dropdownlistCourse as $CourseId)
                          "{{$CourseId[0]}}": 
                          [
                            @foreach($dropdownlistAdminSection1stSem as $sections)
                              @if($sections[0] == $CourseId[0])
                                {'section': ["{{$sections[1]}}", "{{$sections[2]}}"]},
                              @endif
                            @endforeach
                          ],
                        @endforeach
                      };
                 
                      function sectionSelected(values){
                        var semester  = document.getElementById('semester');
                        var sectionSelect = document.getElementById('section');
                        sectionSelect.innerHTML = '';

                        if(semester.value == 1){
                          var value = sectionings1stSem[values.value];
                        }
                        else{
                          var value = sectionings2ndsem[values.value];
                        }
                        
                        if (value) {
                         
                          value.forEach(function(section) {
                                var option = document.createElement('option');
                                option.value = section['section'][1];
                                option.textContent = section['section'][0];
                                sectionSelect.appendChild(option);
                            });
                        }
                        else {
                          sectionSelect.innerHTML = '<option value="">Select section</option>';
                          }
                      }
                      function checkEmpties(){
                        var sy = document.getElementById('sy');
                        var course = document.getElementById('course');
                        var section = document.getElementById('section');
                        var SearchButts = document.getElementById('SearchButts');


                        if(sy.value != '' && section.value != ''  && course.value != '' ){
                          SearchButts.style = "display: ";
                   
                        }
                        else{
                          SearchButts.style = "display: none";
                        }



                      }
                      $(document).ready(function() {
                        $('.js-example-basic-single').select2();
                    });
                    </script>
              </form>
              
              <form id="checkboxForm">
                  @csrf
              <div class="card-header" style="display:none" id="disable&delete" >
                  <div><span style="opacity:80%">Selected account: <span id="countSelected"></span></span></div>
                  <div class=" card-header-flex gap-flex">
                    <h3 class="card-title"><button type="button" class="btn btn-block bg-gradient-danger " onclick="deleteAll('Admin password', 'deletingAll')">Delete all</button></h3>
                    <h3 class="card-title"><button type="button" class="btn btn-block bg-gradient-secondary  " onclick="deleteAll('Admin password', 'disablingAll')">Disable all</button></h3>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                @if($yearName || '' && $courseName || '' && $sectionName || '')
                   <script>
                      $(document).ready(function() {
                        
                        var course = document.getElementById('course');
                        var semester = document.getElementById('semester');
                        var sectionSelect = document.getElementById('section');
                        
                       

                        if(semester.value == 1){
                          var value = sectionings1stSem[course.value];
                        }
                        else{
                          var value = sectionings2ndsem[course.value];
                        }


                        if (value) {
                         
                          value.forEach(function(section) {
                                var option = document.createElement('option');
                                if('{{$sectionID}}' == section['section'][1]){
                                  option.selected = true;
                                }
                                option.value = section['section'][1];
                                option.textContent = section['section'][0];
                                sectionSelect.appendChild(option);
                            });
                        }
                        else {
                          sectionSelect.innerHTML = '<option value="">Select section</option>';
                          }

                    });
                   </script>
                    @endif
              
                <table id="example3" class="table-bordered table table-bordered table-striped">
                
                    <thead>
                    <tr>
            
                      
                      <th>Student no.</th>
                      <!-- <th>Email</th> -->
                      <th>Full name</th>
                      <th>Course</th>
                      <th>Section</th>
      
                    
                      <th style="width: 8%"></th>
            
                      
              
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($students as $data)
                  
                      
                      <tr>
                    
                         
                          
                          <td>{{ $data->student_no }}</td>
                          <td>{{ $data->lastname }}, {{ $data->firstname }} {{ $data->middlename != '' ? $data->middlename : ''}}</td>
                       

                          <td>{{ $course[$data->id] }}</td>
                          <td>{{ $sectioning[$data->id] }}</td>
                 
                  
                          <td>
                 
                            <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                View grades
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" target="_blank"  title="Edit" href="{{ route('admin.grade_reports_picked', ['year' => $yearID, 'semester' => $semID, 'id' => $data->id, 'course' => $courseID, 'printable' => '0', 'mode' => '1', 'section' => $sectionID]) }}">
                                  Report card   
                                </a>
                              <a class="dropdown-item"  target="_blank" title="Edit" href="{{ route('admin.reports_of_grades', ['id' => $data->id, 'mode' => '2', 'year' => $yearName  ]) }}">
                                 Copy of grades
                                </a>
                               
                            </div>
                            </div>
                             
                              
                        
                          </td>
                     
                          
                          
                      
              
                      </tr>
                 
                    @endforeach
                    </tbody>
                  
                  <tfoot>
               
                  </tfoot>
                </table>
              </div>
              </form>

              <script>
                 document.addEventListener('DOMContentLoaded', function () {
                    // Initialize DataTable
                    const dataTable = $('#example3').DataTable({
                        // Disable sorting for the first column
                        paging: false,
                       
           
                        order: [[1, 'asc']], 
                        columnDefs: [
                            { targets: [0], orderable: false }
                        ],
                        responsive: true, 
                    });

                  
                  
                });
              </script>
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

  <script>
   
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    function deleting_admin(id_admin, wrongPassword)
      {
        var trues = "";
        
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
      const values = [encodeURIComponent(password), id];
      

      if(password != 'false'){
        
        var newPageURL = "{{ route('admin.delete_registrar', ['id' => 'PLACEHOLDER_ID', 'password' => 'PLACEHOLDER_PASS']) }}"
      .replace('PLACEHOLDER_ID', values[1])
      .replace('PLACEHOLDER_PASS', values[0]);

        window.location.href = newPageURL;
      }
      else{
        deleting_admin(id, '<span style="color:rgb(165, 73, 73)">Wrong password.</span>');
      }
    }


   
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

              if(mode == 'deletingAll'){
                deletingAll(formData, trues);
              }
              else if(mode == 'disablingAll'){
                
                disablingAll(formData, trues);
              }
              
            }
            else{
              deleteAll('<span style="color:rgb(165, 73, 73)">Wrong password.</span>', mode);
            }
            
          }

  
        });
        
        
      }
      
  
      })()
    }

   

   function deletingAll(ids, password) {
        
      
        jQuery.ajax({
      
      
          url: "{{ url('admin/delete_multiple_registrar') }}",
          data: {
              password: password,
              id: ids,
          },
          type: 'post',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          success:function(result)
          {
            var message =  result.success + " account/s has been deleted.";
            var newPageURL = "{{ route('admin.success_message', ['title' => 'PLACEHOLDER_TITLE', 'icon' => 'PLACEHOLDER_ICON', 'text' => 'PLACEHOLDER_TEXT']) }}"
            .replace('PLACEHOLDER_TEXT', message)
            .replace('PLACEHOLDER_TITLE', 'Deleted successfully!')
            .replace('PLACEHOLDER_ICON', 'success');

            window.location.href = newPageURL;
            
          }

  
        });
        
        
      }


      function disablingAll(ids, password) {
        
      
        jQuery.ajax({
      
      
          url: "{{ url('admin/disable_multiple_registrar') }}",
          data: {
              password: password,
              id: ids,
          },
          type: 'post',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          success:function(result)
          {
            var message =  result.success + " account/s has been disabled.";
            var newPageURL = "{{ route('admin.success_message', ['title' => 'PLACEHOLDER_TITLE', 'icon' => 'PLACEHOLDER_ICON', 'text' => 'PLACEHOLDER_TEXT']) }}"
            .replace('PLACEHOLDER_TEXT', message)
            .replace('PLACEHOLDER_TITLE', 'Disabled successfully!')
            .replace('PLACEHOLDER_ICON', 'success');

            window.location.href = newPageURL;
            
          }

  
        });
        
        
      }


      
    
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

    @if (session('message'))
        <script>
            $(document).ready(function () {
                
                
                    Swal.fire({
                        title: "{{ session('message')['title'] }}",
                        text: "{{ session('message')['text'] }}",
                        icon: "{{ session('message')['icon'] }}",
                    });
                
            });
        </script>
    @endif
@endsection