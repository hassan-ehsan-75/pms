
<?php
/* Default values */
$_PAGE_TITLE='Edit Token';
$_PAGE_SUB_TITLE='change the token type';
?>
@extends('layout.gui')
@section('content')
	  <form class="form-horizontal"  method="post" action="{{route('apiToken.update',$token->id)}}" enctype="multipart/form-data">
     {{csrf_field()}}
  <fieldset>

  <!-- Form Name -->
  <legend></legend>

 <div class="form-group">
    <label class="col-md-2 control-label" for="type">Type :</label>
    <div class="col-md-6">
      <select id="assigned_to" name="type" class="form-control">
        <option value="public" {{$token->type =='public' ? 'selected':''}} >Public</option>
        <option value="private" {{$token->type =='private' ? 'selected':''}} >Private</option>
      
       
      </select>
      </div>
      </div>
  <div class="form-group">
    <label class="col-md-2 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" class="btn btn-primary">Save</button>
    </div>
  </div>

  </fieldset>
  </form>

@endsection
