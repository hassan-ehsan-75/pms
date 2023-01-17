
<?php
/* Default values */
$_PAGE_TITLE='Edit Project';
$_PAGE_SUB_TITLE='change the task info';
?>
@extends('layout.gui')
@section('content')
<div class="container-fluid">
 <form class="form-horizontal" action="{{ route('project.update',$project->id) }}" method="post" enctype="multipart/form-data">
     {{csrf_field()}}
  <fieldset>

  <!-- Form Name -->



 <div class="box-body">
  <div class="form-group">
    <label class="col-md-2 control-label" for="title">Project Title</label>
    <div class="col-md-4">
    <input id="title" name="title" type="text" placeholder="project title" class="form-control input-md" required="" value="{{$project->title}}">
    <span class="help-block">Note : prefered max-length 60 chracters</span>
    </div>
  </div>
  <div class="form-group">
                  <label class="col-md-2 control-label" for="phase">Phase</label>
                  <div class="col-md-6">
                     <select id="phase" name="phase" class="form-control">
                        <option value="Desgin" name="phase"  {{$project->phase=='Desgin' ? 'selected':''}}>Desgin</option>
                        <option value="Development" name="phase" {{$project->phase=='Development' ? 'selected':''}}>Development</option>
                        <option value="Testing" name="phase" {{$project->phase=='Testing' ? 'selected':''}} >Testing</option>
                        <option value="Release" name="phase" {{$project->phase=='Release' ? 'selected':''}}>Release</option>
                        
                     </select>
                     </div>
                     </div>
  <?php  $statuses=[
  'NOT_STARTED','ONGOING','POSTPONED','DONE','PUBLISHED'
  ];
   ?>
   <div class="form-group">
    <label class="col-md-2 control-label" for="status">status</label>
    <div class="col-md-4">
      <select id="status" name="status" class="form-control">
        @foreach ($statuses as $status)
          <option value="{{$status}}" name="status" {{$project->status==$status ? 'selected':''}}>{{$status}}</option>
        @endforeach
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
      <input type="file" id="image_url" name="image_url"  >
    <span class="help-block"></span>
    </div>
  </div>



  @if ($project->attachment)
  <div class="form-group">
    <label class="col-md-2 control-label" for="current_image">Current image</label>
    <div class="col-md-6">
     <img id="current_image" class="img-responsive" src="{{asset($project->getAttachment())}}"/>
   <!--a class="btn btn-danger">Delete image </a-->
   <input id="current" name="current_image" type="text" hidden="true" value="{{$project->getAttachment()}}" />
    <a  class="btn btn-danger" id='remove' onclick="remove()">Remove</a>
    </div>
  </div>
  @endif


   <div class="form-group">
 <label class="col-md-2 control-label" for="description">Content</label>

      <!-- /.box-header -->
            <div class="col-md-6">
                    <textarea id="description" name="description" class="ckeditor" required="">{{$project->description}}</textarea>
                    <span class="help-block">Note : the summary is the first 200 chracters in the text</span>
            </div>
          </div>
          <!-- /.box -->


  </div>
  </div>
  <!-- Button -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="submit"></label>
    <div class="col-md-4">
       <button id="submit" name="submit" class="btn btn-primary pull-right">Update</button>
    </div>
  </div>

  </fieldset>
  </form>
  </div>
  <script>


  function remove(){

    $('#current').attr('value','');
    $('#current_image').attr('src',"{{asset('dist/img/boxed-bg.png')}}");
  }


</script>


@endsection
