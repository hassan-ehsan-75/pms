<?php
/* Default values */
$_PAGE_TITLE='Edit Jobs';
$_PAGE_SUB_TITLE='change the Job info';
?>
@extends('layout.gui')
@section('content')
	    <form class="form-horizontal" method="post" action="{{ route('job.update',$job->id) }}" enctype="multipart/form-data">
    {{csrf_field()}}

  <fieldset>


  <div class="form-group">
    <label class="col-md-2 control-label" for="title">Title</label>
    <div class="col-md-4">
      <input type="text" id="job_title" name="title" class="form-control" value="{{$job->title}}" required="">
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
    <label class="col-md-2 control-label" for="image_url">Image</label>
    <div class="col-md-6">
      <input type="file" id="image_url" name="image_url"  >
	  <span class="help-block">Images should have 16:9 ratio</span>
    </div>
  </div>

  @if ($job->attachment_id)
  <div class="form-group">
    <label class="col-md-2 control-label" for="current_image">Current image</label>
    <div class="col-md-6">
     <img id="current_image" class="img-responsive" src="{{asset($job->getAttachment())}}"/>
	 <!--a class="btn btn-danger">Delete image </a-->
    </div>
  </div>
  @endif




   <div class="form-group">
    <label class="col-md-2 control-label" for="content">job Content</label>
    <div class="col-md-8">
    <textarea id="job_content"  name="content" class="ckeditor form-control input-md" required=""> {!!$job->content!!}</textarea>
	 <span class="help-block">Note : the summary is the first 200 chracters in the text</span>
    </div>
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

@endsection
