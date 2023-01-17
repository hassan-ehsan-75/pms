
<?php
/* Default values */
$_PAGE_TITLE='Discussions List';
$_PAGE_SUB_TITLE='all discussions';
?>
@extends('layout.gui')
@section('content')
<div class="container-fluid">
<!-- Box Comment -->
@if($discussions->count() != 0)
@foreach($discussions as $discussion)
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="{{asset($discussion->user->getAttachment())}}" alt="User Image">

                <span class="username"><a href="{{route('discussion.show',$discussion->id)}}">
                 {{$discussion->title}}</a><small>
                 @if($discussion->project && $discussion->type == 'project' )
                 <a href="{{route('project.show',$discussion->project->id)}}">
                 ({{$discussion->project->title}})
                 @endif
                 </a></small></span>
                <span class="description"><i class="fa fa-user" aria-hidden="true"></i> {{$discussion->user->full_name}} <i class="fa fa-calendar" aria-hidden="true"></i>{{$discussion->created_at->diffForHumans()}} </span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
              @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $discussion->user_id )
              @if( Auth::user()->id == $discussion->user_id)
               <a href="{{ route('discussion.edit',$discussion->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
               @endif
               <a href="{{ route('discussion.delete',$discussion->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                

                @endif
           </div>
               <small class="pull-right">                
               
                 
                  <span class="badge">{{count($discussion->discussionComments)}} 
                  Comment{{count($discussion->discussionComments)>1?"s":""}} 
                  </span>
                  </a>
              </small>
            </div>
            <!-- /.box-header -->

              <!-- post text -->




              <!-- Attachment -->

              <!-- Social sharing buttons -->


            <!-- /.box-body -->


          </div>
@endforeach

@else <center><h4>No Discussions yet</h4></center>
@endif
</div>
@endsection
