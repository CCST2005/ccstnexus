@extends('admin.index_admin')


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
                  <div class="card-header"  style="display: flex; gap: 5px">
                    <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                       {{$semesterDisplay}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"style="overflow-y: auto;max-height: 400px;">
                        @foreach($dropdowns as $value)
                            <a class="dropdown-item" href="{{ route('admin.studentlist_reports', ['year' => $value['academic_year'], 'sems' => $value['semester'], 'sec' => $value['section']]) }}">{{$value['name']}}</a>
                        @endforeach
                    </div>
                    </div>

                    <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                       {{$sectionsDisplay}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="overflow-y: auto;max-height: 400px;">
                        @foreach($dropdownsSEction as $value)
                            <a class="dropdown-item" href="{{ route('admin.studentlist_reports', ['year' => $value['academic_year'], 'sems' => $value['semester'], 'sec' => $value['section']]) }}">{{$value['name']}}</a>
                        @endforeach
                        <a class="dropdown-item" href="{{ route('admin.studentlist_reports', ['year' => $acads, 'sems' => $semesterID, 'sec' => 'original']) }}">All</a>

                    </div>
                    </div>
                    </div>
              </form>

              
              
              <form id="checkboxForm">
                  @csrf
             
                     
            
              
              <!-- /.card-header -->
              <div class="card-body">
                    @if($semesterID != 'original' && $acads != 'original')
                      <button type="button" class="btn btn-block bg-primary" onclick="prints()" style="max-width: 160px; margin-bottom: 10px;display:flex;justify-content: center;align-items:center;gap:10px">Print student(s)<i class="fas fa-print"></i></button>
                      <script>
                        function checkingsing(tags){
                          tags.checked = true;
                        }
                        
                          function prints(){
                          
                            Swal.fire({
                              title: 'Select what column to print',
                              
                              html: `

                                <div style="text-align: left !important;padding-left: 10px;padding-right: 10px">
                                <input type="checkbox" onclick="checkingsing(this)" checked  value="">
                                  <label>Student no.</label><br>
                                  <input type="checkbox" onclick="checkingsing(this)" checked  value="">
                                  <label>Full name</label><br>
                                  <input type="checkbox" onclick="checkingsing(this)" checked  value="">
                                  <label>Civil status</label><br>
                                  <input type="checkbox" onclick="checkingsing(this)" checked  value="">
                                  <label>Academic program</label><br>
                                  <input type="checkbox" onclick="checkingsing(this)" checked  value="">
                                  <label>Section</label><br>

                                  <input type="checkbox" id="option1" name="option1" value="Option 1">
                                  <label for="option1">Gender</label><br>

                                  <input type="checkbox" id="option2" name="option2" value="Option 2">
                                  <label for="option2">Birthday and Birthplace</label><br>

                                  <input type="checkbox" id="option3" name="option3" value="Option 3">
                                  <label for="option3">Address</label><br>



                                  <input type="checkbox" id="option4" name="option4" value="Option 2">
                                  <label for="option4">Citizenship</label><br>
                                  
                                  <input type="checkbox" id="option5" name="option5" value="Option 3">
                                  <label for="option5">Remarks</label><br>

                            

                                </div>
                              `,
                              showCancelButton: true,
                              confirmButtonText: 'Proceed',
                              cancelButtonText: 'Cancel',
                              focusConfirm: false,
                              preConfirm: () => {
                                const selected = [];
                                if (document.getElementById('option1').checked) {
                                  selected.push('a');
                                }
                                if (document.getElementById('option2').checked) {
                                  selected.push('b');
                                }
                                if (document.getElementById('option3').checked) {
                                  selected.push('c');
                                }
                                
                                if (document.getElementById('option4').checked) {
                                  selected.push('d');
                                }
                                if (document.getElementById('option5').checked) {
                                  selected.push('e');
                                }
                              


                                return selected;
                              }
                            }).then((result) => {
                              if (result.isConfirmed) {
                                
                                var newTab = window.open("{{ route('admin.print_student_reports', ['semester' => $semesterID, 'year' => $acads, 'section' => $sectionID ]) }}"  + "?selection=" + JSON.stringify(result.value), '_blank');
                              newTab.focus();
                              }
                            });

                        
                          



                            // var newTab = window.open("{{ route('admin.print_student_reports', ['semester' => $semesterID, 'year' => $acads, 'section' => $sectionID ]) }}", '_blank');
                            // newTab.focus();
                        
                        }
                      </script>
                    @else

                      @php 
                        $studentsf = array();
                      @endphp
                    @endif
                <table id="example1" class="table-bordered table table-bordered table-striped">
                
                    <thead>
                    <tr>
            
                      
                      <th>Student no.</th>
                      <!-- <th>Email</th> -->
                      <th>Last name</th>
                      <th>First name</th>
                      <th>Middle name</th>
                      <th>Gender</th>
                      <th>Birthday</th>
              
                      <th>Citizenship</th>
                      <th>Civil status</th>
                      <th>Region</th>
                      <th>Province</th>
                      <th>City</th>
                      <th>Barangay</th>
                      <th>House number/Street</th>
                      <th>Contact No.</th>
                      <th>Guardian first name</th>
                      <th>Guardian middle name</th>
                      <th>Guardian last name</th>
                      <th>Guardian contact no.</th>
                      <th>Course</th>
                      <th>Section</th>
                      <th>Semester</th>
                      <th>Remarks</th>
                    
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($studentsf as $datas)
                      @php 
                      $middles = $datas->middlename != '' ? $datas->middlename : '';
                      @endphp
                      <tr>
                        <td>{{$datas->student_no}}</td>
                        <td>{{$datas->lastname}}</td>
                        <td>{{$datas->firstname}}</td>
                        <td>{{$middles}}</td>
                        <td>{{ $datas->sex }}</td>
                        <td>{{ $datas->birth_month }}/{{ $datas->birth_day }}/{{ $datas->birth_year }}</td>
                    
                        @php 
                          $datas->citizenship = $datas->citizenship != '' && $datas->citizenship != 'EmptyN/A' ? $datas->citizenship : 'N/A';
                        @endphp
                        <td>{{$datas->citizenship}}</td>
                        @php 
                          $datas->sivil_status = $datas->sivil_status != '' && $datas->sivil_status != 'EmptyN/A' ? $datas->sivil_status : 'N/A';
                        @endphp
                        <td>{{$datas->sivil_status}}</td>
                        @php 
                          $datas->region = $datas->region != '' && $datas->region != 'EmptyN/A' ? $datas->region : 'N/A';
                        @endphp
                        <td>{{$datas->region}}</td>
                        @php 
                          $datas->province = $datas->province != '' && $datas->province != 'EmptyN/A' ? $datas->province : 'N/A';
                        @endphp
                        <td>{{$datas->province}}</td>
                        @php 
                          $datas->city = $datas->city != '' && $datas->city != 'EmptyN/A' ? $datas->city : 'N/A';
                        @endphp
                        <td>{{$datas->city}}</td>
                        @php 
                          $datas->barangay = $datas->barangay != '' && $datas->barangay != 'EmptyN/A' ? $datas->barangay : 'N/A';
                        @endphp
                        <td>{{$datas->barangay}}</td>
                        @php 
                          $datas->block_lot = $datas->block_lot != '' && $datas->block_lot != 'EmptyN/A' ? $datas->block_lot : 'N/A';
                        @endphp
                        <td>{{$datas->block_lot}}</td>
                        @php 
                          $datas->ContactNo = $datas->ContactNo != '' && $datas->ContactNo != 'EmptyN/A' ? $datas->ContactNo : 'N/A';
                        @endphp
                        <td>{{$datas->ContactNo}}</td>
                        
                        <td>{{$datas->emergency_fname}}</td>

                        @php 
                          $datas->emergency_mname = $datas->emergency_mname != '' && $datas->emergency_mname != 'EmptyN/A' ? $datas->emergency_mname : 'N/A';
                        @endphp
                        <td>{{$datas->emergency_mname}}</td>
                        <td>{{$datas->emergency_lname}}</td>
                        <td>{{$datas->emergency_contact}}</td>

                        <td>{{$datas->course}}</td>
                        <td>{{$datas->section}}</td>
                        <td>{{$datas->semester}}</td>
                        <td>{{$datas->remarkings}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  
                  <tfoot>
               
                  </tfoot>
                </table>
              </div>
              </form>

              <script>
            
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