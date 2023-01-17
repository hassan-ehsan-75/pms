
<?php
/* Default values */
$_PAGE_TITLE='task List';
$_PAGE_SUB_TITLE='all tasks';
?>
@extends('layout.gui')

@section('content')

 <div class="container-fluid">

@if($tasks->count() != 0)

@foreach ($tasks as $task)

			<div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="{{asset($task->user->getAttachment())}}" alt="User Image"/>
                <span class="username">

					{{$task->user->full_name}}

				</span>
                <span class="content">


			<span > <i class="fa fa-tasks" aria-hidden="true"></i> {{$task->project->title}}</span>
			<span > <i class="fa fa-calendar" aria-hidden="true"></i> {{$task->created_at->diffForHumans()}} </span>

             </span>
              </div>
              <!-- /.user-block -->

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!--image -->
              <?php
      			  $striped=strip_tags($task->content);
      			  echo strlen($striped)>200?substr($striped,0,200).'...':$striped.'<a  href='.route('task.show',$task->id).'> Show more...  </a>';
      			  ?>

            </div>

			  <div class="box-footer">

			 	 @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $task->user_id || Auth::user()->id == $task->user->id)

               <a href="{{ route('task.edit',$task->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
              
                <a href="{{ route('task.delete',$task->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>

                 @endif
			  <a href="{{route('todo.index',$task->id)}}" class="badge pull-right"><span ><small> {{$task->todo->count()}} TODO{{$task->todo->count() > 1 ? 's' : ''}} <i class="fa fa-check-square" aria-hidden="true"></i></small></span></a>

		  <a href="{{route('discussion.list',['task',$task->id])}}" class="badge pull-right"><span ><small> {{count($task->discussions)}} Discussion{{count($task->discussions) > 1 ? 's' : ''}} <i class="fa fa-commenting-o" aria-hidden="true"></i></small></span></a>

			 </div>
            </div>



			@endforeach
	@else <center><h4>No Tasks yet</h4></center>
@endif

</div>
@endsection
