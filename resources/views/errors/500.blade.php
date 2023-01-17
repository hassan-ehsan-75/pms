
<?php

$_PAGE_TITLE='Internal server error';
$_PAGE_SUB_TITLE='500 Error';
?>
@extends('layout.gui')
@section('content')
<h4>
        500 Error Page
      </h4>
          <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-read"> 500</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> Oops! Internal server error.</h3>

          <p>
            we have some problem please come back later
            Meanwhile, you may <a href="{{route('dashboard')}}">return to dashboard</a>
          </p>

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
@endsection('content')