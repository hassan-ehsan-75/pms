<?php
/* Default values */
$_PAGE_TITLE='Create News';
$_PAGE_SUB_TITLE='create a new News';
?>
@extends('layout.gui')
@section('content')
	<form class="form-horizontal" method="post" action="{{ route('news.store') }}" enctype="multipart/form-data">
    {{csrf_field()}}

  <fieldset>

  <!-- Form Name -->
  <legend></legend>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-2 control-label" for="title">Title</label>
    <div class="col-md-6">
      <input type="text" id="news_title" name="title" class="form-control" required="">
	  <span class="help-block">Note : prefered max-length 60 chracters</span>
    </div>
  </div>

      <div class="form-group">
    <label class="col-md-2 control-label" for="status">Status</label>
    <div class="col-md-6">
      <select id="status" name="status" class="form-control">
        <option value="DRAFT" selected="true" >DRAFT</option>
        <option value="PUBLISHED">PUBLISHED</option>
      </select>

	   <span class="help-block">
                       <ul>
                        <li>
						   <span class="label label-primary"><i class="fa fa-newspaper-o" aria-hidden="true"></i> DRAFT</span>
						: Still needs improvment.
						</li>
                        <li>
						  <span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> PUBLISHED</span>
						: Published on the companies site.</li>
                     </ul>
         </span>
    </div>
  </div>


   <div class="form-group">
    <label class="col-md-2 control-label" for="image_url">Image link</label>
    <div class="col-md-6">
      <input type="file" id="image_url" name="image_url" >
	     <span class="help-block">Images should have 16:9 ratio</span>
    </div>
  </div>


   <div class="form-group">
    <label class="col-md-2 control-label" for="content">News Content</label>
    <div class="col-md-8">
    <textarea id="news_content"  name="content" class="ckeditor form-control input-md" required=""></textarea>
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

@endsection
