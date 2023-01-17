
<?php

$_PAGE_TITLE='Access Denide';
$_PAGE_SUB_TITLE='403 Error';
?>
@extends('layout.gui')
@section('content')
<h4>
        403 Error Page
      </h4>
    

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-read"> 403</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> Oops! Access Denide.</h3>

          <p>
            you dont have permission to access this page
            Meanwhile, you may <a href="{{route('dashboard')}}">return to dashboard</a>
          </p>

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
@endsection('content')