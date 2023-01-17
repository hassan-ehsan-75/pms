<?php
/* Default values */
$_PAGE_TITLE='News List';
$_PAGE_SUB_TITLE='All News';
?>
@extends('layout.gui')
@section('content')
	{{-- expr --}}

@if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger')
 <hr>
  <a href="{{route('news.create')}}" class="btn btn-success"> Create News <i class="fa fa-newspaper-o" aria-hidden="true"></i></a>
  @endif
 <hr>
@if(count($newss) != 0)
 <div class="row">
@foreach($newss as $news)
<div class="col-md-6">
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="{{asset($news->user->getAttachment())}}" alt="User Image">
                <span class="username"><a href="{{route('news.show',$news->id)}}"> {{$news->title}}</a><small><a href="{{route('news.show',$news->id)}}"
                ></a></small>


                  @if ($news->status == 'DRAFT')
                    <span class="label label-success pull-right"><i class="fa fa-spinner" aria-hidden="true"></i> DRAFT</span>

                   @elseif ($news->status == 'PUBLISHED')
                    <span class="label label-primary pull-right"><i class="fa fa-newspaper-o" aria-hidden="true"></i> PUBLISHED</span>


                  @endif
                </span>
                <span class="description"><i class="fa fa-user" aria-hidden="true"></i> {{$news->user->full_name}} <i class="fa fa-calendar" aria-hidden="true"></i>{{$news->created_at->diffForHumans()}}</span>
              </div>
              <!-- /.user-block -->

            </div>
            <div class="box-body description-wrapper">

				@if($news->attachment)
                 <img class="description-img" src="{{asset($news->getAttachment())}}" alt="Attachment Image">
                @endif
              <!-- post text -->
			  <?php
			  $striped=strip_tags($news->content);
			  echo strlen($striped)>200?substr($striped,0,200).'...':$striped;
			  ?>


              </div>
              <div class="box-footer">
                @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $news->user_id)
               @if(Auth::user()->id == $news->user->id)
               <a href="{{ route('news.edit',$news->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
               @endif
                <a href="{{ route('news.delete',$news->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                @endif
                <a href="{{ route('news.discuss',$news->id) }}" class="btn btn-xs btn-success"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-comment" aria-hidden="true"></i></a>


							<small class="pull-right">
								<a href=@if($news->discussions)"{{route('discussion.list',['news',$news->id])}}"@endif>
								<span class="badge">{{count($news->discussions)}}
								Discussion{{count($news->discussions)>1?"s":""}} <i class="fa fa-commenting-o" aria-hidden="true"></i>
									</span>
									</a>
								</small>
							</div>

          </div>
   </div>

@endforeach
{{$newss->links()}}
</div>
@else <center><h4>No News yet</h4></center>
@endif

@endsection
