@extends('admin.index_admin')


@section('titlePage') CCSTNexus | College curriculum @endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{$acadsNewVar}} College Curriculum</h1>
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
              
              <div class="card-header" class="sdadas" style="display: flex; gap: 10px; flex-wrap:wrap; ">
                <div class="dropdown" >
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      
                  Choose year
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      @foreach($dropdown as $value)
                        <a class="dropdown-item" href="{{route('admin.College_curriculum', ['year' => $value])}}">{{$value}}</a>
                      @endforeach
                  </div>
                </div>

                <h3 class="card-title"><a href="{{ route('admin.add_college_curriculum') }}"><button class="btn btn-block bg-gradient-primary">Add curriculum</button></a></h3>

       
                 
              </div>
              <form id="checkboxForm">
                  @csrf
              <div class="card-header" style="display:none" id="disable&delete" >
                  <div><span style="opacity:80%">Selected curriculum: <span id="countSelected"></span></span></div>
                  <div class=" card-header-flex gap-flex">
                    <h3 class="card-title"><button type="button" class="btn btn-block bg-gradient-danger " onclick="deleteAll('Admin password', 'deletingAll')">Delete all</button></h3>
                   
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example3" class="table-bordered table table-bordered table-striped">
                
                    <thead>
                    <tr>
                      
                      <th style="width: 2%"></th>
                      <th>Course</th>
                     
                      <!-- <th>Email</th> -->
                     
    
                      <th style="width: 2%">Action</th>
                      
                      
              
                    </tr>
                    </thead>
                    <tbody>
                    @php
                      $idLISTs = array();
                    @endphp
                    @foreach($departments as $data)
                      @php

                        $desiredItem = [ 'course' => '' ];
                        if($data->courseID != ""){
                          $datas = json_decode($course, true);

                          $desiredId = $data->courseID;
                          $found = false;

                          foreach ($idLISTs as $item) {
                              if ($item['id'] == $desiredId) {
                                  $found = true;
                                  break;
                              }
                          }

                          if (!$found) {
                              $desiredItem = collect($datas)->where('id', $desiredId)->first();
                              $idLISTs[] = ['id' => $desiredId, 'course' => $desiredItem['course'], 'AcadYearsEdited' => $data->AcadYearsEdited];
                          }
                          


                          
                        }
                        
                      @endphp
                    @endforeach

                    @foreach($idLISTs as $dataID)
                    
                      
                      <tr>
                          
                          <td>
                            @if($acadsNewVar == $dataID['AcadYearsEdited'])
                            <input type="checkbox" name="checkboxes[]" onclick="updateCount(this)" value="{{ $dataID['id'] }}">
                            @endif
                          </td>
                 
                          <td>{{ $dataID['course'] }} </td>
                       
                  
                          <td>
                            @if($acadsNewVar == $dataID['AcadYearsEdited'])
                            <div class="d-flex gap-flex">
                              @else
                              <div class="" style="text-align:center">
                            @endif
                              <a class="update a_gray"   title="Edit" href="{{ route('admin.editCourseCurriculum', ['id' => $dataID['id'], 'year' => $acadsNewVar ]) }}">
                                
                                @if($acadsNewVar == $dataID['AcadYearsEdited'])
                                  <i class="fas fa-pencil-alt"></i>
                                  @else
                                  <i class="fas fa-eye"></i>
                                @endif
                              </a>
                              @if($acadsNewVar == $dataID['AcadYearsEdited'])
                              <a class="update a_gray"   title="Delete" onclick="deleting_admin({{$dataID['id']}}, 'Admin password')">
                                <i class="fas delete fa-trash-alt"></i> 
                              </a>
                              @endif

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
        
        var newPageURL = "{{ route('admin.deleteCourseCurriculum', ['id' => 'PLACEHOLDER_ID', 'password' => 'PLACEHOLDER_PASS']) }}"
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
      
      
          url: "{{ url('admin/MultipledeleteCourseCurriculum') }}",
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
            var message =  result.success + " course/s has been deleted.";
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