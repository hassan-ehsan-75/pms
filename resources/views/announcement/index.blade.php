<?php
/* Default values */
$_PAGE_TITLE='Announsements List';
$_PAGE_SUB_TITLE='all Announsement';
?>
@extends('layout.gui')
@section('content')
<div class="container-fluid">
@if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger')
 <hr>
  <a href="{{route('announcement.create')}}" class="btn btn-success"> New announcement <i class="fa  fa-bullhorn" aria-hidden="true"></i></a>
  @endif
 <hr>

@if($announcements->count() != 0)
@foreach ($announcements as $announcement)

			<div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="{{asset($announcement->user->getAttachment())}}" alt="User Image">
                <span class="username"><a href="{{route('announcement.show',$announcement->id)}}">{{$announcement->title}} </a></span>
                <span class="description"><i class="fa fa-user" aria-hidden="true"></i> {{$announcement->getCreator()}}  <i class="fa fa-calendar" aria-hidden="true"></i>{{$announcement->created_at->diffForHumans()}}</span>
              </div>
              <!-- /.user-block -->

              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!--image -->
              <?php
              $striped=strip_tags($announcement->content);
              echo strlen($striped)>200?substr($striped,0,200).'...':$striped;
              ?>

            </div>
            <div class="box-footer">
               @if(Auth::user()->userPermission->permission->permission_name == 'Admin' || Auth::user()->userPermission->permission->permission_name == 'Manger' || Auth::user()->id == $announcement->user_id)
               
               <a href="{{ route('announcement.edit',$announcement->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
               
                <a href="{{ route('announcement.delete',$announcement->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                @endif
                <a href="{{ route('announcement.discuss',$announcement->id) }}" class="btn btn-xs btn-success"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-comment" aria-hidden="true"></i></a>

							<small class="pull-right">
						<a href=@if($announcement->discussions)"{{route('discussion.list',['announcement',$announcement->id])}}"@endif>
					  <span class="badge">{{count($announcement->discussions)}}
								Discussion{{count($announcement->discussions)>1?"s":""}} <i class="fa fa-commenting-o" aria-hidden="true"></i>
							</span>
									</a>
								</small>
            </div>
            </div>

			@endforeach
      {{$announcements->links()}}
	@else <center><h4>No Announcements yet</h4></center>
@endif

</div>
@endsection
