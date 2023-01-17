<?php
/* default values */
$_PAGE_TITLE='Search results';
$_PAGE_SUB_TITLE='results';
?>
@extends('layout.gui')
@section('content')
<h1>Search results for : {{$search_query}} <b></b></h1>

@if (count($useres)>0)
	<div class="panel panel-success">
		<div class="panel-heading">
			<p class="text-info">Search Result for Users:</p>
		</div>

		<div class="panel-body">

		@foreach ($useres as $user)
		<h4>
		<a href="{{ route('user.profile',$user->id) }}">{{$user->user_name}}</a>
		</h4>
		<hr>
		@endforeach

		</div>
	</div>
@endif

@if (count($projects)>0)
	<div class="panel panel-success">
		<div class="panel-heading">
			<p class="text-info">Search Results For Projects:</p>
		</div>

		<div class="panel-body">

		@foreach ($projects as $project)
			<a href="{{ route('project.show',$project->id) }}">{{$project->title}}</a>
			<hr>
		@endforeach

		</div>
	</div>
@endif

@if (count($discussions)>0)
	<div class="panel panel-success">
		<div class="panel-heading">
			<p class="text-info">Search Results For discussions:</p>
		</div>

		<div class="panel-body">

		@foreach ($discussions as $discussion)
			<a href="{{ route('discussion.show',$discussion->id) }}">
				{{$discussion->title}}</a>
				<hr>
		@endforeach

		</div>
	</div>
@endif

@if (count($news)>0)
	<div class="panel panel-success">
		<div class="panel-heading">
			<p class="text-info">Search Results For news:</p>
		</div>

		<div class="panel-body">

		@foreach ($news as $new)
		<h4>
			<a href="{{ route('news.show',$new->id) }}">{{$new->title}}</a>
		</h4>
		<hr>
		@endforeach

		</div>
	</div>
@endif

@if (count($tasks)>0)
	<div class="panel panel-success">
		<div class="panel-heading">
			<p class="text-info">Search Results For Tasks:</p>
		</div>

		<div class="panel-body">

		@foreach ($tasks as $task)
			<a href="{{ route('task.show',$task->id) }}">
			<?php $task_sum=strip_tags(html_entity_decode($task->content));
                        if (strlen($task_sum)>20){
                            $todo_sum=substr($task_sum,0,20).'...';
                        }
                        echo $todo_sum;

                        ?></a>
			<hr>
		@endforeach

		</div>
	</div>
@endif


@if (count($todos)>0)
	<div class="panel panel-success">
		<div class="panel-heading">
			<p class="text-info">Search Result for todos:</p>
		</div>

		<div class="panel-body">

		@foreach ($todos as $todo)
		<h4>
		<a href="{{ route('todo.show',$todo->id) }}">
			 <?php $todo_sum=strip_tags(html_entity_decode($todo->description));
                        if (strlen($todo_sum)>30){
                            $todo_sum=substr($todo_sum,0,30).'...';
                        }
                        echo $todo_sum;

                        ?>
		</a>	<hr>
		</h4>
		@endforeach

		</div>
	</div>
@endif

@endsection
