
<?php

$_PAGE_TITLE='Page Not Found';
$_PAGE_SUB_TITLE='404 Error';
?>
@extends('layout.gui')
@section('content')
<h4>
        404 Error Page
      </h4>
     
   

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="{{route('dashboard')}}">return to dashboard</a> 
          </p>

         
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
@endsection('content')