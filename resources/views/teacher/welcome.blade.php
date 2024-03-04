<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome CCSTNexus</title>


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
<style>
    body{
        background-color:#343a40 !important;
        display:flex;
        justify-content: center;
        align-items: center;
        height: 100dvh;
        margin: 0px;
        padding:0px;
        color: white;

    }
    .welcomeText
    {
        font-size: 50px;
        letter-spacing: 4px;
    }

    .welcomeTextSmall
    {
        display: none;
        letter-spacing: 2px;font-size:30px;
        text-align:center;
        opacity: 0;
       
        animation: fadeInLoop 5s ease-in-out infinite;
    }
   
    .welcomeText {
        display: none;
        opacity: 1;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @keyframes fadeInLoop {
        0% {
        opacity: 0;
 
      }
      25% {
        opacity: 0.5;

      }
      50% {
        opacity: 1;
    
      }
      75% {
        opacity: 0.5;
        
      }
      100% {
        opacity: 0;
      
      }
    }

</style>
<body>
    <h1 class="hello"><b></b></h1>


    <h1 class="welcomeText" id="welcomeText"><b>WELCOME!</b></h1>
    <h1 class="welcomeTextSmall" style="" id="welcomeText2"><b>WE ARE SETTING UP YOUR ACCOUNT</b></h1>
    <script>

    window.addEventListener("load", function() {
      
      setTimeout(function() {

        
       
        var welcomeText = document.getElementById("welcomeText");
        
        welcomeText.style.display = 'block';

      }, 2000);


      
      setTimeout(function() {
       
       var welcomeText = document.getElementById("welcomeText");
       
       welcomeText.style.display = 'none';
     
     }, 6000);

     setTimeout(function() {
       
       var welcomeText = document.getElementById("welcomeText2");
       welcomeText.style.display = 'block';
       welcomeText.style.opacity = 1;
 
     }, 6010);

     setTimeout(function() {
       
        var welcomeText = document.getElementById("welcomeText2");
       
       welcomeText.style.display = 'none';


       
 
     }, 15010);

    
    });


   
  </script>
</body>
</html>