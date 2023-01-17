
<?php
/* Default values */
$_PAGE_TITLE='Task';
$_PAGE_SUB_TITLE='';
?>
@extends('layout.gui')
@section('content')

<div class="container-fluid" >
<!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
			  <!-- Add task picture later -->
                <img class="img-circle" src="{{ asset($task->user->getAttachment()) }}" alt="User Image">
                <span class="username">
                <a href="{{route('project.show',$task->project->id)}}">{{ $task->project->title }}</a></span>
                <span class="content">
                @if($task->created_at)
                 <i class="fa fa-user" aria-hidden="true"></i>{{ $task->user->full_name }}  <i class="fa fa-calendar" aria-hidden="true"></i>{{ $task->created_at->diffForHumans() }}
                @else
                <i></i>
                @endif
                <span class="pull-right">
                 <span ><i class="fa fa-clock-o"></i> Deadline: {{$task->deadline}}</span>
                 <span ><i class=" {{$task->priority == 'Low'? 'fa fa-circle-o text-green' : ''}}
                 {{$task->priority == 'Normal'? 'fa fa-circle-o text-yellow' : ''}}
                 {{$task->priority == 'High'? 'fa fa-circle-o text-red' : ''}}"></i> Priority :{{$task->priority}}</span>
                </span>
                </span>
              </div>
              <!-- /.user-block -->


            </div>
            <!-- /.box-header -->
            <div id="content" class="box-body">
              <!-- post text -->
				{!!$task->content!!}
 </div>
 <div class="box-footer">
  @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $task->user_id || Auth::user()->id == $task->user->id )

               <a href="{{ route('task.edit',$task->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                <a href="{{ route('task.delete',$task->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>

                 @endif
               <a href="{{ route('task.discuss',$task->id) }}" class="btn btn-xs btn-success"> <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-comment" aria-hidden="true"></i></a>
                <a href="{{ route('todo.create',$task->id) }}" class="btn btn-xs btn-primary"> <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-list-alt" aria-hidden="true"></i></a>

                <a href="{{route('todo.index',$task->id)}}"><span class="badge pull-right"><small> {{$task->todo->count()}} TODO{{$task->todo->count() > 1 ? 's' : ''}} <i class="fa fa-check-square" aria-hidden="true"></i></small></span></a>
      <a href="{{route('discussion.list',['task',$task->id])}}"><span class="badge pull-right"><small> {{count($task->discussions)}} Discussion{{count($task->discussions) > 1 ? 's' : ''}} <i class="fa fa-commenting-o" aria-hidden="true"></i></small></span></a>
 </div>
</div>
 <hr>
<div class="row">

            <div class="col-md-6">
  <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Discussion</h3>

              </div>
              <!-- /.box-header -->
              <div class="box-body">

            @if(count($discussions) != 0)

               @foreach($discussions as $discussion)
               <ul class="products-list product-list-in-box">
                <li class="item">
                  <div class="product-img">
                    <img class="img-circle" src="{{asset($discussion->user->getAttachment())}}" alt="Product Image">
                  </div>
                  
                  <div class="product-info">
                    <a href="{{route('discussion.show',$discussion->id)}}" class="product-title">{{$discussion->title}}
                      <span class="label label-warning pull-right"></span></a>
                    <span class="product-description">
                           Created By : {{$discussion->user->full_name}} <span class="pull-right">{{count($discussion->discussionComments)}} Comments </span>
                        </span>
                  </div>
                </li>
                  </ul>
                @endforeach
                @else <center><h2> No Discussions yet </h2></center>
                @endif
            </div>
            </div>
            </div>
            <!-- /.box-body -->


            <div class="col-md-6">
  <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">TODOs</h3>

              </div>
              <!-- /.box-header -->
              <div class="box-body">

    @if(count($task->todo) != 0)

               @foreach($task->todo as $todo)
                 <ul class="products-list product-list-in-box">
                <li class="item">
                  <div class="product-img">
                    <img class="img-circle" src="{{asset($todo->user->getAttachment())}}" alt="Product Image">
                  </div>
                  <div class="product-info">
                    <a href="{{route('todo.show',$todo->id)}}" class="product-title">

					 <?php $todo_sum=strip_tags(html_entity_decode($todo->description));

                        if (strlen($todo_sum)>20){
                            $todo_sum=substr($todo_sum,0,20).'...';
                        }
                        echo $todo_sum;

                      ?>

                      </a>

                  @if ($todo->status == 'NOT_STARTED')
                    <span class="label label-danger pull-right"><i class="fa fa-ban" aria-hidden="true"></i> {{$todo->status}}</span>
                  @elseif ($todo->status == 'ONGOING')
                    <span class="label label-success pull-right"><i class="fa fa-spinner" aria-hidden="true"></i> {{$todo->status}}</span>
                   @elseif ($todo->status == 'POSTPONED')
                    <span class="label label-warning pull-right"><i class="fa fa-pause" aria-hidden="true"></i> {{$todo->status}}</span>
                   @elseif ($todo->status == 'DONE')
                    <span class="label label-success pull-right"><i class="fa fa-check" aria-hidden="true"></i> {{$todo->status}}</span>

                  @endif
                    <span class="product-description">
                        <span > <small> <i class="fa fa-user" aria-hidden="true"></i> {{$todo->user->full_name}}</small></span>
                        <span > |<small> <i class="fa fa-calendar" aria-hidden="true"></i>{{$todo->created_at->toFormattedDateString()}} </small></span>
						<span class="pull-right badge">{{$todo->discussion->count()}} <i class="fa fa-comment" aria-hidden="true"></i></span>
                        </span>
                  </div>
                </li>
                </ul>
                @endforeach
                @else <center><h2> No TODOs yet </h2></center>
                @endif

            </div>
            </div>
            </div>
            <!-- /.box-body -->


    </div>

            </div>













@endsection
