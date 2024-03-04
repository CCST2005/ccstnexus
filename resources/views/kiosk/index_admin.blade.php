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
<body id="bodyLocks" style="background-color: #343a40 !important" class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" >

  

<div class="wrapper">

  <!-- Preloader -->


  <!-- Navbar -->
 
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

 

  <!-- Main Footer -->
  
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
  $('.dataTables_length').addClass('bs-select');
  });
</script>



                    <!-- Font Awesome -->
                  
                    <!-- Select2 -->
                    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
                    <!-- Theme style -->
             

                    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
                        <div class="col-3" data-select2-id="11">
<!-- <div id="lockBackgound" class="lockBackgound"></div>
<script>
    document.addEventListener('keydown', function(event) {
      // Check if Ctrl key and 'P' key are pressed simultaneously
      if (event.ctrlKey && event.key === 'l' || event.ctrlKey && event.key === 'L') {
        // Change the link below to the desired destination

              
        document.body.addEventListener("contextmenu", function(e) {
                e.preventDefault();
        });
  
      }
    });
  </script> -->

  <script>
                    document.addEventListener('keydown', function(event) {
                      // Check if Ctrl key and 'P' key are pressed simultaneously
                      if (event.ctrlKey && event.key === 'F' || event.ctrlKey && event.key === 'f') {
                        // Change the link below to the desired destination
                        
                        if(document.getElementById("dataTablesInput")){
                          document.getElementById("dataTablesInput").focus();
                          event.preventDefault();
                        }
                      }
                    });
                  </script>
</body>

</html>
