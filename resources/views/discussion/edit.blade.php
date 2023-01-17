
<?php
/* Default values */
$_PAGE_TITLE='Edit Discussion';
$_PAGE_SUB_TITLE='change the discussion info';
?>
@extends('layout.gui')
@section('content')

       <form class="form-horizontal"  method="post" action="{{route('discussion.update',$discussion->id)}}" enctype="multipart/form-data">
     {{csrf_field()}}
  <fieldset>

  <!-- Form Name -->
  <legend></legend>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-2 control-label" for="title">Title</label>
    <div class="col-md-4">
      <input type="text" id="title" name="title" class="form-control" value="{{$discussion->title}}" required="">
			 <span class="help-block">Note : prefered max-length 60 chracters</span>
    </div>
  </div>

   <div class="form-group">
    <label class="col-md-2 control-label" for="content">Discussion Content</label>
    <div class="col-md-8">
    <textarea id="content"  name="content" class="ckeditor form-control input-md" required="">
      {{$discussion->content}}
    </textarea>
		 <span class="help-block">Note : the summary is the first 200 chracters in the text</span>
    </div>
  </div>


  <div class="form-group">
      <input type="hidden" id="type" name="type" value="{{$type}}" class="form-control">
  </div>

  <div class="form-group">
      <input type="hidden" id="link_id" name="link_id" value="{{$link_id}}" class="form-control">
  </div>


  <!-- Button -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" class="btn btn-primary">Save</button>
    </div>
  </div>

  </fieldset>
  </form>

  </fieldset>
  </form>
  

@endsection
