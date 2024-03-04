@extends('admin.login_admin')

@section('body')
    
    <div class="card-body" >
      <p class="login-box-msg" style="padding:0px; font-size: 14px !important; padding-bottom: 16px">Enter your credentials to access to your account.</p>
      
      
      
      <form action="{{ route('admin.loging_in') }} " method="post">
        @csrf
        @if ($errors->has('message'))

           
            <div class="alert alert-danger alert-dismissible warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <span style="font-size:17px">
                    <i class="icon fas fa-ban">
                    </i>
                    <span>
                        
                            {{ $errors->first('message') }}
                        
                    </span> 
                
                </span>
            </div>
        @endif

        @if ($errors->has('color_email'))
            @php
                $color_error_email = $errors->first('color_email');
            @endphp
        @elseif ($errors->has('color_password'))
            @php
                $color_error_password = $errors->first('color_password');
            @endphp
        @endif
        
        <div class="input-group mb-3">
          <input type="type" class="form-control" name="email" 
          style = "border-color: {{ isset($color_error_email) ? $color_error_email : ''  }};
                  color: {{ isset($color_error_email) ? $color_error_email : ''  }}"
          value="{{ old('email', isset($data['email']) ? $data['email'] : '') }}"  placeholder="Employee number">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div  style="padding:0px !important; margin:0px !important;" class="input-group mb-3" >
          <input type="password" class="form-control"
          style = "border-color: {{ isset($color_error_password) ? $color_error_password : ''  }}"
          name="password" placeholder="Password">
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          
        </div>
        <div style="display: flex; justify-content: center"><a href="forgot-password.html" style="padding:0; margin:0;font-size:14px">I forgot my password</a></div>
        
        <div class="input-group mb-3"  style=" margin-top:10px !important;">
        <button type="submit" style="width: 100%" class="btn btn-primary btn-block">Sign In</button>
          <div class="input-group-append">
           
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
                <p class="mb-1">
                    
                </p>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            
          </div>
          <!-- /.col -->
        </div>
      </form>

     
      <!-- /.social-auth-links -->

     
  
    </div>
    
@endsection



@section('header')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/adminltemin.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/adminlte.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/updates.css') }}">
  <script src="{{ asset('dist/js/modals.js') }}"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <script src="{{ asset('dist/js/jquery-3.7.1.min.js') }}"></script>
@endsection