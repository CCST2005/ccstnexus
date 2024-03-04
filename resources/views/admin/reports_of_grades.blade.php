@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | admin

@endsection

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

            <h1 class="m-0">{{$studentName}}</h1>
            <p>{{$courseName}}</p>
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
              @if(!isset($gradesStudent) && !isset($all2005))
              <div class="card-header" style="display:flex; justify-content: ; width:100%">
                  
             
                  Grade reports

              </div>
              @else
              <div class="card-header" style="display:flex; justify-content: left; width:100%">
                  
                  <div class="dropdown" style="max-width: 250px">
                    <button style="width: 100%; text-align: center" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(!isset($all2005))
                      {{$namingSemester}}
                    @else
                      {{ 'All' }}
                    @endif
                  
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      @php
                        $ints = 0;
                      @endphp
                        @foreach($dropdown as $value)
                          @php
                          $sectioningsID = $value[5];
                           $ints++;
                          @endphp
                          
                            <a class="dropdown-item" href="{{ route('admin.grade_reports_picked', ['year' => $value[0], 'semester' => $value[1], 'id' => $value[3], 'course' => $value[4], 'printable' => '0' , 'mode' => $mode, 'section' => $value[5] ])}}">{{$value[2]}}</a>
                        
                            
                        @endforeach
                        @if($ints != 0 && $mode == 2)
                          <a class="dropdown-item" href="{{ route('admin.grade_reports_picked', ['year' => $value[0], 'semester' =>2005, 'id' => $value[3], 'course' => $value[4], 'printable' => '0' , 'mode' => $mode, 'section' => $value[5]])}}">All</a>

                        @endif
                    </div>
                  </div>
  

              </div>
              @endif
              <form id="checkboxForm">
                  @csrf
                 
              <!-- /.card-header -->
              <div class="card-body">
                @if(!isset($gradesStudent) && !isset($all2005))
                  <div class="dropdown" style="width: 10%">
                    <button style="width: 100%; text-align: left" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Choose semester
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @php
                        $ints = 0;
                      @endphp    
                    @foreach($dropdown as $value)
                          @php
                           $ints++;
                       
                          $sectioningsID = $value[5];
                     
                          @endphp
                            <a class="dropdown-item" href="{{ route('admin.grade_reports_picked', ['year' => $value[0], 'semester' => $value[1], 'id' => $value[3], 'course' => $value[4], 'printable' => '0', 'mode' => $mode, 'section' => $value[5]]) }}">{{$value[2]}}</a>
                            
                            @endforeach

                            
                        @if($ints != 0 && $mode == 2)

                          <a class="dropdown-item" href="{{ route('admin.grade_reports_picked', ['year' => $value[0], 'semester' => 2005, 'id' => $value[3], 'course' => $value[4], 'printable' => '0', 'mode' => $mode, 'section' => $value[5]]) }}">All</a>
                          
                        @endif
         
                    </div>
                  </div>
                @else
                <script>
                    document.addEventListener('keydown', function(event) {
                      // Check if Ctrl key and 'P' key are pressed simultaneously
                      if (event.ctrlKey && event.key === 'p' || event.ctrlKey && event.key === 'P') {
                        // Change the link below to the desired destination
                       
                        var newTab = window.open("{{ route('admin.grade_reports_picked', ['year' => $printYears, 'semester' => $printSems, 'id' => $printID, 'course' => $printCourse, 'printable' => '1' , 'mode' => $mode, 'section' => $sectioningsID]) }}", '_blank');
                        newTab.focus();
                      }
                    });

                    function prints(){
                      // Check if Ctrl key and 'P' key are pressed simultaneously
                  
                        // Change the link below to the desired destination
                       
                        var newTab = window.open("{{ route('admin.grade_reports_picked', ['year' => $printYears, 'semester' => $printSems, 'id' => $printID, 'course' => $printCourse, 'printable' => '1' , 'mode' => $mode, 'section' => $sectioningsID]) }}", '_blank');
                        newTab.focus();
                    
                    }
                    
                  </script>
                  @if(isset($all2005) && $mode == 2)
                  
                  
                  <table class="table table-bordered">
                    <thead>
                      <tr>
        
                        <th rowspan="2" class="align-middle" style="text-align: center !important" scope="col">Course code</th>
                        <th rowspan="2" class="align-middle" style="text-align: center !important" scope="col">Descriptive</th>
                       
                        <th colspan="2" class="align-middle" style="text-align: center !important" scope="col">Final grades</th>
                        <th rowspan="2" class="align-middle" style="text-align: center !important" scope="col">Credits</th>

                      </tr>

                      <tr>
                     
                        <th style="text-align:center">%</th>
                        <th style="text-align:center">Equiv.</th>
                    
                      </tr>
                    </thead>
                    <tbody>
                     
                      
                    @for($i = 0; $i != count($all2005); $i++)
                      @php
                        $empty = false;
                        $numcounts = 0;
                        $completeGrade = 0;
                      @endphp
                      <tr>
                     
                        <td style="text-align: center"><b>{{$all2005Years[$i]}}</b></td>
                        <td style="text-align: center"><b><i>{{$all2005Semester[$i]}}</i></b></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                    
                      </tr>
                      @foreach($all2005[$i] as $pogi)
                      
                      @php
                        $numcounts++;
                        $completeGrade += floatval($pogi['grades']);
                      @endphp
                      
                      <tr>
                     
                        <td  style="text-align: center">{{$pogi['subjectCode']}}</td>
                        <td @if($pogi['subjectName'] == '-') style="text-align: center;" @endif> {{$pogi['subjectName']}} </td>
                        
                        <!-- <td style="text-align: center">{{$pogi['teacherSection']}}</td> -->
                        <td style="text-align: center">@if ($pogi['grades'] == 0 || $pogi['grades'] == '-' ||  $pogi['grades'] == '') {{'-'}} @else {{$pogi['grades']}} @endif</td>
                    
                        @php
                            $eqv = '-';
                            $inputGradeValue = $pogi['grades'];

                            if ($inputGradeValue == 0 || $inputGradeValue == '-' ||   $inputGradeValue == '') {
                                $empty = true;
                                $eqv = '-';
                            }
                            elseif($inputGradeValue >= 97.5)
                            {
                                $eqv = '1.0';
                            }
                            elseif($inputGradeValue >= 94.5)
                            {
                                $eqv = '1.25';
                            }
                            elseif($inputGradeValue >= 91.5)
                            {
                                $eqv = '1.50';
                            }
                            elseif($inputGradeValue >= 87.5)
                            {
                                $eqv = '1.75';
                            }
                            elseif($inputGradeValue >= 84.5)
                            {
                                $eqv = '2.00';
                            }
                            elseif($inputGradeValue >= 81.5)
                            {
                                $eqv = '2.25';
                            }
                            elseif($inputGradeValue >= 78.5)
                            {
                                $eqv = '2.50';
                            }
                            elseif($inputGradeValue >= 75.5)
                            {
                                $eqv = '2.75';
                            }
                            elseif($inputGradeValue >= 74.5)
                            {
                                $eqv = '3.00';
                            }
                            elseif($inputGradeValue >= 50)
                            {
                                $eqv = '5.00';
                            }
                            $colors = '';
                            $remarks = '-';
                            if ($inputGradeValue == 0 || $inputGradeValue == '-' ||  $inputGradeValue == '') {
                                $remarks = 'INC';
                                $colors = '#a58552';
                            }
                            else if ($inputGradeValue <= 74.4) {
                                $remarks = 'FAILED';
                                $colors = 'rgb(240, 64, 64)';
                            } else {
                                $remarks = 'PASSED';
                                $colors = '#30bb2f';
                            }
                        @endphp

                        <td style="text-align: center">{{$eqv}}</td>
                        <!-- <td style="text-align: center;color:{{$colors}}"><i><b>{{$remarks}}</b></i></td> -->
                     
                        <td style="text-align: center">{{intval($pogi['subjectLecture']) + intval($pogi['subjectLab'])}}</td>
                      </tr>
                      
                     @endforeach
                  
                     
                      @endfor
                      <!-- <tr>
                        <td colspan="4" style="text-align: right">Semester's General Average: </td>
                        <td colspan="5" style="text-align: center"><b>@if($empty){{'N/A'}} @else {{ round(intval($completeGrade)/intval($numcounts),2) }} @endif</b></td>
                      </tr> -->
                    </tbody>
                  </table>

                  @else

                  <button type="button" class="btn btn-block bg-primary" onclick="prints()" style="max-width: 150px; margin-bottom: 10px;display:flex;justify-content: center;align-items:center;gap:10px">Print grades<i class="fas fa-print"></i></button>
                  
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th  rowspan="2" class="align-middle"style="text-align: center !important" scope="col">#</th>
                        <th  rowspan="2" class="align-middle"style="text-align: center !important"scope="col">Code</th>
                        <th rowspan="2" class="align-middle" style="text-align: center !important"scope="col">Descriptive</th>
                        <th colspan="2" class="align-middle" style="text-align: center !important" scope="col">Units</th>
        
                        <th  rowspan="2" class="align-middle" style="text-align: center !important" scope="col">Final</th>
                        <th rowspan="2"class="align-middle" style="text-align: center !important" scope="col">Equv.</th>
                        <th  rowspan="2" class="align-middle"style="text-align: center !important" scope="col">Remarks</th>
                      </tr>
                
                      <tr>
                        <th style="text-align: center">Lab</th>
                       
                        <th style="text-align: center">Lec</th>
                        
                      </tr>
                    </thead>
                            
                    <tbody>
                      @php
                        $empty = false;
                        $numcounts = 0;
                        $completeGrade = 0;
                      @endphp

                      @php 

                      $sections = array_column($gradesStudent, 'subjectCode');

                      // Sort both the data and the sections array
                      array_multisort($sections, $gradesStudent);


                      @endphp
                     
                      @foreach($gradesStudent as $pogi)
                     
                      @php
                        $numcounts++;
                        $completeGrade += floatval($pogi['grades']);
                      @endphp
                      <tr>
                        <td style="text-align: center">{{$numcounts}}</td>
                        <td>{{$pogi['subjectCode']}}</td>
                        <td title="Graded by: {{$pogi['teachers']}}">{{$pogi['subjectName']}}</td>
                        <td style="text-align: center">{{intval($pogi['subjectLab'])}}</td>
                        <td style="text-align: center">{{intval($pogi['subjectLecture'])}}</td>
                        
                   
                        <td style="text-align: center">@if ($pogi['grades'] == 0 || $pogi['grades'] == '-' ||  $pogi['grades'] == '') {{'-'}} @else {{$pogi['grades']}} @endif</td>

                        @php
                            $eqv = '-';
                            $inputGradeValue = $pogi['grades'];

                            if ($inputGradeValue == 0 || $inputGradeValue == '-' ||   $inputGradeValue == '') {
                                $empty = true;
                                $eqv = '-';
                            }
                            elseif($inputGradeValue >= 97.5)
                            {
                                $eqv = '1.0';
                            }
                            elseif($inputGradeValue >= 94.5)
                            {
                                $eqv = '1.25';
                            }
                            elseif($inputGradeValue >= 91.5)
                            {
                                $eqv = '1.50';
                            }
                            elseif($inputGradeValue >= 87.5)
                            {
                                $eqv = '1.75';
                            }
                            elseif($inputGradeValue >= 84.5)
                            {
                                $eqv = '2.00';
                            }
                            elseif($inputGradeValue >= 81.5)
                            {
                                $eqv = '2.25';
                            }
                            elseif($inputGradeValue >= 78.5)
                            {
                                $eqv = '2.50';
                            }
                            elseif($inputGradeValue >= 75.5)
                            {
                                $eqv = '2.75';
                            }
                            elseif($inputGradeValue >= 74.5)
                            {
                                $eqv = '3.00';
                            }
                            elseif($inputGradeValue >= 50)
                            {
                                $eqv = '5.00';
                            }
                            $colors = '';
                            $remarks = '-';
                            if ($inputGradeValue == 0 || $inputGradeValue == '-' ||  $inputGradeValue == '') {
                                $remarks = 'INC';
                                $colors = '#a58552';
                            }
                            else if ($inputGradeValue <= 74.4) {
                                $remarks = 'FAILED';
                                $colors = 'rgb(240, 64, 64)';
                            } else {
                                $remarks = 'PASSED';
                                $colors = '#30bb2f';
                            }
                        @endphp

                        <td style="text-align: center">{{$eqv}}</td>
                        <td style="text-align: center;color:{{$colors}}"><i><b>{{$remarks}}</b></i></td>
                      </tr>
                      
                     @endforeach
                  
                      <tr>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"><i>***nothing follows***</i></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                      </tr>
                      <tr>
                        <td colspan="7" style="text-align: right">Semester's General Average: </td>
                        @php
                            $eqv = '-';
                            $inputGradeValue = floatval(round(floatval($completeGrade)/floatval($numcounts),2));

                            if($inputGradeValue >= 97.5)
                            {
                                $eqv = '1.0';
                            }
                            elseif($inputGradeValue >= 94.5)
                            {
                                $eqv = '1.25';
                            }
                            elseif($inputGradeValue >= 91.5)
                            {
                                $eqv = '1.50';
                            }
                            elseif($inputGradeValue >= 87.5)
                            {
                                $eqv = '1.75';
                            }
                            elseif($inputGradeValue >= 84.5)
                            {
                                $eqv = '2.00';
                            }
                            elseif($inputGradeValue >= 81.5)
                            {
                                $eqv = '2.25';
                            }
                            elseif($inputGradeValue >= 78.5)
                            {
                                $eqv = '2.50';
                            }
                            elseif($inputGradeValue >= 75.5)
                            {
                                $eqv = '2.75';
                            }
                            elseif($inputGradeValue >= 74.5)
                            {
                                $eqv = '3.00';
                            }
                            elseif($inputGradeValue >= 50)
                            {
                                $eqv = '5.00';
                            }
                            if($empty){
                              $average = 'N/A';
                              $equivals = 'N/A';
                            } 
                            else {
                             
                              $average = $eqv;
                              $equivals = $inputGradeValue . ' / ' . $average;
                              } 
                            
                        @endphp

                        <td colspan="8" style="text-align: center"><b>{{$equivals}}</b></td>
                      </tr>
                    </tbody>
                  </table>
                  @endif
                  @endif
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
        
        var newPageURL = "{{ route('admin.delete_admin', ['id' => 'PLACEHOLDER_ID', 'password' => 'PLACEHOLDER_PASS']) }}"
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