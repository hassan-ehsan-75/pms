
<?php
/* Default values */
$_PAGE_TITLE='Create Discussion';
$_PAGE_SUB_TITLE='create a new discussion';
?>
@extends('layout.gui')
@section('content')

	   <form class="form-horizontal"  method="post" action="{{route('discussion.store')}}" enctype="multipart/form-data">
     {{csrf_field()}}
  <fieldset>

  <!-- Form Name -->
  <legend></legend>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-2 control-label" for="title">Title</label>
    <div class="col-md-6">
      <input type="text" id="title" name="title" class="form-control" required="">
			<span class="help-block">Note : prefered max-length 60 chracters</span>
    </div>
  </div>

   <div class="form-group">
    <label class="col-md-2 control-label" for="content">Discussion Content</label>
    <div class="col-md-9">
    <textarea id="content"  name="content" class="ckeditor form-control input-md" required=""></textarea>
		 <span class="help-block">Note : the summary is the first 200 chracters in the text</span>
    </div>
  </div>

  <div class="form-group">
      <input type="hidden" id="type" name="type" value="{{$type}}" class="form-control"/>
  </div>

  <div class="form-group">
      <input type="hidden" id="link_id" name="link_id" value="{{$link_id}}" class="form-control"/>
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
