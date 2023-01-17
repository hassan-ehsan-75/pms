
<?php
/* Default values */
$_PAGE_TITLE= $user->full_name;
$_PAGE_SUB_TITLE='change the  user info';
$_ACTIVE = 'user'
?>
 <!-- Main content -->
 @extends('layout.gui')
 @section('content')
   {{-- expr --}}
 
  <section class="content">

    <form class="form-horizontal" method="post" action="{{route('user.update',$user->id)}}" 
    enctype="multipart/form-data">
    {{csrf_field()}}
   
  <fieldset>

  <!-- Form Name -->
 
<div class="box-body">
  <!-- Text input-->
  <div class="form-group email">
   <label class="col-md-2 control-label" for="email">E-mail</label>
    <div class="col-md-4">
       
    <input id="email" name="email" type="email" placeholder="email" class="form-control input-md" required="" value="{{$user->email}}"  onkeypress="validateEmail(this);" onblur="validateEmail(this);">
    <span class="help-block">Assign email to the  user</span>
    </div>
  </div>

  <div class="form-group">
   <label class="col-md-2 control-label" for="username">user Name</label>
    <div class="col-md-4">
       
    <input id="user_name" name="user_name" type="text" placeholder="user name" class="form-control input-md" required=""
    value="{{$user->user_name}}">
    <span class="help-block">Assign user name to the  user</span>
    </div>
  </div>

  

<!-- <div class="form-group password">
    <label class="col-md-4 control-label" for="password">Password</label>
    <div class="col-md-4">
    <input id="password" name="password" type="password" placeholder="password" class="form-control input-md"  onkeypress="validatePassword(this);" onblur="validatePassword(this);">
    <span class="help-block">Assign Password to the  user_ if no new password is submitted the old one will be kept</span>
    </div>
  </div> -->

    <div class="form-group">
    <label class="col-md-2 control-label" for="full_name">Full name</label>
    <div class="col-md-4">
    <input id="full_name" name="full_name" type="text" placeholder="First name Last name" class="form-control input-md" required="" value="{{$user->full_name}}">
    <span class="help-block">First name Last name</span>
    </div>
  </div>

 <div class="form-group">
    <label class="col-md-2 control-label" for="title">Title</label>
    <div class="col-md-4">
      <select id="title" name="title" class="form-control">

      @foreach (\App\Title::all() as $title)
        {{-- expr --}}
        <option value="{{$title->id}}" {{$user->getTitle()==$title->title_name ? 'selected':''}}>{{$title->title_name}}</option>
        @endforeach

      </select>
    </div>
  </div>
   <div class="form-group">
    <label class="col-md-2 control-label" for="permission">permission</label>
    <div class="col-md-4">
      <select id="permission" name="permission" class="form-control">

      @foreach (\App\Permission::all() as $permission)
        {{-- expr --}}
        <option value="{{$permission->id}}" name="permission" {{$user->getPermission()==$permission->permission_name ? 'selected':''}} >{{$permission->permission_name}}</option>
        @endforeach

      </select>
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-2">
    </div>
    <div class="col-md-4">
      <input type="checkbox" name="activated" {{$user->activated ? 'checked':''}} >activated
    </div>
  </div>


  <div class="form-group" >
    <label class="col-md-2 control-label" for="profile_image">Profile pic</label>
    <div class="col-md-4">
      <input id="profile_image" name="profile_image" class="input-file" type="file" >
    </div>
  </div>

 
  <div class="form-group">
    <label class="col-md-2 control-label" for="current_image">Current image</label>
    <div class="col-md-6">
     <img id="current_image" class="img-responsive" src="{{asset($user->getAttachment())}}"/>
   <!--a class="btn btn-danger">Delete image </a-->
   <input id="current" name="current_image" type="text" hidden="true" value="{{$user->getAttachment()}}" />
    </div>
    <a  class="btn btn-danger" id='remove' onclick="remove()">Remove</a>
    </div>
  </div>
 
  
  <hr>
 <!-- skills -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="skills">Skills</label>
    <div class="col-md-4">
    <input id="skills" name="skills" type="text"  class="form-control input-md" value="{{$user->skills}}"> 
    </div>
  </div>
  <!-- about-->
  <div class="form-group">
    <label class="col-md-2 control-label" for="about">About</label>
    <div class="col-md-4">
    <input id="about" name="about" type="text"  class="form-control input-md"  value="{{$user->about}}">
    </div>
  </div>
  <!-- location -->
   <div class="form-group">
    <label class="col-md-2 control-label" for="location">Location</label>
    <div class="col-md-4">
    <input id="location" name="location" type="text"  class="form-control input-md"  value="{{$user->location}}">
    </div>
  </div>
 <div class="form-group">
    <label class="col-md-2 control-label" for="phone">phone</label>
    <div class="col-md-4">
       
    <input id="phone" name="phone" type="tel" placeholder="phone" class="form-control input-md" value="{{$user->phone}}">
    <span class="help-block">telephone number(optinal)</span>
    </div>
  </div>

<div class="form-group">
    <label class="col-md-2 control-label" for="facebook">facebook</label>
    <div class="col-md-4">
       
    <input id="facebook" name="facebook" type="facebook" placeholder="facebook" class="form-control input-md" value="{{$user->facebook}}">
    <span class="help-block">Facebook account(optinal)</span>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-2 control-label" for="skype">skype</label>
    <div class="col-md-4">
       
    <input id="skype" name="skype" type="skype" placeholder="skype" class="form-control input-md" value="{{$user->skype}}">
    <span class="help-block">skype(optional)</span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label" for="twitter">twitter</label>
    <div class="col-md-4">
       
    <input id="twiter" name="twiter" type="twitter" placeholder="twitter" class="form-control input-md" value="{{$user->twiter}}">
    <span class="help-block">twiter(optinal)</span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label" for="linkedin">linkedin</label>
    <div class="col-md-4">
       
    <input id="linkedin" name="linkedin" type="linkedin" placeholder="linkedin" class="form-control input-md" value="{{$user->linkedin}}">
    <span class="help-block">linkedin (optinal)</span>
    </div>
  </div>


  <!-- Select Basic -->
  


  <!-- Text input-->


  <!-- Button -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" class="btn btn-primary">update</button>
    </div>
  </div>
  </div>

  </fieldset>
 
  </form>


  </section>

  <script>
    var email = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    
    function validateEmail () {
      if (!email.test($('#email').val())){
  $('.email').addClass('has-error');
  $('.emailspan').html('invaled E-mail address');
  $('#submit').prop('disabled', true);
}else{
  $('.email').removeClass('has-error');
  $('.emailspan').html('Assign email to the new user');
  $('#submit').prop('disabled', false);
}
    }
     function validatePassword(){
      if ($('#password').val().length < 8 ) {
         $('.password').addClass('has-error');
         $('.passwordspan').html('the password is less thas 8 characters');
         $('#submit').prop('disabled', true);
      }else{
               $('.password').removeClass('has-error');
         $('.passwordspan').html('Assign Password to the new user');
         $('#submit').prop('disabled', false);
      }
     }

    
  function remove(){

    $('#current').attr('value','');
    $('#current_image').attr('src',"{{asset('dist/img/boxed-bg.png')}}");
  }

  </script>

  @endsection
