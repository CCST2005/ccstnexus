@extends('teacher.index_teacher')



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
            <h1 class="m-0">Sections list</h1>
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
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        School year
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($schools as $value)
                            <a class="dropdown-item" href="{{ route('teacher.edit_section', ['academic' => $value]) }}">{{$value}}</a>
                        @endforeach
                        <a class="dropdown-item" href="{{ route('teacher.edit_section', ['academic' => 'all']) }}">All</a>
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

              <div class="card-body">

              
                    <h1 style="padding: 0px; margin: 0px">{{ count($existingEmployeeCode ) }} Subject(s)</h1>
                    <div style="display: flex; gap: 0px">

                    <p style="padding: 0px; margin: 0px;display:flex; font-size:15px; align-items:center; gap:5px ">
                        <span style="height:10px !important; width:10px !important; background-color: #00bc8c"></span>DONE: <span id="INCf"></span></p>


   

                    </div>
                  

             
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
           
              <table id="example3" class="table table-bordered table-striped">
                
                    <thead>
                      
                    <tr>
                      
                    <th>#</th>
                      <th>Section</th>
                      <!-- <th>Email</th> -->
                      <th>Subject</th>
                      
                      
                      <th>Academic program</th>
                      <th>Semester</th>
                      <th>School year</th>
                   
                      <th>Students</th>
                      
                      <th style="width: 2%">Action</th>
                      
                      
              
                    </tr>
                    </thead>
                    <tbody>
                    @php  
                    $countingSuccess = 0;
                    $countingSubst = 0;
                    @endphp
                    @foreach($existingEmployeeCode as $data)
                   
                    @if($data->editTable != '1')
                    <tr style="color:gray">
                    @elseif($data->done == '1')
                    @php  
                    $countingSuccess++;
                    @endphp
                    <tr style="color:#00bc8c">
                    @else
                    <tr>
                    @endif
                          @php  
                          $countingSubst++;
                          @endphp
                  
                         
                          <td>{{$countingSubst}}</td>
                          <td>{{ $section[$data->section_id] }}</td>
                          <td>{{ $subject[$data->subject_id]}}</td>
                       
                          <td>{{ $course[$data->course_id] }}</td>
                          <td>@if($data->semester == 1) {{ "1ST SEMESTER" }} @else {{ "2ND SEMESTER" }} @endif</td>
                          <td>{{ $data->academic_year }}</td>
            
                          <td><a href="{{ route('teacher.upload_finals', ['id' => $data->id ]) }}"><button onclick="nextPagingLoading()" type="button" class="btn btn-block btn-success" value="{{ $data->id }}">View</button></a></td>
                        
                          @if($data->editTable == '1')
                          <td>
                            <div class="d-flex gap-flex">
                              <a class="update a_gray"  onclick="nextPagingLoading()" title="Edit" href="{{ route('teacher.update_section', ['id' => $data->id ]) }}">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              
                              <a class="update a_gray"   title="Delete"  onclick="deleting_admin('{{$data->id}}', 'Your password')">
                                <i class="fas delete fa-trash-alt"></i> 
                              </a>
                              

                            </div>
                          </td>
                          @else
                            <td>
                              <div class="d-flex gap-flex">
                                <a class="update a_gray"   title="Edit" onclick="disbaledS()">
                                  <i class="fas fa-pencil-alt"></i>
                                </a>
                                
                                <a class="update a_gray"   title="Delete" onclick="disbaledS()">
                                  <i class="fas delete fa-trash-alt"></i> 
                                </a>
                                

                              </div>
                            </td>


                          @endif
                          
                      
              
                      </tr>
             
                    @endforeach
                    </tbody>
             

                    <script>
                      function disbaledS(){
                        Swal.fire({
                          title: "Oops!",
                            text: "This section is disabled.",
                            icon: "error"
                          });
                      }
                    </script>
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
                        
           
                        
                        
                    });

                    var INCf = document.getElementById('INCf');
                    INCf.innerHTML = "{{$countingSuccess}}";
                  
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
        
        var newPageURL = "{{ route('teacher.delete_section', ['id' => 'PLACEHOLDER_ID', 'password' => 'PLACEHOLDER_PASS']) }}"
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
            var newPageURL = "{{ route('teacher.success_message', ['title' => 'PLACEHOLDER_TITLE', 'icon' => 'PLACEHOLDER_ICON', 'text' => 'PLACEHOLDER_TEXT']) }}"
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