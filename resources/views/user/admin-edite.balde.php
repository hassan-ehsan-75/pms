 <!-- Main content -->
 @extends('layout.gui')
<?php
/* Default values */
$_PAGE_TITLE='Edit User';
$_PAGE_SUB_TITLE='change the Users info';
?>
@extends('layout.gui')
@section('content')
 @section('content')
   {{-- expr --}}

  <section class="content">

    <form class="form-horizontal" method="post" action="{{route('user.update',$user->id)}}" 
    enctype="multipart/form-data">
    {{csrf_field()}}
  <fieldset>

  <!-- Form Name -->
  <legend></legend>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="username">Username</label>
    <div class="col-md-4">
    
    <input id="username" name="user_name" type="text" placeholder="username" class="form-control input-md" required="">
    <span class="help-block">Username to login with</span>
    </div>
  </div>

{{-- <div class="form-group">
    <label class="col-md-4 control-label" for="password">Password</label>
    <div class="col-md-4">
       
    <input id="password" name="password" type="password" placeholder="password" class="form-control input-md" required="">
    <span class="help-block">Assign Password to the new user</span>
    </div>
  </div> --}}

  <!-- Select Basic -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="title">Title</label>
    <div class="col-md-4">
      <select id="title" name="title" class="form-control">

      @foreach (\App\Title::all() as $title)
        {{-- expr --}}
        <option value="{{$title->id}}" name="title" 
          {{$user->getTitle()==$title->title_name ? 'selected':''}}>
          {{$title->title_name}}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label" for="permission">permission</label>
    <div class="col-md-4">
      <select id="permission" name="permission" class="form-control">

      @foreach (\App\Permission::all() as $permission)
        {{-- expr --}}
        <option value="{{$permission->id}}" name="permission" {{$user->getPermission()==$permission->permission_name ? 'selected':''}}>{{$permission->permission_name}}</option>
        @endforeach

      </select>
    </div>
  </div>
  

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="full_name">Full name</label>
    <div class="col-md-4">
      
    <input id="full_name" name="full_name" type="text" placeholder="First name Last name" class="form-control input-md" required="" value="{{$user->full_name}}">
    <span class="help-block">First name Last name</span>
    </div>
  </div>

  <!-- File Button -->
{{-- 
  <div class="form-group" >
    <label class="col-md-4 control-label" for="profile_image">Profile pic</label>
    <div class="col-md-4">
      <input id="profile_image" name="profile_image" class="input-file" type="file">
    </div>
  </div> --}}

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" class="btn btn-primary">Update</button>
    </div>
  </div>

  </fieldset>
  </form>
   <script >
   document.getElementById("username").value="{{$user->user_name}}";
 </script>


  </section>
  @endsection