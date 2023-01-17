
<?php
/* Default values */
$_PAGE_TITLE= 'Profile';
$_PAGE_SUB_TITLE='';
?>
@extends('layout.gui')
@section('content')
 
 <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{asset($user->getAttachment())}}" alt="User profile picture">

              <h3 class="profile-username text-center">{{$user->full_name}}</h3>

              <p class="text-muted text-center">{{$user->userTitle->title->title_name}}</br>
              @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger')
            <a href="{{route('user.edit',$user->id)}}" class="text-muted text-center btn btn-xs btn-warning" >edit<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></p>
            @endif
              <ul class="list-group list-group-unbordered">

                <li class="list-group-item">
                  <b>Joined At</b> <p class="pull-right">@if ($user->created_at)
            {{$user->created_at->toFormattedDateString()}}
          @else

          {{print 'Unknown'}}</p>
          @endif
          </li>
          <li class="list-group-item">
                  <b>Created By</b> <p class="pull-right">{{$user->creator->full_name}}</p>
                </li>
              
                
              </ul>

              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me
              @if(Auth::user()->id == $user->id || Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger')
               <a href="{{route('user.addinfo',$user->id)}}" class=" btn btn-xs btn-primary" >Update<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></h3>
               @endif
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              

              <p class="text-muted">
             @if($user->about)  {{$user->about}} @else No info @endif
              </p>

              @if($user->location)
              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">{{$user->location}}</p>
              @endif

              @if($user->skills)
              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
              {{$user->skills}}
                <!-- <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span> -->
              </p>
              @endif
              @if($user->phone || $user->facebook || $user->twiter || $user->skype || $user->linkedin)
               <hr>

              <strong><i class="fa fa- fa-user margin-r-5"></i> Contact info </strong>

              <p class="text-muted">Phone: {{$user->phone}}</p>
              <p class="text-muted">Facebook: {{$user->facebook}}</p>
              <p class="text-muted">Twitter: {{$user->twiter}}</p>
              <p class="text-muted">Skype: {{$user->skype}}</p>
              <p class="text-muted">linkedin: {{$user->linkedin}}</p>
              @endif
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Discussions</a></li>
             <!--  <li><a href="#timeline" data-toggle="tab">Timeline</a></li> -->
              <li><a href="#settings" data-toggle="tab">Settings</a></li> 
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
              <ul class="timeline timeline-inverse">

             <?php $temp2 = date_format(new DateTime('2014-03-18'),'Y-m-d') ?>
                @foreach($discussions as $discussion)
    
                @if(date_format(new DateTime($discussion->created_at),'Y-m-d') != $temp2 )
                 <li class="time-label">
                        <span class="bg-red">
                          {{$discussion->created_at->toFormattedDateString()}}
                        </span>
                  </li>
                  <?php $temp2 = date_format(new DateTime($discussion->created_at),'Y-m-d'); ?>
                  @endif


          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="{{asset($discussion->user->getAttachment())}}" alt="User Image">

                <span class="username">
                  @if ($discussion->type == 'task')
                     <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                     @elseif ($discussion->type == 'project')
                     <i class="fa fa-tasks" aria-hidden="true"></i>
                     @elseif ($discussion->type == 'todo')
                     <i class="fa fa-check-square" aria-hidden="true"></i>
                     @elseif ($discussion->type == 'news')
                     <i class="fa fa fa-newspaper-o" aria-hidden="true"></i>
                      @elseif ($discussion->type == 'job')
                     <i class="fa fa fa-briefcase" aria-hidden="true"></i>
                      @elseif ($discussion->type == 'announcement')
                     <i class="fa fa fa-bullhorn" aria-hidden="true"></i>
                     @endif
                <a href="{{route('discussion.show',$discussion->id)}}">
                 {{$discussion->title}}</a><small>
                 @if($discussion->project && $discussion->type == 'project')
                 <a href="{{route('project.show',$discussion->project->id)}}">
                 ({{$discussion->project->title}})
                 @endif
                 </a></small></span>
                <span class="description">{{$discussion->created_at}}</span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
              @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $discussion->user_id )
              @if( Auth::user()->id == $discussion->user_id)
               <a href="{{ route('discussion.edit',$discussion->id) }}" class="btn btn-xs btn-warning">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
               @endif
               <a href="{{ route('discussion.delete',$discussion->id) }}" class="btn btn-xs btn-danger">Delete <i class="fa fa-trash" aria-hidden="true"></i></a>
               
                @endif
           </div>
             <b>  
             
             <?php 
               $comments_count = App\DiscussionComment::all()->where('discussion_id',$discussion->id)->count();
               echo  $comments_count.' Comments';
              ?><a href="{{route('discussion.show',$discussion->id)}}"> view all</a></b>
            </div>
    
          </div>
@endforeach
</ul>
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
         @if (Auth::user()->id == $user->id)
       
        <form  class="form-horizontal" action="{{ route('change_pic',$user->id) }}" method="post" 
          enctype="multipart/form-data">
          {{csrf_field()}}
      <input  class="btn" type="file" name="profile_image">
        <button class="btn change_pic pull-right" type="submit">Sava picture</button>
        </form>
        </br>
        </br>
        </br>
        @endif
                  <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form "form-horizontal" action="{{ route('user.changePassword',$user->id) }}" method="post">
            {{ csrf_field() }}
              <div class="box-body password">
                <div class="form-group">
                  <label for="passwrod">Old password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Old Password" onblur="validatePassword(this);" onkeydown="validatePassword(this);" >
                  <span class="help-block passwordspan"></span>
                </div>
                <div class="form-group new_password">
                  <label for="new_password"> New Password</label>
                  <input type="password" class="form-control" id="new_password" name="new_password" placeholder="new_password" onblur="validatePasswordNew(this);" onkeydown="validatePasswordNew(this);" >
                  <span class="help-block new_passwordspan"></span>
                </div>
                 <div class="form-group comfirm_password">
                  <label for="comfirm_password">Comfirm Password</label>
                  <input type="password" class="form-control" id="comfirm_password" name="comfirm_password" placeholder="comfirm_password" onblur="validatePasswordComfirm(this);" onkeydown="validatePasswordComfirm(this);" >
                  <span class="help-block comfirm_passwordspan"></span>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button id="submit" type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
         
                
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
 <script>
    
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
     function validatePasswordNew(){
      if ($('#new_password').val().length < 8 ) {
         $('.new_password').addClass('has-error');
         $('.new_passwordspan').html('the password is less thas 8 characters');
         $('#submit').prop('disabled', true);
      }else{
               $('.new_password').removeClass('has-error');
         $('.new_passwordspan').html('Assign Password to the new user');
         $('#submit').prop('disabled', false);
      }
     }
     function validatePasswordComfirm(){
      if ($('#comfirm_password').val().length < 8 ) {
         $('.comfirm_password').addClass('has-error');
         $('.comfirm_passwordspan').html('the password is less thas 8 characters');
         $('#submit').prop('disabled', true);
      }else if($('#comfirm_password').val() != $('#new_password').val()){
        $('.comfirm_password').addClass('has-error');
         $('.comfirm_passwordspan').html('the password NOt match');
         $('#submit').prop('disabled', true);
      }

      else{
               $('.comfirm_password').removeClass('has-error');
         $('.comfirm_passwordspan').html('Assign Password to the new user');
         $('#submit').prop('disabled', false);
      }
     }
  </script>
@endsection
