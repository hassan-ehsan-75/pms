<?php
/* Default values */
$_PAGE_TITLE='Jobs List';
$_PAGE_SUB_TITLE='All Jobs';
?>
@extends('layout.gui')
@section('content')
	{{-- expr --}}

@if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger')
 <hr>
  <a href="{{route('job.create')}}" class="btn btn-success"> Create Job <i class="fa fa-briefcase" aria-hidden="true"></i></a>
  @endif
 <hr>
@if($jobs->count() != 0)
 <div class="row">
@foreach($jobs as $job)
<div class="col-md-6">
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="{{asset($job->user->getAttachment())}}" alt="User Image">
                <span class="username"><a href="{{route('job.show',$job->id)}}"> {{$job->title}}</a><small><a href="{{route('job.show',$job->id)}}"
                ></a></small>
                </span>
                <span class="description">
									<small><i class="fa fa-user" aria-hidden="true"></i> {{$job->user->full_name}}  </small>
									<small ><i class="fa fa-calendar" aria-hidden="true"></i>{{$job->created_at->diffForHumans()}}  </small>
                  @if ($job->status == 'DRAFT')
             <span class="label label-primary"><i class="fa fa-newspaper-o" aria-hidden="true"></i> DRAFT</span>
          @elseif ($job->status == 'PUBLISHED')
            <small class="label label-primary"><i class="fa fa-newspaper-o" aria-hidden="true"></i> {{$job->status}}</small>
          
          @endif
								</span>
              </div>
              <!-- /.user-block -->

            </div>
            <div class="box-body description-wrapper">

				@if($job->attachment)
                 <img class="description-img" src="{{asset($job->getAttachment())}}" alt="Attachment Image">
                @endif
              <!-- post text -->
			  <?php
			  $striped=strip_tags($job->content);
			  echo strlen($striped)>200?substr($striped,0,200).'...':$striped;
			  ?>


              </div>
              <div class="box-footer">
                @if(Auth::user()->getPermission() == 'admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $job->user_id)
               @if(Auth::user()->id == $job->user->id)
               <a href="{{ route('job.edit',$job->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
               @endif
                <a href="{{ route('job.delete',$job->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                @endif
								  <a href="{{ route('job.discuss',$job->id) }}" class="btn btn-xs btn-success"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-comment" aria-hidden="true"></i></a>

								<small class="pull-right">
							<a href=@if($job->discussions)"{{route('discussion.list',['job',$job->id])}}"@endif>
						  <span class="badge">{{count($job->discussions)}}
									Discussion{{count($job->discussions)>1?"s":""}} <i class="fa fa-commenting-o" aria-hidden="true"></i>
								</span>
										</a> 
									</small>
              </div>

          </div>
   </div>

@endforeach
{{$jobs->links()}}
</div>
@else <center><h4>No Jobs yet</h4></center>
@endif

@endsection
