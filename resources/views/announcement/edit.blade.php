
<?php
/* Default values */
$_PAGE_TITLE='Edit Announsement';
$_PAGE_SUB_TITLE='change the Announsement info';
?>
@extends('layout.gui')
@section('content')
	  <div class="container-fluid">
   <form class="form-horizontal" method="post" action="{{ route('announcement.update',['id'=>$announcement->id]) }}">
    {{csrf_field()}}
  <fieldset>

  <!-- Form Name -->
  <legend></legend>



   <!-- Text input-->
  <div class="form-group">
    <label class="col-md-2 control-label" for="title">Title</label>
    <div class="col-md-4">
      <input type="text" id="title" name="title" class="form-control" value="{{$announcement->title}}" required="">
			 <span class="help-block">Note : prefered max-length 60 chracters</span>
    </div>
  </div>



 <!-- Select Basic -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="content">Announsement Content :</label>
    <div class="col-md-8">
    <textarea id="content"  name="content" class="ckeditor form-control input-md" required="">{!!$announcement->content!!}</textarea>
		 <span class="help-block">Note : the summary is the first 200 chracters in the text</span>
      </div>
      <!-- /.row -->
</div>




  <!-- Button -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" class="btn btn-primary">Update</button>
    </div>
  </div>

  </fieldset>
  </form>
</div>



@endsection
