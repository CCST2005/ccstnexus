@extends('admin.index_admin')


@section('titlePage') CCSTNexus | Section @endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Section List</h1>
            <p>{{$yearID}}{{$courseName}}{{$semesterName}}</p>
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
              <div class="card-header"  style="display: flex; gap: 10px; flex-wrap: wrap" >
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
                
                <div>
                  <select onchange="checkEmpties()" name="sem" id="sem" class="form-control">
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
                <div>
                  <button type="button" style="display: none" onclick="gotoLink()" id="SearchButts" class="btn btn-block btn-primary">Search</button>
                </div>

              
        
            <script>
            
              var sectioningsfg = {
               
              };
         
              function sectionSelected(values){
                
                
              }
              function checkEmpties(){
                var sy = document.getElementById('sy');
                var course = document.getElementById('course');
     
                var SearchButts = document.getElementById('SearchButts');


                if(sy.value != ''  && course.value != '' ){
                  SearchButts.style = "display: ";
           
                }
                else{
                  SearchButts.style = "display: none";
                }



              }
              $(document).ready(function() {
                $('.js-example-basic-single').select2();
             });

             function gotoLink(){
              var sy = document.getElementById('sy');
              var course = document.getElementById('course');
              var semester = document.getElementById('sem');
              var newPageURL = "{{ route('admin.section', ['department' => 'PLACEHOLDER_DEPARTMENT', 'year' => 'PLACEHOLDER_YEAR', 'semester' => 'PLACEHOLDER_SEMESTER', 'course' => 'PLACEHOLDER_COURSE']) }}"
              .replace('PLACEHOLDER_DEPARTMENT', '{{$departmentID}}')
              .replace('PLACEHOLDER_YEAR', sy.value)
              .replace('PLACEHOLDER_SEMESTER', semester.value)
              .replace('PLACEHOLDER_COURSE', course.value);

              window.location.href = newPageURL;
             }
            </script>
            </div>
            <div class="card-header"  style="display: flex; gap: 10px; flex-wrap: wrap" >
                <h3 class="card-title"><a href="{{ route('admin.add_section', ['department' => $departmentID,'year' => $yearID ,'semester' => $semID ,'course' => $courseID  ]) }}"><button class="btn btn-block bg-gradient-primary">Add section</button></a></h3>
                
              </div>
              <form id="checkboxForm">
                  @csrf
              <div class="card-header" style="display:none" id="disable&delete" >
                  <div><span style="opacity:80%">Selected section: <span id="countSelected"></span></span></div>
                  <div class=" card-header-flex gap-flex">
                    <h3 class="card-title"><button type="button" class="btn btn-block bg-gradient-danger " onclick="deleteAll('<span>Deleting a section has implications on various components, including the deactivation of accounts for students linked to the deleted section.</span><br><br>Admin password', 'deletingAll')">Delete all</button></h3>
                   
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example3" class="table-bordered table table-bordered table-striped">
                
                    <thead>
                    <tr>
                      <th style="width: 2%"></th>
                      
                      <th>Section</th>
                      <!-- <th>Email</th> -->
                      <th>Academic program</th>
                      <th>Semester</th>
                      <th>Description</th>
                      
                      <th style="width: 2%">Action</th>
                      
                      
              
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($departments as $data)
                    
                      @if($data->disabled == '1')
                      
                      <tr style="color:gray">
                      @else
                      <tr>
                      @endif
                          <td><input type="checkbox" name="checkboxes[]" onclick="updateCount(this)" value="{{ $data->id }}"></td>
                          
                          <td>{{ $data->section }}</td>
                          <td>{{ $id_name_depart["'" . $data->id . "'"] }}</td>
                          @if($data->semester == 1)
                            @php $semesters = '1st semester'; @endphp
                          @else
                            @php $semesters = '2nd semester'; @endphp
                          @endif

                          <td>{{ $semesters }}</td>
                          <td > @if($data->desc > 1){{$data->desc}} @else {{'No description'}} @endif </td>
                          
    
                  
                          <td>
                            <div class="d-flex gap-flex">
                              <a class="update a_gray"   title="Edit" href="{{ route('admin.update_section', ['id' => $data->id ,'year' => $yearID ,'semester' => $semID ,'course' => $courseID  ]) }}">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              
                              <a class="update a_gray"   title="Delete" onclick="deleting_admin({{$data->id}}, '<span>Deleting a section has implications on various components, including the deactivation of accounts for students linked to the deleted section.</span><br><br>Admin password');deletingValsWarn()">
                                <i class="fas delete fa-trash-alt"></i> 
                              </a>
                   

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
        
        var newPageURL = "{{ route('admin.delete_section', ['id' => 'PLACEHOLDER_ID', 'password' => 'PLACEHOLDER_PASS', 'department' => 'PLACEHOLDER_DEPT']) }}"
      .replace('PLACEHOLDER_ID', values[1])
      .replace('PLACEHOLDER_PASS', values[0])
      .replace('PLACEHOLDER_DEPT', '{{$departmentID}}');

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
      
      
          url: "{{ url('admin/delete_multiple_section') }}",
          data: {
              idDept: '{{$departmentID}}',
              password: password,
              id: ids,
          },
          type: 'post',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          success:function(result)
          {
            var message =  result.success + " department/s has been deleted.";
            var newPageURL = "{{ route('admin.success_message', ['title' => 'PLACEHOLDER_TITLE', 'icon' => 'PLACEHOLDER_ICON', 'text' => 'PLACEHOLDER_TEXT']) }}"
            .replace('PLACEHOLDER_TEXT', message)
            .replace('PLACEHOLDER_TITLE', 'Deleted successfully!')
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