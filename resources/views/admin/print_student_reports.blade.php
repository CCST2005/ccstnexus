
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

  <style>
    @media print {
          @page {
              size: landscape;
          }
      }
  </style>


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
          <div>

          
            <div style="width: 99dvw;height: 100dvh;background-color:;position:fixed; display: flex; justify-content: center;align-items:center;opacity:5%">
                <img class="" src="{{ asset('dist/img/logo/Clark-College-of-Science-and-Technology.png') }}" alt="" height="43%">
            </div>
             
              <!-- /.card-header -->
              <div class="card-body" style="margin-left:2%;margin-right:2%;border: 0px solid">
                    <div style="width: 100%;display:flex; justify-content: center;margin-bottom: 50px">
                      <img class="" src="{{ asset('dist/img/CCST_GRADE_LOGO.png') }}" alt="" height="120px" style="filter: multiply(0.5, 0.5, 0.5, 1.5);">
                    </div>
                  
                  <div style="width: 100%;display:flex; justify-content: center;margin-bottom: 0px">
                      <!-- <h3 style="letter-spacing: 2px;">OFFICE OF THE COLLEGE REGISTRAR</h3> -->
                  </div>
                  <div style="width: 100%;display:flex; justify-content: center;margin-bottom: 5px">
                      <h4  style=""><b>STUDENT REPORT</b></h4>
                      
                  </div>
                  <div style="width: 100%;display:flex; justify-content: center;margin-bottom: 90px">
                    <h5  style="">{{$semesterDisplay}}</h5>
                      
                  </div>

                  <div style="width: 100%;display:flex; justify-content: space-between;margin-top: 100 vh">
                        <div style="width: 100%">
                            <div style="margin-bottom:8px">SECTION: <span style="border-bottom: 1px solid; padding-bottom:2px">{{$section}}</span></div>
                        
                            <div>ADVISER: <span style="border-bottom: 1px solid; padding-bottom:2px">{{$adviser}}</span></div>
                            <div style="margin-bottom:8px"><span style="border-bottom: 1px solid; padding-bottom:2px"></span></div>
                        </div>

                        <div  style="width: 100%;display:grid; justify-content: end; ">
                            <!-- <div style="margin-bottom:8px">REGULAR: <span style="border-bottom: 1px solid; padding-bottom:2px;">{{$REGULAR}}</span></div>
                            <div style="margin-bottom:8px">IRREGULAR: <span style="border-bottom: 1px solid; padding-bottom:2px;">{{$IRREGULAR}}</span></div> -->
                            <div>TOTAL: <span style="border-bottom: 1px solid; padding-bottom:2px">{{$REGULAR + $IRREGULAR}}</span></div>
                    
                        </div>
                    </div>
                
                <br>
                <style>
                      
                     
                  </style>
                  <table class="table table-bordered" style="font-size: 10px;padding: 0px !important;margin: 0px !important;">
                    <thead>
                      <tr>
                        @php 
                          $selection = json_decode($selection);
                        @endphp
                        <th class="align-middle" style="text-align: center">#</th>
                        <th>Student no.</th>
                        <!-- <th>Email</th> -->
                        <th>Last name</th>
                        <th>First name</th>
                        <th>Middle name</th>
                        @if(in_array('a',$selection))
                        <th>Gender</th>
                        @endif
                        @if(in_array('b',$selection))
                        <th>Birthday</th>
                        <th>Birthplace</th>
                        @endif
                        @if(in_array('d',$selection))
                        <th>Citizenship</th>
                        @endif
                        <th>Civil status</th>
                        @if(in_array('c',$selection))
                        <th>Region</th>
                        <th>Province</th>
                        <th>City</th>
                        <th>Barangay</th>
                        <th>Street</th>
                        @endif
                        <th>Contact No.</th>

                        <th>Course</th>
                        <th>Section</th>
                        @if(in_array('e',$selection))
                        <th>Remarks</th>
                        @endif
                      </tr>

                  
                    </thead>
                    <tbody>
                    @php
                      
                        $numcounts = 0;
                       
                      
                      @endphp
                    @foreach($studSectionLIst as $data)
                    
                     
                    @php
                      
                      $numcounts ++;
                    
                    @endphp
                      
                    @php 
                      $middles = $data->middlename != '' ? $data->middlename : '';
                      @endphp
                      <tr>
                        <td>{{$numcounts}}</td>
                        <td>{{$data->student_no}}</td>
                        <td>{{$data->lastname}}</td>
                        <td>{{$data->firstname}}</td>
                        <td>{{$middles}}</td>
                        @if(in_array('a',$selection))
                        <td>{{ $data->sex }}</td>
                        @endif

                        @if(in_array('b',$selection))
                        <td>{{ $data->birth_month }}/{{ $data->birth_day }}/{{ $data->birth_year }}</td>
                        @php 
                          $data->birthplace = $data->birthplace != '' && $data->birthplace != 'EmptyN/A' ? $data->birthplace : 'N/A';
                        @endphp
                        <td>{{$data->birthplace}}</td>
                        @endif

                        @if(in_array('d',$selection))
                        @php 
                          $data->citizenship = $data->citizenship != '' && $data->citizenship != 'EmptyN/A' ? $data->citizenship : 'N/A';
                        @endphp
                        <td>{{$data->citizenship}}</td>
                        @endif

                        @php 
                          $data->sivil_status = $data->sivil_status != '' && $data->sivil_status != 'EmptyN/A' ? $data->sivil_status : 'N/A';
                        @endphp
                        <td>{{$data->sivil_status}}</td>

                        @if(in_array('c',$selection))
                        @php 
                          $data->region = $data->region != '' && $data->region != 'EmptyN/A' ? $data->region : 'N/A';
                        @endphp
                        <td>{{$data->region}}</td>
                        @php 
                          $data->province = $data->province != '' && $data->province != 'EmptyN/A' ? $data->province : 'N/A';
                        @endphp
                        <td>{{$data->province}}</td>
                        @php 
                          $data->city = $data->city != '' && $data->city != 'EmptyN/A' ? $data->city : 'N/A';
                        @endphp
                        <td>{{$data->city}}</td>
                        @php 
                          $data->barangay = $data->barangay != '' && $data->barangay != 'EmptyN/A' ? $data->barangay : 'N/A';
                        @endphp
                        <td>{{$data->barangay}}</td>
                        @php 
                          $data->block_lot = $data->block_lot != '' && $data->block_lot != 'EmptyN/A' ? $data->block_lot : 'N/A';
                        @endphp
                        <td>{{$data->block_lot}}</td>
                        @endif

                        @php 
                          $data->ContactNo = $data->ContactNo != '' && $data->ContactNo != 'EmptyN/A' ? $data->ContactNo : 'N/A';
                        @endphp
                        <td>{{$data->ContactNo}}</td>
             
                        
                        <td>{{$data->course}}</td>
                        <td>{{$data->section}}</td>
                        @if(in_array('e',$selection))
                        <td>{{$data->remarkings}}</td>
                        @endif
                      </tr>
               
                  @endforeach
                     
                      
      
                      
                 
                  
                     
              
                  
                    </tbody>
                  </table>

                  
      </div >
<!-- 
              <script>
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
  </script> -->

                
                
  </body>