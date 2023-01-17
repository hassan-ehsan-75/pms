<?php
/* Default values */
$_PAGE_TITLE= $news->title;
$_PAGE_SUB_TITLE='';
?>
@extends('layout.gui')
@section('content')
	<div class="container-fluid">
<!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
               <img class="img-circle" src="{{asset($news->user->getAttachment())}}" alt="User Image">

                 <span class="username"><a href="{{ route('user.profile',$news->user->user_id) }}">{{$news->user->full_name}}</a>

						      @if ($news->status == 'DRAFT')
									       <span class="label label-success pull-right"><i class="fa fa-spinner" aria-hidden="true"></i> DRAFT</span>

									      @elseif ($news->status == 'PUBLISHED')
									    <span class="label label-primary pull-right"><i class="fa fa-newspaper-o" aria-hidden="true"></i> PUBLISHED</span>
											@endif
								 </span>
                <span class="description"><i class="fa fa-calendar" aria-hidden="true"></i> {{$news->updated_at->toFormattedDateString()}}</span>

            </div>
              </div>
              <!-- /.user-block -->


            <!-- /.box-header -->
            <div class="box-body">

			 <!-- /.box-header -->
            <div  class="description-wrapper">
              <!-- post text -->
               	@if($news->attachment)
                 <img class="description-img" src="{{asset($news->getAttachment())}}" alt="Attachment Image">
                @endif

			{!!$news->content!!}

                <!-- /.attachment-pushed -->
              </div>





        </div>
        <div class="box-footer">


               <a href="{{ route('news.delete',$news->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>

               <a href="{{ route('news.edit',$news->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

               <a href="{{ route('news.discuss',$news->id) }}" class="btn btn-xs btn-success"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-comment" aria-hidden="true"></i></a>

                <small class="pull-right">

                  <a href=@if($news->discussions) "{{route('discussion.list',['news',$news->id])}}"@endif >
                  <span class="badge">{{count($news->discussions)}}
                  Discussion{{count($news->discussions)>1?"s":""}} <i class="fa fa-commenting-o" aria-hidden="true"></i>
                  </span>
                  </a>
              </small>


        </div>
        <!-- /.col -->
          </div>
      </div>

          <div class="col-md-12">
 <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Discussions</h3>

            </div>

  <div class="box-body">
       @if(count($discussions) != 0)


            <!-- /.box-body -->
            @foreach($discussions as $discussion)
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="{{asset($discussion->user->getAttachment())}}" alt="User Image">
                <span class="username"><a href="{{route('discussion.show',$discussion->id)}}"> {{$discussion->title}}</a><small></small></span>
                <span class="description"><i class="fa fa-user" aria-hidden="true"></i>{{$discussion->user->full_name}} <i class="fa fa-calendar" aria-hidden="true"></i>{{$discussion->created_at->diffForHumans()}} </span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
               @if(Auth::user()->getPermission() == 'admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $discussion->user_id || Auth::user()->id == $discussion->user_id)

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
            <!-- /.box-header -->

              <!-- post text -->




              <!-- Attachment -->

              <!-- Social sharing buttons -->


            <!-- /.box-body -->
         </div>
         @endforeach
         @else <center><h2>No Discussions yet</h2></center>
         @endif
         </div>


          </div>
          </div>






@endsection
