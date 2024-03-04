@extends('teacher.index_teacher')


@section('titlePage') CCSTNexus | Student list @endsection

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
       
              
              <form id="checkboxForm">
                  @csrf
           
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example3" class="table-bordered table table-bordered table-striped">
                
                    <thead>
                    <tr>
            
                      
                      <th>Student no.</th>
                      <!-- <th>Email</th> -->
                      <th>First name</th>
                      <th>Middle name</th>
                      <th>Last name</th>
                      <th>Course</th>
                      <th>Section</th>
                
                    
                
            
                      
              
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($students as $data)
                  
                      
                      <tr>
                    
                         
                          
                          <td>{{ $data->student_no }}</td>
                          <td>{{ $data->firstname }} </td>
                          <td>{{ $data->middlename != '' ? $data->middlename : 'N/A'}}</td>
                          <td>{{ $data->lastname }}</td> 
                       

                          <td>{{ $course[$data->id] }}</td>
                          <td>{{ $sectioning[$data->id] }}</td>
                  
                  
                   
                     
                          
                          
                      
              
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
                        ]
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