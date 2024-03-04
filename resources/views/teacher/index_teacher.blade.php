<!DOCTYPE html>
<html lang="en">
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

</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

@yield('CheckIfLogin')

<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{ asset('dist/img/logo/Clark-College-of-Science-and-Technology.png') }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navigation_div" id="navigationsing">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a id="darkmodeIcon" onclick="continues()" class="nav-link hover">
         @if(session('darkmode') == 1)
         <i class='animation_darkmode_icon fas fa-sun'></i>
         @else
         <i class='animation_darkmode_icon fas fa-moon'></i>
         @endif

        </a>
        
      </li>
     

      <li class="nav-item">
        <a class="nav-link"  href="{{ route('teacher.settings') }}">
          <i class="fas fa-cog"></i>
        </a>
        
      </li>
      <li class="nav-item">
        <a class="nav-link" onclick="powerOff()">
          <i class="fas fa-sign-out-alt" id="powerOff"></i>
        </a>
        
      </li>
      <script>
        var darkmode = {{ session('darkmode') }};

        
        function continues(){

          
          
          
          jQuery.ajax({
            
            
            url: "{{ url('teacher/dark_mode') }}",
            data: {
                darkmode: darkmode,
            },
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success:function(result)
            {
                darkmode = result.darkmode;
                changing_mode(darkmode);
                
            }

        
        });
            
            
          
          
        }

   
        

        function powerOff(){
            Swal.fire({
            title: 'Logout',
            text: "Are you sure you want to logout?",
            icon: 'question',
            confirmButtonText: 'Continue',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            
          }).then((result) => {
            if (result.isConfirmed) {
              let timerInterval
              Swal.fire({
                title: 'Good day!',
                html: 'Closing the application..',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                  Swal.showLoading()
                  const b = Swal.getHtmlContainer().querySelector('b')
                  timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                  }, 100)
                },
                willClose: () => {
                  clearInterval(timerInterval)
                }
              }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                  
                  var routeUrl = "{{ route('teacher.logout_admin') }}"; 

                  window.location.href = routeUrl; 
                }
              })
            }
          })
        }
   

         
        
        
      </script>

      
      <script>
        changing_mode(darkmode);
        function changing_mode(changeTheMode){
          var darkmodeIcon = document.getElementById('darkmodeIcon');
          var nav = document.getElementById('navigationsing');
          if (changeTheMode == 0) {
          
            document.body.classList.remove('dark-mode');
            nav.classList.remove('navbar-dark');
            darkmodeIcon.innerHTML = "<i class='animation_darkmode_icon fas fa-moon'></i>";

          } else {
           
            document.body.classList.add('dark-mode');
            nav.classList.add('navbar-dark');
            darkmodeIcon.innerHTML = "<i class='animation_darkmode_icon fas fa-sun'></i>";
            
          }
        }
      </script>
      
      

      
      <!-- Notifications Dropdown Menu
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li> -->
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('teacher.index') }}" class="brand-link">
      <img src="{{ asset('dist/img/logo/Clark-College-of-Science-and-Technology.png') }}" alt="AdminLTE Logo" class="logo brand-image elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CCSTNexus</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @php
           
            $links = 'dist/img/profiles/' . session('links');
          @endphp
       
          <img src="{{ asset($links) }}" class="img-circle elevation-2" alt="User Image" style="height: 2.1rem;object-fit: cover;">
        </div>
        <div class="info">
          <a  href="{{ route('teacher.settings') }}" class="d-block">{{ session('fullname') }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      @php

      $currentRoute = \Route::current();
      $currentRouteName = $currentRoute->getName();



   $options = [

       

          'section' => [

                'title' => 'Section',

                'mode' => 'with_child',

                'icon' => 'far fa-file-alt',

                'child' => 
                [

                  

                  'Add section' => ['title' => 'Add section', 
                              'route' => route("teacher.add_section"),
                              'routes' => 'teacher.add_section'
                            ],

                  'Section list' => ['title' => 'Section list', 
                            'route' =>  route('teacher.edit_section', ['academic' => 'original']),
                            'routes' => 'teacher.edit_section'
                            ],

                  

           

                ]

          ],




          'studentList' => [

            'route' => route("teacher.studentList"),
            'routes' => 'teacher.studentList',
            'icon' => 'nav-icon fas fa-users',
            'title' => 'Student list',
            'mode' => 'single'

            ],



          'reports' => [

          'route' => route("teacher.disabledPage"),
          'routes' => 'teacher.disabledPage',
          'icon' => 'nav-icon fas fa-clipboard-list',
          'title' => 'Reports',
          'mode' => 'single'

          ],

      

      


          


      ];


      $currentRoute = \Route::current();
      $routeName = $currentRoute->getName();
      $activeNav = '';
      $IndexParent = 0;
      @endphp
     
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->



          
          @foreach ($options as $titles => $titlesValue)
          
            @if ($titlesValue['mode'] != 'single')
            
            
              @foreach ($titlesValue['child'] as $children => $childrenFirstValue)
              
                  @php
                    if($routeName == $childrenFirstValue['routes']){
                      $activeNav = 'menu-open';
                      
                    }
                    
                  
                  @endphp    
                  
              @endforeach 
              <li class="nav-item {{ $activeNav }}" id="{{$titlesValue['title']}}navsi">
               
                <a href="#" class="nav-link">
                  <i class="nav-icon {{ $titlesValue['icon'] }}" id="{{$titlesValue['title']}}navs"></i>
                  <p>
                    {{ $titlesValue['title'] }}
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
              
                <ul class="nav nav-treeview">
                  <li class="nav-item" >
                  @foreach ($titlesValue['child'] as $children => $childrenFirstValue)
                   
                    @php
                        $departmentValue = request('department');
                        $active = ($routeName == $childrenFirstValue['routes']  || $childrenFirstValue['routes'] == $childrenFirstValue['title']) ? 'active' : '';
                        $activeNav = ($routeName == $childrenFirstValue['routes']  || $childrenFirstValue['routes'] == $childrenFirstValue['title']) ? 'active' : '';

                        if($childrenFirstValue['routes'] == 'fromController'){
                          $iding = 'headingSons'.$childrenFirstValue['title'];}
                        else{
                          $iding = 'headingSons';}
                        

                    @endphp     
                    @if($routeName == $childrenFirstValue['routes'] || $childrenFirstValue['routes'] == $childrenFirstValue['title'])
                      <script>
                       


                        
                      </script>
                   
                    @endif
                    
                    <a onclick="nextPagingLoading()" href="{{ $childrenFirstValue['route'] }}" id="{{ $iding }}" class="nav-link {{ $active }}">
                    <i class="fas fa-dot-circle"></i>
                      <p>{{$childrenFirstValue['title']}}</p>
                    </a>

                    @if($childrenFirstValue['routes'] == 'fromController')
                      <script>
                        var headingSons = document.getElementById("headingSons{{$childrenFirstValue['title']}}");
                        var ids = "{{ $childrenFirstValue['idControll'] }}";
                        var currentUrl = window.location.href;
                        var match = currentUrl.match(/\/(\d+)$/);
                        var extractedValue = match[1];
                        
                        var idNavigations = "{{$titlesValue['title']}}"+"navsi";
                        var idNavigationsTag = document.getElementById(idNavigations);
                        


                        if(ids == extractedValue){
                          headingSons.classList.add("active");
                          idNavigationsTag.classList.add("menu-open");
                        }
                      </script>
                    @endif

                  @endforeach
                    
                  </li>

                  
                
                </ul>

              </li>
            @else
              
                    
                  @php
                  $activeNav = '';
                    if($titlesValue['routes'] == $routeName){
                      $activeNav = 'active';

                    }
                    
                  
                  @endphp    
                  
              
              <li class="nav-item ">
                <a onclick="nextPagingLoading()" href="{{ $titlesValue['route'] }}" class="{{ $activeNav }} nav-link ">
                  <i class="nav-icon {{ $titlesValue['icon'] }}"></i>
                  <p>

                    {{ $titlesValue['title'] }}

                   
                  </p>
                </a>
              </li> 
            @endif
          @endforeach

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

 

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?php date_default_timezone_set('Asia/Manila'); echo date('Y'); ?> Clark College of Science and Technology.</strong>
    All rights reserved.

  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
  })

  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });


 
  function properCase(str) {
    if (!str) {
        return ""
    }
    return str.toLowerCase().replace(/\b\w/g, s => s.toUpperCase());
    }
  




  


</script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script> -->
@include('dataTable.dataTableButtons')
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
  $(document).ready(function () {
  $('#example3').DataTable();
  $('#example4').DataTable();
  $('.dataTables_length').addClass('bs-select');
  });
</script>
<style>
    /* Add your custom styling here */
    .custom-swal-bggs9 {
      background-color: transparent !important; /* Replace with your desired background color */
    }
  </style>
<script>
  function nextPagingLoading(){
    Swal.fire({
        

      html: `
        <h1><i  class="fas fa-spinner spinningsSlow"></i></h1>
      `,
      showCloseButton: false,
      showConfirmButton: false,
      // allowOutsideClick: false,
      customClass: {
      popup: 'custom-swal-bggs9' // Add your custom background color class here
    }

     
    });
  }
      
</script>
</body>
</html>
