
<?php
/* Default values */
$_PAGE_TITLE='Create User';
$_PAGE_SUB_TITLE='create a new user';
$_ACTIVE = 'user'
?>
 <!-- Main content -->
 @extends('layout.gui')
 @section('content')
   {{-- expr --}}
 <div class="container-fluid">
  

    <form class="form-horizontal" method="post" action="{{route('user.store')}}" 
    enctype="multipart/form-data">
    {{csrf_field()}}
   
  <fieldset>

  <!-- Form Name -->
  
<div class="box-body">
  <!-- Text input-->
  <div class="form-group  email">
   <label class="col-md-2 control-label" for="email">E-mail</label>
    <div class="col-md-4">
       
    <input id="email" name="email" type="email" placeholder="email" class="form-control input-md" onkeypress="validateEmail(this);" onblur="validateEmail(this);" required="">
    <span class="help-block emailspan">Assign email to the new user</span>
    </div>
  </div>

  <div class="form-group">
   <label class="col-md-2 control-label" for="username">user Name</label>
    <div class="col-md-4">
       
    <input id="user_name" name="user_name" type="text" placeholder="user name" class="form-control input-md" required="">
    <span class="help-block">Assign user name to the new user</span>
    </div>
  </div>

  </div>

<div class="form-group password">
    <label class="col-md-2 control-label" for="password">Password</label>
    <div class="col-md-4">
    <input id="password" name="password" type="password" placeholder="password" class="form-control input-md" onblur="validatePassword(this);" onkeydown="validatePassword(this);" required="">
    <span class="help-block passwordspan">Assign Password to the new user</span>
    </div>
  </div>

    <div class="form-group">
    <label class="col-md-2 control-label" for="full_name">Full name</label>
    <div class="col-md-4">
    <input id="full_name" name="full_name" type="text" placeholder="First name Last name" class="form-control input-md" required="">
    <span class="help-block">First name Last name</span>
    </div>
  </div>
 <!-- Select Basic -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="title">Title</label>
    <div class="col-md-4">
      <select id="title" name="title" class="form-control">


      @foreach (\App\Title::all() as $title)
        {{-- expr --}}
        <option value="{{$title->id}}" name="title">{{$title->title_name}}</option>
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
        <option value="{{$permission->id}}" name="permission">{{$permission->permission_name}}</option>
        @endforeach

      </select>
    </div>
  </div>
    
  <div class="form-group">
    <label class="col-md-2" ></label>
    <div class="col-md-4">
      <input type="checkbox" name="activated" {{old('cheched')? 'checked':'' }} >activated
    </div>
  </div>


  <div class="form-group" >
    <label class="col-md-2 control-label" for="profile_image">Profile pic</label>
    <div class="col-md-4">
      <input id="profile_image" name="profile_image" class="input-file" type="file">
    </div>
  </div>
   
  <hr>
  </h2>
 <!-- skills -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="skills">Skills</label>
    <div class="col-md-4">
    <input id="skills" name="skills" type="text" placeholder="skills the user have" class="form-control input-md">
    </div>
  </div>
  <!-- about-->
  <div class="form-group">
    <label class="col-md-2 control-label" for="about">About</label>
    <div class="col-md-4">
    <input id="about" name="about" type="text" placeholder="some info about the user" class="form-control input-md" >
    </div>
  </div>
  <!-- location -->
   <div class="form-group">
    <label class="col-md-2 control-label" for="location">Location</label>
    <div class="col-md-4">
    <input id="location" name="location" placeholder="the user Country" type="text"  class="form-control input-md" >
    </div>
  </div>
 
 <div class="form-group phone">
    <label class="col-md-2 control-label" for="phone">phone</label>
    <div class="col-md-4">
       
    <input id="phone" name="phone" type="tel" placeholder="phone" class="form-control input-md"  onblur="validatePhone(this);" onkeydown="validatePhone(this);">
    <span class="help-block phonespan">telephone number(optinal)</span>
    </div>
  </div>

<div class="form-group">
    <label class="col-md-2 control-label" for="facebook">facebook</label>
    <div class="col-md-4">
       
    <input id="facebook" name="facebook" type="facebook" placeholder="facebook" class="form-control input-md" >
    <span class="help-block">Facebook account(optinal)</span>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-2 control-label" for="skype">skype</label>
    <div class="col-md-4">
       
    <input id="skype" name="skype" type="skype" placeholder="skype" class="form-control input-md" >
    <span class="help-block">skype(optional)</span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label" for="twitter">twitter</label>
    <div class="col-md-4">
       
    <input id="twiter" name="twiter" type="twitter" placeholder="twitter" class="form-control input-md" >
    <span class="help-block">twiter(optinal)</span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label" for="linkedin">linkedin</label>
    <div class="col-md-4">
       
    <input id="linkedin" name="linkedin" type="linkedin" placeholder="linkedin" class="form-control input-md" >
    <span class="help-block">linkedin (optinal)</span>
    </div>
  </div>

 
  <!-- Select Basic -->
  


  <!-- Text input-->


  <!-- Button -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" class="btn btn-primary">Create</button>
    </div>
  </div>
  </div>

  </fieldset>

  </form>

</div>

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
     function validatePhone(){
      if (!$.isNumeric($('#phone').val())) {
         $('.phone').addClass('has-error');
         $('.phonespan').html('the phone number should not contain letters');
      }else{
         $('.phone').removeClass('has-error');
         $('.phonespan').html('');
      }
     }
  </script>
  @endsection