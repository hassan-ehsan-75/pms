<?php
   /* Default values */
   $_PAGE_TITLE='Create Project';
   $_PAGE_SUB_TITLE='create a new project';
   ?>
@extends('layout.gui')
@section('content')
<div class="container-fluid">
   <!-- general form elements -->


      <form class="form-horizontal"  method="post" action="{{route('project.store')}}" enctype="multipart/form-data">
         {{csrf_field()}}
         <fieldset>
            <!-- Form Name -->
            <legend></legend>
            <div class="box-body">
               <!-- Select Basic -->
               <div class="form-group">
                  <label class="col-md-2 control-label" for="title">Title</label>
                  <div class="col-md-6">
                     <input type="text" class="form-control" name="title" required="">
                     <span class="help-block">Note : prefered max-length 60 chracters</span>
                  </div>
               </div>
                <div class="form-group">
                  <label class="col-md-2 control-label" for="phase">Phase</label>
                  <div class="col-md-6">
                     <select id="phase" name="phase" class="form-control">
                        <option value="Desgin" name="status">Desgin</option>
                        <option value="Development" name="status">Development</option>
                        <option value="Testing" name="status">Testing</option>
                        <option value="Release" name="status">Release</option>
                        
                     </select>
                     </div>
                     </div>
               <div class="form-group">
                  <label class="col-md-2 control-label" for="status">Status</label>
                  <div class="col-md-6">
                     <select id="status" name="status" class="form-control">
                        <option value="NOT_STARTED" name="status">NOT_STARTED</option>
                        <option value="ONGOING" name="status">ONGOING</option>
                        <option value="POSTPONED" name="status">POSTPONED</option>
                        <option value="DONE" name="status">DONE</option>
                        <option value="PUBLISHED" name="status">PUBLISHED</option>
                     </select>
                     <span class="help-block">
                       <ul>
                       <li>
							<span class="label label-danger"><i class="fa fa-ban" aria-hidden="true"></i> NOT_STARTED</span>
							: Still in brain storming and desgin phase.
						</li>
                       <li>
						   <span class="label label-success"><i class="fa fa-spinner" aria-hidden="true"></i> ONGOING</span>
						   : In development phase.
					   </li>
                       <li>
						   <span class="label label-warning"><i class="fa fa-pause" aria-hidden="true"></i> POSTPONED</span>
						   : Temporarily stoped development.
					   </li>
                        <li>
						   <span class="label label-primary"><i class="fa fa-newspaper-o" aria-hidden="true"></i> DONE</span>
						: Ready for release and publishing.
						</li>
                        <li>
						  <span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> PUBLISHED</span>
						: Published in the companies portfolio.</li>
                     </ul>
                     </span>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-2 control-label" for="image_url">Image</label>
                  <div class="col-md-6">
                     <input id="image_url" type="file" name="image_url" >
                     <span class="help-block">Images should have 16:9 ratio</span>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-2 control-label" for="description">Description</label>
                  <!-- /.box-header -->
                  <div class="col-md-8">
                     <textarea id="description" name="description" class="ckeditor" required=""></textarea>
                     <span class="help-block">Note : the summary is the first 200 chracters in the text</span>
                  </div>
               </div>
               <!-- Button -->
               <div class="form-group">
                  <label class="col-md-2 control-label" for="submit"></label>
                  <div class="col-md-4">
                     <button id="submit" name="submit" class="btn btn-primary ">Create</button>
                  </div>
               </div>
            </div>
			<!-- /.box -->
   </div>
</div>
</fieldset>
</form>

</div>
@endsection
