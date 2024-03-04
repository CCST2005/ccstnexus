
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@section('titlePage') CCSTNexus @show</title>

  <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

  <link rel="icon" type="image/x-icon" href="{{ asset('dist/img/logo/favicon.ico') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/adminltemin.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/adminlte.css') }}">



  <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/updates.css') }}">

  <script src="{{ asset('dist/js/modals.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="{{ asset('dist/js/jquery-3.7.1.min.js') }}"></script>
    <style>
        *{
            font-family: Century Gothic;
        }
    </style>
</head>
        <body style="margin: 0px">

            <div style="width: 99dvw;height: 100dvh;background-color:;position:fixed; display: flex; justify-content: center;align-items:center;opacity:5%">
                <img class="" src="{{ asset('dist/img/logo/Clark-College-of-Science-and-Technology.png') }}" alt="" height="43%">
            </div>
             
              <!-- /.card-header -->
              <div class="card-body" style="margin-left:4%;margin-right:4%;">
              <div style="width: 100%;display:flex; justify-content: center;margin-bottom: 40px">
                <img class="" src="{{ asset('dist/img/CCST_GRADE_LOGO.png') }}" alt="" height="120px" style="filter: multiply(0.5, 0.5, 0.5, 1.5);">
            </div>
              
            <div style="width: 100%;display:flex; justify-content: center;margin-bottom: 0px">
                <h3 style="letter-spacing: 2px;">OFFICE OF THE COLLEGE REGISTRAR</h3>
            </div>
              <div style="width: 100%;display:flex; justify-content: center;margin-bottom: 50px">
                <h4  style=""><b>@if($mode != 2) {{'REPORT CARD'}} @else {{ 'COPY OF GRADES' }} @endif</b></h4>
            </div>

              <div style="width: 100%;display:flex; justify-content: space-between;">
                    <div style="width: 100%">
                        <div style="margin-bottom:8px">NAME: <span style="border-bottom: 1px solid; padding-bottom:2px">{{ strtoupper($studentName)}}</span></div>
                        <div>COURSE: <span style="border-bottom: 1px solid; padding-bottom:2px">{{ strtoupper($courseName)}}</span></div>
                    </div>

                    <div  style="width: 100%;display:grid; justify-content: end;">
                        <div style="margin-bottom:8px">SECTION: <span style="border-bottom: 1px solid; padding-bottom:2px">{{ strtoupper($sectioningName)}}</span></div>
                        <div>SCHOOL TERM: <span style="border-bottom: 1px solid; padding-bottom:2px">{{ strtoupper($namingSemester)}}</span></div>
                    </div>
                </div>
                <br>
                @if(!isset($gradesStudent) && !isset($all2005))
                  <div class="dropdown" style="width: 13%">
                    <button style="width: 100%; text-align: left" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Choose school year
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @php
                        $ints = 0;
                      @endphp    
                    @foreach($dropdown as $value)
                          @php
                           $ints++;
                          @endphp
                            <a class="dropdown-item" href="{{ route('admin.grade_reports_picked', ['year' => $value[0], 'semester' => $value[1], 'id' => $value[3], 'course' => $value[4]]) }}">{{$value[2]}}</a>
                        @endforeach
                        @if($ints != 0)
                          <a class="dropdown-item" href="{{ route('admin.grade_reports_picked', ['year' => $value[0], 'semester' => 2005, 'id' => $value[3], 'course' => $value[4]]) }}">All</a>

                        @endif
         
                    </div>
                  </div>
                @else
                  @if(isset($all2005))
                  <table class="table table-bordered">
                    <thead>
                      <tr>
        
                        <th rowspan="2" class="align-middle" style="text-align: center" scope="col">Course code</th>
                        <th rowspan="2" class="align-middle" style="text-align: center" scope="col">Descriptive</th>
                       
                        <th colspan="2" class="align-middle" style="text-align: center" scope="col">Final grades</th>
                        <th rowspan="2" class="align-middle" style="text-align: center" scope="col">Credits</th>

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
                        $numcountsUnitsEqual = 0;
                        $numcountsEquive = 0;

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
                        $numcountsUnitsEqual += (intval($pogi['subjectLab']) + intval($pogi['subjectLecture']));
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
                            
                            if($eqv != '-'){
                              $numcountsEquive += (intval($pogi['subjectLab']) + intval($pogi['subjectLecture'])) * $eqv;
                            }


                        @endphp

                        <td style="text-align: center">{{$eqv}}</td>
                        <!-- <td style="text-align: center;color:{{$colors}}"><i><b>{{$remarks}}</b></i></td> -->
                        <td style="text-align: center">{{intval($pogi['subjectLab']) + intval($pogi['subjectLecture'])}}</td>
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


                  <table class="table table-bordered">
                    <thead>
                      <tr>
                      <th  rowspan="2" class="align-middle" style="text-align: center" scope="col">#</th>
                        <th  rowspan="2" class="align-middle" style="text-align: center"scope="col">Code</th>
                        <th rowspan="2"  class="align-middle" style="text-align: center"scope="col">Descriptive</th>
                        <th colspan="2" class="align-middle" style="text-align: center" scope="col">Units</th>
        
                        <th  rowspan="2" class="align-middle" style="text-align: center" scope="col">Final</th>
                        <th rowspan="2"  class="align-middle" style="text-align: center" scope="col">Equv.</th>
                        <th  rowspan="2" class="align-middle" style="text-align: center" scope="col">Remarks</th>
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
                        $numcountsUnitsEqual = 0;
                        $numcountsEquive = 0;
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
                        $numcountsUnitsEqual += (intval($pogi['subjectLab']) + intval($pogi['subjectLecture']));
                        $completeGrade += floatval($pogi['grades']);
                      @endphp
                      <tr>
                        <td style="text-align: center">{{$numcounts}}</td>
                        <td>{{$pogi['subjectCode']}}</td>
                        <td>{{$pogi['subjectName']}}</td>
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



                            if($eqv != '-'){
                              $numcountsEquive += (intval($pogi['subjectLab']) + intval($pogi['subjectLecture'])) * $eqv;
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
                   

                            
                           
                              $average = $eqv;

                              if(!$empty){
                                $equivals = $numcountsEquive / $numcountsUnitsEqual;
                              $equivals = round($equivals, 2);
                              }
                              else{
                                $equivals = '-';
                              }
                              
                              
                            
                        @endphp

                        <td colspan="8" style="text-align: center"><b>{{$equivals}}</b></td>
                      </tr>
                    </tbody>
                  </table>
                  @endif
                  @endif
                            <br>
                  <p style="text-align: center; width: 100%"><i>I hereby certify that all of the above information are correct.</i></p>
              

              {{-- <script>
    // Function to close the tab or window
    function closeTab() {
      window.close(); // This may not work in some browsers due to security restrictions
    }

    // Function to handle the afterprint event
    function afterPrint() {
      closeTab();
    }

    // Function to handle the print button click
    function printAndClose() {
      window.print();
    }

    // Attach the afterprint event listener
    window.addEventListener('afterprint', afterPrint);

    // Call the printAndClose function when the page loads
    window.onload = printAndClose;
  </script> --}}
            
  <br>
            <div style="width: 100%;display:flex; justify-content: space-between;">
                      <div  style="width: 100%;display:grid; justify-content: center;">
                        
                        <div style="position:relative"><span style="width: 100%; text-align:center;padding-bottom:1px;border-bottom:1px solid">{{$TeacherName}}</span>
                        @php
                          $src='';
                          $styles ='';
                          if($TeacherNameSignature != ''){
                            $src = 'dist/img/E_SIGNATURES/'. $TeacherNameSignature;
                          }
                          else{
                            $styles = "display:none";
                          }
                          
                        @endphp
                        <img  class="" style="position:absolute; left:0px; top: -35px;z-index:1;{{$styles}}" src="{{ asset($src) }}" alt="" height="100px"></div>
                        <div style="width: 100%; text-align:center;"><span style=" padding-top:1px">Class Adviser</span></div>
                    </div>

                    <div  style="width: 100%;display:grid; justify-content: center;">
                      <div style="position:relative;width: 100%;display:grid; justify-content: center;"><span style="width: 100%; text-align:center;padding-bottom:1px;border-bottom:1px solid">{{strtoupper($TeacherNameDepartment)}}</span>
                      @php
                          $src='';
                          $styles ='';
                          if($TeacherNameDepartmentImage != ''){
                            $src = 'dist/img/E_SIGNATURES/'. $TeacherNameDepartmentImage;
                          }
                          else{
                            $styles = "display:none";
                          }
                          
                        @endphp
                        <img class="" style="position:absolute; left:0px; top: -35px;z-index:1;{{$styles}}" src="{{ asset($src) }}" alt="" height="100px"></div>
                        <div style="width: 100%; text-align:center;"><span style=" padding-top:1px">{{ $TeacherNameDepartmentPosition}}</span></div>
                      </div>
                </div>

                <br><br>
            <div style="width: 100%;display:flex; justify-content: space-between;">
             <div  style="width: 100%;display:grid; justify-content: center;">
                        <div style=""><span style="width: 100%; text-align:center;padding-bottom:1px;border-bottom:1px solid">MS. JANELLA MARIE P. CUNANAN</span></div>
                        <div style="width: 100%; text-align:center;"><span style=" padding-top:1px">Regristrar</span></div>
                    </div>

                    <div  style="width: 100%;display:grid; justify-content: center;">
                        <div style="position:relative"><span style="width: 100%; text-align:center;padding-bottom:1px;border-bottom:1px solid">MR. ROSS CARVEL C. RAMIREZ</span>
                        <img class="" style="position:absolute; left:0px; top: -35px;z-index:1" src="{{ asset('dist/img/E_SIGNATURES/RCR.png') }}" alt="" height="100px"></div>
                        <div style="width: 100%; text-align:center;"><span style=" padding-top:1px">Academic Head</span></div>
                        
                    </div>
                </div>
                <br><br> <br>

                <div  style="text-align:center;width:170px;display:grid; justify-content: start; opacity: 50%">
                        <div style=""><span style="width:170px; word-wrap: break-word;">Not valid without school seal and signature.</span></div>
                    
                    </div>

                    <div  style="width: 100%;display:grid; justify-content: end;">
                        <div style=""><i>Remarks: Issued this <b><span style="width: 100%; text-align:center;padding-bottom:1px;border-bottom:1px solid">{{now()->timezone('Asia/Manila')->format('F j, Y')}}</span></b> for reference purpose only.</i></div>
                       
                    </div>
                </div>

                <!-- ENDBODY -->
                </div>
                
                
  </body>