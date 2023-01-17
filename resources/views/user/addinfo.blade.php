
<?php
/* Default values */
$_PAGE_TITLE='add Info';
$_PAGE_SUB_TITLE='Add info';
$_ACTIVE = 'user'
?>
 <!-- Main content -->
 @extends('layout.gui')
 @section('content')
   {{-- expr --}}
 
  <div class="container-fluid">

    <form class="form-horizontal" method="post" action="{{route('user.storeinfo',$user->id)}}" 
    enctype="multipart/form-data">
    {{csrf_field()}}
    
  <fieldset>

  <!-- Form Name -->
  
<div class="box-body">
   <!-- skills -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="skills">Skills</label>
    <div class="col-md-4">
    <input id="skills" name="skills" type="text" onchange="update();"  class="form-control input-md" value="{{$user->skills}}"> 
    </div>
  </div>
  <!-- about-->
  <div class="form-group">
    <label class="col-md-2 control-label" for="about">About</label>
    <div class="col-md-4">
    <input id="about" name="about" type="text"  onchange="update();" class="form-control input-md"  value="{{$user->about}}">
    </div>
  </div>
  <!-- location -->
   <div class="form-group">
    <label class="col-md-2 control-label" for="location">Location</label>
    <div class="col-md-4">
    <input id="location" name="location" type="text" onchange="update();" class="form-control input-md"  value="{{$user->location}}">
    </div>
  </div>
 <div class="form-group">
    <label class="col-md-2 control-label" for="phone">phone</label>
    <div class="col-md-4">
       
    <input id="phone" name="phone" type="tel" onchange="update();" placeholder="phone" class="form-control input-md" value="{{$user->phone}}">
    <span class="help-block">telephone number(optinal)</span>
    </div>
  </div>

<div class="form-group">
    <label class="col-md-2 control-label" for="facebook">facebook</label>
    <div class="col-md-4">
       
    <input id="facebook" name="facebook" type="facebook" onchange="update();" placeholder="facebook" class="form-control input-md" value="{{$user->facebook}}">
    <span class="help-block">Facebook account(optinal)</span>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-2 control-label" for="skype">skype</label>
    <div class="col-md-4">
       
    <input id="skype" name="skype" type="skype" onchange="update();" placeholder="skype" class="form-control input-md" value="{{$user->skype}}">
    <span class="help-block">skype(optional)</span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label" for="twitter">twitter</label>
    <div class="col-md-4">
       
    <input id="twiter" name="twiter" type="twitter" onchange="update();" placeholder="twitter" class="form-control input-md" value="{{$user->twiter}}">
    <span class="help-block">twiter(optinal)</span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label" for="linkedin">linkedin</label>
    <div class="col-md-4">
       
    <input id="linkedin" name="linkedin" type="linkedin" onchange="update();" placeholder="linkedin" class="form-control input-md" value="{{$user->linkedin}}">
    <span class="help-block">linkedin (optinal)</span>
    </div>
  </div>

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-2 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="submit" disabled="true" class="btn btn-primary">update</button>
    </div>
  </div>
  </div>

  </fieldset>
  
  </form>
</div>

  </section>

  <script>
    
    
    function update () {
  $('#submit').prop('disabled', false);
}
  </script>
  @endsection