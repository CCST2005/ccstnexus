@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | curriculum

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit {{ $curiculumnkn->course }} curriculum</h1>
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
              <div class="card-header" style="display:none" id="disable&delete" >
                  <div><span style="opacity:80%">Selected account: <span id="countSelected"></span></span></div>
                  <div class=" card-header-flex gap-flex">
                    <h3 class="card-title"><button type="button" class="btn btn-block bg-gradient-danger " onclick="deleteAll('Admin password', 'deletingAll')">Delete all</button></h3>
                   
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table class="table table-bordered table-hover text-center">
                <thead class="thead-dark">
                  @php
                    $countingloop = 0;
                  @endphp
                  <tr>
             
                    <th rowspan="2" class="align-middle">COURSE CODE</th>
                    <th rowspan="2" class="align-middle">DESCRIPTIVE TITLE</th>
                    
                      <th colspan="3">CREDITS</th>
                    
                  
                    <th rowspan="2" class="align-middle">ACTION</th>
                    
                  </tr>
                  <tr>
                    
                    <th>LEC</th>
                    <th>LAB</th>
                    <th>UNITS</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($curiculums as $pogi)
                  <tr style="background-color:#21252917 !important">
                   
                    <td><b>S.Y. {{$pogi['year']}}</b></td>
                    <td><b><i>{{$pogi['title']}}</i></b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                      
                    <td>
                      @if($acadsNewVar == $acads)
                      <div class="d-flex gap-flex">
                              <a class="update a_gray"   title="Edit" href="{{ route('admin.update_curriculum', ['id' => $pogi['id'], 'previous' => $previousID, 'year' => $acadsNewVar]) }}">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              @if(count($curiculums)-1 == $countingloop)
                              <a class="update a_gray"   title="Delete" onclick="deleting_admin({{$pogi['id']}}, 'Admin password')">
                                <i class="fas delete fa-trash-alt"></i> 
                              </a>
                              @endif

                            </div>
                       @endif
                    </td>
                   
              
                  </tr>
                    @if(count($pogi['subs']) == 0)
                      <tr>
                        
                        
                        <td style="text-align: !important;opacity: 60% !important">No data</td>
                        <td style="text-align: !important; opacity: 60% !important">No data</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td></td>
                      
                      

                      </tr>

                    @else
                      @foreach($pogi['subs'] as $subjects)
                      <tr>
                        
                      
                          <td style="text-align: !important">{{$subjects['code']}}</td>
                          <td style="text-align:left !important">{{$subjects['subject']}}</td>
                          <td>{{$subjects['lec']}}</td>
                          <td>{{$subjects['lab']}}</td>
                          <td>@php echo intval($subjects['lab']) + intval($subjects['lec']); @endphp</td>
                          <td></td>
                        
                        

                      </tr>
                      @endforeach
                    @endif
                    @php $countingloop++; @endphp
                  
                  @endforeach
                </tbody>
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
        
        var newPageURL = "{{ route('admin.delete_curriculum', ['id' => 'PLACEHOLDER_ID', 'password' => 'PLACEHOLDER_PASS', 'prev' => $previousID]) }}"
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
      
      
          url: "{{ url('admin/delete_multiple') }}",
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
            var message =  result.success + " Curriculum/s has been deleted.";
            var newPageURL = "{{ route('admin.delete_multiple_curriculum', ['title' => 'PLACEHOLDER_TITLE', 'icon' => 'PLACEHOLDER_ICON', 'text' => 'PLACEHOLDER_TEXT']) }}"
            .replace('PLACEHOLDER_TEXT', message)
            .replace('PLACEHOLDER_TITLE', 'Deleted successfully!')
            .replace('PLACEHOLDER_ICON', 'success');

            window.location.href = newPageURL;
            
          }

  
        });
        
        
      }


      function disablingAll(ids, password) {
        
      
        jQuery.ajax({
      
      
          url: "{{ url('admin/disable_multiple') }}",
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