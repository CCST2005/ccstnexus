
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
              <div style="width: 100%;display:flex; justify-content: center;margin-bottom: 50px">
                <img class="" src="{{ asset('dist/img/CCST_GRADE_LOGO.png') }}" alt="" height="120px" style="filter: multiply(0.5, 0.5, 0.5, 1.5);">
            </div>
              
            <div style="width: 100%;display:flex; justify-content: center;margin-bottom: 0px">
                <!-- <h3 style="letter-spacing: 2px;">OFFICE OF THE COLLEGE REGISTRAR</h3> -->
            </div>
              <div style="width: 100%;display:flex; justify-content: center;margin-bottom: 90px">
                <h4  style=""><b>STUDENT SECTION LIST</b></h4>
            </div>

              <div style="width: 100%;display:flex; justify-content: space-between;">
                    <div style="width: 100%">
                        <div style="margin-bottom:8px">SECTION: <span style="border-bottom: 1px solid; padding-bottom:2px">{{$section}}</span></div>
                     
                        <div>ADVISER: <span style="border-bottom: 1px solid; padding-bottom:2px">{{$adviser}}</span></div>
                        <div style="margin-bottom:8px"><span style="border-bottom: 1px solid; padding-bottom:2px"></span></div>
                    </div>

                    <div  style="width: 100%;display:none; justify-content: end; ">
                        <div style="margin-bottom:8px">REGULAR: <span style="border-bottom: 1px solid; padding-bottom:2px;">{{$REGULAR}}</span></div>
                        <div style="margin-bottom:8px">IRREGULAR: <span style="border-bottom: 1px solid; padding-bottom:2px;">{{$IRREGULAR}}</span></div>
                        <div>TOTAL: <span style="border-bottom: 1px solid; padding-bottom:2px">{{$REGULAR + $IRREGULAR}}</span></div>
                 
                    </div>
                </div>
                <br>
               
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="align-middle" style="text-align: center">#</th>
                        <th  class="align-middle" style="text-align: center" >STUDENT NO.</th>
                        <th class="align-middle" style="text-align: center">LAST NAME</th>
                       
                        <th class="align-middle" style="text-align: center" >FIRST NAME</th>
                        <th  class="align-middle" style="text-align: center">MIDDLE NAME</th>
                        <th  class="align-middle" style="text-align: center">REMARKS</th>
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
                      
                    <tr>
                        <td>{{$numcounts}}</td>
                       
                        
                        <td>{{ $data->student_no }}</td>
                        <td>{{ $data->lastname }}</td>
                        <td>{{ $data->firstname }}</td>
                        <td>{{ $data->middlename != '' ? $data->middlename : 'N/A'}}</td>
                    
                       

                        <td>{{ $data->remarkings }}</td>

                       
                        
                        
                    
            
                    </tr>
               
                  @endforeach
                     
                      
      
                      
                 
                  
                     
              
                  
                    </tbody>
                  </table>

                  
              

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
  </script>

                
                
  </body>