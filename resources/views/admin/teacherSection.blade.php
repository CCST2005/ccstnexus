@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | sections

@endsection

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <span>
                    <div title="Disable adding section for teacher" class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customSwitch3"  onclick="disablingAddSec(this)">
                      <label class="custom-control-label" for="customSwitch3"></label>
                    
                    </div>
                  </span></h3>

                
            <h1 class="m-0">Sections list</h1>
            <script>
                    function disablingAddSec(thisabling){
                      var SignIfEnabled =  document.getElementById('SignIfEnabled');
                        jQuery.ajax({
                  
                  
                                url: "{{ url('admin/disablingSectionTeacher') }}",
                                data: {
                                 
                                },
                                type: 'post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                          
                                success:function(result)
                                {
                  
                                  if(result.mode == 'disabled'){
                                    SignIfEnabled.style = "color: #e74c3c;text-decoration:underline";
                          SignIfEnabled.innerHTML = "disabled";
                                    thisabling.checked = false;
                                  }
                                  else{
                                    SignIfEnabled.style = "color: #00bc8c;text-decoration:underline";
                          SignIfEnabled.innerHTML = "enabled";
                                    thisabling.checked = true;
                                  }
                                
                  
                                
                                }
                          
                          
                        });
                    }
                  </script>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
             
          
                        var customSwitch3 =  document.getElementById('customSwitch3');
                        var SignIfEnabled =  document.getElementById('SignIfEnabled');
                        @if($checkDisableAdding == '1')
                        SignIfEnabled.style = "color: #e74c3c;text-decoration:underline";
                          SignIfEnabled.innerHTML = "disabled";
                          customSwitch3.checked = false;
                         
                        @else
                        SignIfEnabled.style = "color: #00bc8c;text-decoration:underline";
                          SignIfEnabled.innerHTML = "enabled";
                          customSwitch3.checked = true;
                          
                        @endif
                      });
                      </script>
            <p>Adding section for teacher is <span style="color: #00bc8c" id="SignIfEnabled"></span></p>
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
              
              <form id="checkboxForm">
                  @csrf
                  <div class="card-header"  >
                    <div class="dropdown">

                    <h3 class="card-title"  style="display:flex; align-items:center; justify-content:space-between; width: 100%">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        School year
                    </button>
                    
                    

                    
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($schools as $value)
                            <a class="dropdown-item" href="{{ route('admin.edit_section', ['academic' => $value]) }}">{{$value}}</a>
                        @endforeach
                        <a class="dropdown-item" href="{{ route('admin.edit_section', ['academic' => 'all']) }}">All</a>
                    </div>
                    </div>
                    
                    </div>
              </form>
              <div class="card-header" style="display:none" id="disable&delete" >
              
                  <div><span style="opacity:80%">Selected section: <span id="countSelected"></span></span></div>
                  <div class=" card-header-flex gap-flex">
                    <h3 class="card-title"><button type="button" class="btn btn-block bg-gradient-danger " onclick="deleteAll('Your password', 'deletingAll')">Delete all</button></h3>
                    
                  </div>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                @if($yearSelected == $currentYEAR && $countingDisabled != 0)
                <div style="display: !important; width: 100%; display:flex; justify-content: end; margin-bottom:10px"><button type="button" class="btn bg-gradient-secondary" id="" onclick="deleteAll('Admin password', 'disablingAll')"> Disable all</i></button></div>
                @endif
                
              <table id="example3" class="table table-bordered table-striped">
                
                    <thead>
                    <tr>
                      
                      
                      <th>Section</th>
                      <!-- <th>Email</th> -->
                      <th>Subject</th>
                      
                      <th>Semester</th>
                      <th>Teacher</th>
                      <th>School year</th>
                      <th>Students</th>
                      <th>Status</th>
                  
                      <th style="width: 10%">Action</th>
                      
                      
              
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($existingEmployeeCode as $data)
                   
                      <tr>
                  
                         
                          
                          <td>{{ $section[$data->section_id] }}</td>
                          <td>{{ $subject[$data->subject_id]}}</td>
                          <td>@if($data->semester == 1) {{ "1ST SEMESTER" }} @else {{ "2ND SEMESTER" }} @endif</td>
                          <td>{{ $AdminTeacher[$data->owner_id] }}</td>
                          <td>{{ $data->academic_year }}</td>
                         
                          <td><a href="{{ route('admin.upload_finals', ['id' => $data->id ]) }}"><button type="button" onclick="nextPagingLoading()" class="btn btn-block btn-info">View</button></a> </td>
                         
                            @if($data->editTable == '1')
                            <td id="{{ $data->id }}Status"  >Enabled</td>

                        

                            <td><button type="button" id="{{ $data->id }}Actions" class="btn btn-block btn-primary" onclick="disablings('{{ $data->id }}')" value="{{ $data->id }}">
                              <span id="{{ $data->id }}Loadings" style="display: none"><i  class="fas fa-spinner spinnings"></i></span>
                              <span id="{{ $data->id }}DisableText" >Disable</span>
                            </button></td>
                            @else
                            <td id="{{ $data->id }}Status" >Disabled</td>

                          

                          </td>
                            <td><button type="button" id="{{ $data->id }}Actions" class="btn btn-block btn-success" onclick="disablings('{{ $data->id }}')" value="{{ $data->id }}">
                              <span id="{{ $data->id }}Loadings" style="display: none"><i  class="fas fa-spinner spinnings"></i></span>
                              <span id="{{ $data->id }}DisableText" >Enable</span>
                            </button></td>
                            @endif
                          
                      
              
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
                 document.addEventListener('DOMContentLoaded', function () {
                    // Initialize DataTable
                    const dataTable = $('#example3').DataTable({
                        // Disable sorting for the first column
                        paging: false,
                        
           
                      
                    });

                  
                  
                });
              </script>
  <script>
   


  
      function disablings(idsus){
        var DisableText =  document.getElementById(idsus + 'DisableText');
        var Loadings =  document.getElementById(idsus + 'Loadings');
        var Actions =  document.getElementById(idsus + 'Actions');
        var Status =  document.getElementById(idsus + 'Status');
        var IDsection = idsus;
        DisableText.style.display = "none";
        Loadings.style.display = "block";

        jQuery.ajax({
                
          
              url: "{{ url('admin/disableSections') }}",
              data: {
                  id: IDsection,
              },
              type: 'post',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
        
              success:function(result)
              {

                if(result.mode == 'disabled'){
                  Actions.classList.add("btn-success");
                  Actions.classList.remove("btn-primary");
                  Status.innerHTML = 'Disabled';
                  DisableText.style.display = "block";
                  DisableText.innerHTML = 'Enable';
                  Loadings.style.display = "none";
                }
                else{
                  Actions.classList.remove("btn-success");
                  Actions.classList.add("btn-primary");
                  Status.innerHTML = 'Enabled';
                  DisableText.innerHTML = 'Disable';
                  DisableText.style.display = "block";
                  Loadings.style.display = "none";
                }
               

               
              }
        
        
            });
      }






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
            
            
                url: "{{ url('teacher/checkpassword') }}",
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
        
        var newPageURL = ""
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
                
                disablingAll(trues);
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

    function disablingAll(password) {
        
      
        jQuery.ajax({
      
      
          url: "{{ url('admin/disable_multiple_TeacherSection') }}",
          data: {
              password: password,
              year: '{{ $yearSelected }}',
          },
          type: 'post',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          success:function(result)
          {
            var message =  result.success + " section(s) has been disabled.";
            var newPageURL = "{{ route('admin.success_message', ['title' => 'PLACEHOLDER_TITLE', 'icon' => 'PLACEHOLDER_ICON', 'text' => 'PLACEHOLDER_TEXT']) }}"
            .replace('PLACEHOLDER_TEXT', message)
            .replace('PLACEHOLDER_TITLE', 'Disabled successfully!')
            .replace('PLACEHOLDER_ICON', 'success');

            window.location.href = newPageURL;
            
          }

  
        });
        
        
      }

   function deletingAll(ids, password) {
        
      
        jQuery.ajax({
      
      
          url: "{{ url('teacher/delete_multiple_section') }}",
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
            var message =  result.success + " section/s has been deleted.";
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