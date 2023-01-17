<?php
/* Default values */
$_PAGE_TITLE= $job->title;
$_PAGE_SUB_TITLE='';
?>
@extends('layout.gui')
@section('content')
	<div class="container-fluid">
<!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
               <img class="img-circle" src="{{asset($job->user->getAttachment())}}" alt="User Image">

                 <span class="username">{{$job->title}}</a></span>
                <span class="description"><i class="fa fa-user" aria-hidden="true"></i> {{$job->user->full_name}}  <i class="fa fa-calendar" aria-hidden="true"></i>{{$job->updated_at->toFormattedDateString()}}
                    @if ($job->status == 'DRAFT')
            <span class="label label-primary"><i class="fa fa-newspaper-o" aria-hidden="true"></i> DRAFT</span>
          @elseif ($job->status == 'PUBLISHED')
            <small class="label label-primary"><i class="fa fa-newspaper-o" aria-hidden="true"></i> {{$job->status}}</small>

                </span>

          
          @endif

            </div>
              </div>
              <!-- /.user-block -->


            <!-- /.box-header -->
            <div class="box-body">

			 <!-- /.box-header -->
            <div  class="description-wrapper">
              <!-- post text -->
               	@if($job->attachment)
                 <img class="description-img" src="{{asset($job->getAttachment())}}" alt="Attachment Image">
                @endif

			{!!$job->content!!}

                <!-- /.attachment-pushed -->
              </div>





        </div>
        <div class="box-footer">


               <a href="{{ route('job.delete',$job->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>

               <a href="{{ route('job.edit',$job->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

               <a href="{{ route('job.discuss',$job->id) }}" class="btn btn-xs btn-success"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-comment" aria-hidden="true"></i></a>

                <small class="pull-right">
              <a href="{{count($job->discussions)>0?route('discussion.list',['job',$job->id]):'#'}}" >
              <span class="badge">{{count($job->discussions)}} Discussion{{count($job->discussions) > 1? 's':''}}
                 <i class="fa fa-commenting"  aria-hidden="true"></i>
                </span> 
                    </a>
                    </small>
      
      </div>
      </div>


      <div class="col-md-12">
 <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Discussions</h3>

            </div>

  <div class="box-body">
 <div class="box box-widget">
            <div class="box-header with-border">
       @if(count($discussions) != 0)
     
            <!-- /.box-body -->
            @foreach($discussions as $discussion)
         
              <div class="user-block">
                <img class="img-circle" src="{{asset($discussion->user->getAttachment())}}" alt="User Image">
                <span class="username"><a href="{{route('discussion.show',$discussion->id)}}"> {{$discussion->title}}</a></span>
                <span class="description"> <i class="fa fa-user" aria-hidden="true"></i> {{$discussion->user->full_name}} <i class="fa fa-calendar" aria-hidden="true"> </i>{{$discussion->created_at->diffForHumans()}} </span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
               @if(Auth::user()->getPermission() == 'admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $discussion->user_id )
               @if(Auth::user()->id == $discussion->id)
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

         </div>
				 @endforeach
				     @else <center><h2>No Discussions yet</h2></center>

@endif
         </div>


          </div>
				</div>
    




@endsection
