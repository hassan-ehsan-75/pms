<!DOCTYPE HTML>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <title>Nasable | Log in</title>
	  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
   <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
   <link rel="stylesheet" href="{{asset('dist/css/skins/skin-blue.min.css')}}">
   <link rel="stylesheet" href="{{asset('css/nasable.css')}}">
         <!-- jQuery 2.2.3 -->
<script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
       <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>

  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
</head>
    
<body class="login-page" >
<div class="login-box">
  <div class="login-logo">
    <a href="nasable.com"><img src="img/nasable_logo.png"/></a>
  </div>
  <!-- /.login-logo -->
  <div class="">
  <div class="login-box-body col-sm-12 ">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="{{route('login')}}" method="post">
    {{csrf_field()}}
    @include('layout.errors')
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="user name" name="user_name">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">

        <div class="col-xs-8">
            <label>
              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>


  </div>
  <!-- /.login-box-body -->
</div>

</div>
<!-- /.login-box -->

<!-- jQuery 3 -->

<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>

</body>
