
<?php
/* Default values */
$_PAGE_TITLE='Create Announsement';
$_PAGE_SUB_TITLE='create a new Announsement';
$_ACTIVE = 'user'
?>
   @extends('layout.gui')
   @section('content')

<div class="container-fluid">
    <form class="form-horizontal" method="post" action="{{ route('announcement.store') }}">
    {{csrf_field()}}

  <fieldset>

  <!-- Form Name -->


  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-2 control-label" for="title">Title</label>
    <div class="col-md-4">
      <input type="text" id="announsement_title" name="title" class="form-control" required="">
       <span class="help-block">Note : prefered max-length 60 chracters</span>
    </div>
  </div>

   <div class="form-group">
    <label class="col-md-2 control-label" for="content">Announsement Content :</label>
    <div class="col-md-8">
    <textarea id="content"  name="content" class="ckeditor form-control input-md" required=""></textarea>
     <span class="help-block">Note : the summary is the first 200 chracters in the text</span>
    </div>
  </div>

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" class="btn btn-primary">Create</button>
    </div>
  </div>

  </fieldset>
  </form>
  </div>
   @endsection
