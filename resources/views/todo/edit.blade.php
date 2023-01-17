
<?php
/* Default values */
$_PAGE_TITLE='Edit TODO';
$_PAGE_SUB_TITLE='change the todo info';
?>
@extends('layout.gui')
@section('content')
	  <form class="form-horizontal"  method="post" action="{{route('todo.update',$todo->id)}}" enctype="multipart/form-data">
     {{csrf_field()}}
  <fieldset>

  <!-- Form Name -->
  <legend></legend>

 <div class="form-group">
    <label class="col-md-2 control-label" for="assigned_to">Assigned_to</label>
    <div class="col-md-6">
      <select id="assigned_to" name="assigned_to" class="form-control">
        <option value="0" {{$todo->assigned_to==0 ? 'selected':''}} >Any</option>
        @foreach(\App\User::where('id','!=',2)->get() as $user)
        {{-- expr --}}
        <option value="{{$user->id}}" {{$todo->assigned_to==$user->id ? 'selected':''}}>{{$user->full_name}}</option>
        @endforeach
       
      </select>
      </div>
      </div>

<?php
  $statuses=['NOT_STARTED','ONGOING','POSTPONED','DONE'];
    ?>
   <div class="form-group">
    <label class="col-md-2 control-label" for="status">status</label>
      <div class="col-md-4">
      <select id="status" name="status" >
        @foreach ($statuses as $status)
          <option value="{{$status}}" {{$todo->status===$status?"selected":""}}>{{$status}}</option>
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
<span class="label label-primary"><i class="fa fa-check" aria-hidden="true"></i>  DONE</span>
: Ready for release and publishing.
</li>

			</ul>
			</span>
      </div>
    </div>

   <div class="form-group">
    <label class="col-md-2 control-label" for="discription">TODO Description</label>
    <div class="col-md-6">
    <textarea id="discription"  name="description" class="ckeditor form-control input-md" required="">{{$todo->description}}</textarea>
		<span class="help-block">Note : the summary is the first 200 chracters in the text</span>
		</div>
  </div>


 <!-- Select Basic -->
  <!--  <div class="form-group">
    <label class="col-md-4 control-label" for="deadline">TODO DeadLine <i class="fa fa-calendar"></i></label>
    <div class="col-md-4">

          <div class="box box-primary">

              <! THE CALENDAR -->
           <!--    <input type="date" id="deadline"  value="{{old('deadline')}}" name="deadline" class=" form-control" />

            <! /.box-body -->
          <!-- </div> -->
          <!-- /. box -->
        <!-- </div>
 -->        <!-- /.col -->
      <!-- </div> -->



  <!-- Button -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" class="btn btn-primary">Save</button>
    </div>
  </div>

  </fieldset>
  </form>

@endsection
