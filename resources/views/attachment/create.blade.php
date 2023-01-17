<?php
/* Default values */
$_PAGE_TITLE='Create attachment';
$_PAGE_SUB_TITLE='create a new attachment';
?>
@extends('layout.gui')
@section('content')
   <form class="form-horizontal" method="post" action="{{ route('attachment.store') }}" enctype="multipart/form-data">
    {{csrf_field()}}

  <fieldset>

  <!-- Form Name -->
  <legend></legend>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="title">Title</label>
    <div class="col-md-4">
      <input type="text" id="attachment_title" name="title" class="form-control" required="">
    </div>
  </div>

   <div class="form-group">
    <label class="col-md-4 control-label" for="file_url">attachment</label>
    <div class="col-md-4">
      <input type="file" id="file_url" name="attachment" class="form-control" required="" onchange="getExtension()">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label" for="extension">extension</label>
    <div class="col-md-4">
      <input type="hidden" id="extension" name="extension" class="form-control" required="" >
    </div>
  </div>

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" class="btn btn-primary">Create</button>
    </div>
  </div>

  </fieldset>
  </form>

@endsection