<!DOCTYPE html>
<html lang="en">
<head>
  @yield('header')
</head>
<style>
  body{
    background-image: url("{{ asset('dist/img/logo/background-login.png') }}");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;

  }

  @media only screen and (max-width: 600px) {
  body {
    background-image: none;
  }
}
</style>
<body class="hold-transition login-page">
<div class="login-box" id="myForm">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary card-login">
    <div class="card-header text-center">
    <div style="display:flex; justify-content: center; align-items: center; gap: 5px; margin-top: 5px">  <img src="{{ asset('dist/img/logo/Clark-College-of-Science-and-Technology.png') }}" alt="AdminLTE Logo" class="logo brand-image elevation-3" style="height: 65px; "></div>

      <span class="h1"><b>CCST</b>Nexus</span><p style="margin:0;opacity:60%;font-weight:bold">TEACHER</p>
      
    </div>
    @yield('body')
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
@if (session('disabled'))
    <script>
        var form = document.getElementById("myForm");
        form.style = "display: none;"
        
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-secondary',
          
          },
          buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
          title: "{{ session('disabled')['title'] }}",
          icon: "{{ session('disabled')['icon'] }}",
          text: "{{ session('disabled')['text'] }}",
          showCancelButton: false,
          confirmButtonText: 'Back',
          reverseButtons: true,
          allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
              form.style = "display: ";
            }
        })
    </script>
@endif


<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>