<?php
$_PAGE_TITLE='announcement: "'.$announcement->title.'"';
$_PAGE_SUB_TITLE='';
?>
@extends('layout.gui')
@section('content')

<div class="container-fluid" >
<!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
			  <!-- Add announcement picture later -->
                <img class="img-circle" src="{{ asset($announcement->user->getAttachment()) }}" alt="User Image"/>
                <span class="username"><a href="#">{{$announcement->title}}</a></span>
                <span class="description">
                @if($announcement->created_at)
               <span ><i class="fa fa-user" aria-hidden="true"></i> {{ $announcement->user->full_name }}</span>
				<span ><i class="fa fa-calendar" aria-hidden="true"></i> {{ $announcement->created_at->diffForHumans() }}</span>
                @else
                <i></i>
                @endif
                </span>
              </div>
              <!-- /.user-block -->

            <!-- /.box-header -->
            <div id="description" class="announcement-description">
              <!-- post text -->
               	@if($announcement->attachment)
				<div class="announcement-description-img">
                 <img src="{{asset($announcement->getAttachment())}}" alt="Attachment Image">
				 </div>
                @endif

				{!!$announcement->content!!}

                <!-- /.attachment-pushed -->
              </div>
              </div>
			  <div class="box-footer">

                @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $announcement->user_id)
                
        <a href="{{ route('announcement.edit',$announcement->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
        
                <a href="{{ route('announcement.delete',$announcement->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                 @endif
			  <a href="{{ route('announcement.discuss',$announcement->id) }}" class="btn btn-xs btn-success"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-comment" aria-hidden="true"></i></a>


                <small class="pull-right">                
                 
                  <a href=@if($announcement->discussions) "{{route('discussion.list',['announcement',$announcement->id])}}"@endif > 
                  <span class="badge">{{count($announcement->discussions)}} 
                  Discussion{{count($announcement->discussions)>1?"s":""}} <i class="fa fa-commenting-o" aria-hidden="true"></i>
                  </span>
                  </a>
              </small>
            
			  </div>

			                 <!-- /.attachment-block -->

              <!-- Social sharing buttons -->

            </div>



          </div>

		   @if(count($discussions) != 0)
		  <div class="col-md-12">
 <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Discussions</h3>

            </div>

	<div class="box-body">

            <!-- /.box-body -->
            @foreach($discussions as $discussion)
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="{{asset($discussion->user->getAttachment())}}" alt="User Image">
                <span class="username"><a href="{{route('discussion.show',$discussion->id)}}"> {{$discussion->title}}</a></span>
                <span class="description"><i class="fa fa-user" aria-hidden="true"></i>{{$discussion->user->user_name}} <i class="fa fa-calendar" aria-hidden="true"></i>{{$discussion->created_at->diffForHumans()}} </span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
               @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $discussion->user_id )
               <a href="{{ route('discussion.edit',$discussion->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <a href="{{ route('discussion.delete',$discussion->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                @endif


           </div>
             <b>
                  <a class="pull-right badge" href="{{route('discussion.show',$discussion->id)}}"> 
                  {{App\DiscussionComment::all()->where('discussion_id',$discussion->id)->count()}} 
                  comment{{App\DiscussionComment::all()->where('discussion_id',$discussion->id)->count()>1?"s":""}}
                  </a>
                  </b>
            </div>

          </div>
          </div>
@endforeach
@endif

            </div>






@endsection
