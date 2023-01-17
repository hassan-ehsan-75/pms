
<?php
/* Default values */
$_PAGE_TITLE='Edit task';
$_PAGE_SUB_TITLE='change the task info';
?>
@extends('layout.gui')

@section('content')

         <div class="container-fluid">
    <form class="form-horizontal"  method="post" action="{{route('task.update',$task->id)}}" enctype="multipart/form-data">
    {{csrf_field()}}
  <fieldset>

  <!-- Form Name -->

<legend></legend>
<div class="box-body">
  <!-- Select Basic -->

   <div class="form-group">
    <label class="col-md-2 control-label" for="priority">Priority</label>
    <div class="col-md-6">
      <select id="priority" name="priority" class="form-control">
        <option value="Low" {{$task->priority=='Low' ? 'selected':''}} >Low</option>
        <option value="Normal" {{$task->priority=='Normal' ? 'selected':''}}>Normal</option>
        <option value="High" {{$task->priority=='High' ? 'selected':''}}>High</option>
      </select>
      </div>
      </div>

      <div class="form-group">
                <label class="col-md-2 control-label">DeadLine:</label>

                <div class="input-group date col-md-6">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" value="{{$task->deadline}}" name="deadline" class="form-control pull-right" id="datepicker" required="">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
   <div class="form-group">
      <label class="col-md-2">Content</label>
            <div class="col-md-6">
                    <textarea id="content" name="content" class="ckeditor" required="">{!!$task->content!!}</textarea>
                    <span class="help-block">Note : the summary is the first 200 chracters in the text</span>
            </div>
          </div>
          <!-- /.box -->

  </div>
  
  


  <!-- Button -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" class="btn btn-primary ">Update</button>
    </div>
  </div>

  </fieldset>

  </form>
  </div>
  


@endsection
