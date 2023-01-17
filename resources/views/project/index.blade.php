
<?php
/* Default values */
$_PAGE_TITLE='Project List';
$_PAGE_SUB_TITLE='all projects';
?>
@extends('layout.gui')

@section('content')

	@if(Auth::user()->userPermission->permission->permission_name == 'Admin' || Auth::user()->userPermission->permission->permission_name == 'Manger')
 <hr>
  <a href="{{route('project.create')}}" class="btn btn-success"> New Project <i class="fa fa-edit" aria-hidden="true"></i></a>
 @endif
 <hr>
<div class="row">
@if(count($projects)>0)
@foreach ($projects as $project)
<div class="col-md-4">
	<div class="box box-widget">
        <div class="box-header with-border">
            <div class="user-block">
                <img class="img-circle" src="{{asset($project->getAttachment())}}" alt="User Image">
                <span class="username">
					<a href="{{route('project.show',$project->id)}}">{{$project->title}} </a>
				</span>
                <span class="description"> 
                <div class="row">
					<small><i class="fa fa-user" aria-hidden="true"></i> {{$project->user->full_name}}  </small>
					<small ><i class="fa fa-calendar" aria-hidden="true"></i>{{$project->created_at->diffForHumans()}}  </small> 
					</div>
					@if ($project->status == 'NOT_STARTED')
						<small class="label label-danger"><i class="fa fa-ban" aria-hidden="true"></i> {{$project->status}}</small>
					@elseif ($project->status == 'ONGOING')
						<small class="label label-success"><i class="fa fa-spinner" aria-hidden="true"></i> {{$project->status}}</small>
					@elseif ($project->status == 'POSTPONED')
						<small class="label label-warning"><i class="fa fa-pause" aria-hidden="true"></i> {{$project->status}}</small>
					@elseif ($project->status == 'PUBLISHED')
						<small class="label label-primary"><i class="fa fa-newspaper-o" aria-hidden="true"></i> {{$project->status}}</small>
					@elseif ($project->status == 'DONE')
						<small class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> {{$project->status}}</small>
					@endif
				</span>
            </div>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			{{ substr(
			strip_tags($project->description),
			0,
			strlen(strip_tags($project->description))>200?200:strlen(strip_tags($project->description))
			)}}
			
			{{strlen(strip_tags($project->description))>200?"...":""}}
			</div>
			
						<div class="box-footer">
						
						<a href="{{ route('project.discuss',$project->id) }}" class="btn btn-xs btn-success"> <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-comment" aria-hidden="true"></i><span class="tooltip"> disscus project</span></a>
						
						
							@if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' )
								 <a href="{{ route('task.create',$project->id) }}" class="btn btn-xs btn-primary">  <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
								<a href="{{ route('project.edit',$project->id) }}" class="btn btn-xs btn-warning"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<a href="{{ route('project.delete',$project->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">  <i class="fa fa-trash" aria-hidden="true"></i></a>
							@endif
	
							<small class="pull-right">								
									<a href="{{ route('task.index',$project->id) }}" > 
									<span class="badge">{{count($project->tasks)}} 
									<i class="fa fa-thumb-tack" aria-hidden="true"></i>
									</span>
									</a>

									<a href=@if($project->discussions) "{{route('discussion.list',['project',$project->id])}}"@endif > 
									<span class="badge">{{count($project->discussions)}} 
									<i class="fa fa-comment" aria-hidden="true"></i>
									</span>
									</a>
							</small>
						

						

						</div>
        </div>
</div>
			@endforeach
			{{$projects->links()}}
	@else
	<center><h2>No projects yet</h2></center>
@endif


</div>

@endsection
