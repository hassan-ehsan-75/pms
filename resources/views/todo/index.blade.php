
<?php
/* Default values */
$_PAGE_TITLE='TODOs List';
$_PAGE_SUB_TITLE='all Todos';
?>
@extends('layout.gui')
@section('content')
<div class="container-fluid">
@if($schedueltodos->count() != 0)
@foreach($schedueltodos as $todo)
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="{{asset($todo->user->getAttachment())}}" alt="User Image">
                <span class="username"><a href="{{route('todo.show',$todo->id)}}"><?php $todo_sum=strip_tags(html_entity_decode($todo->description));
                   if (strlen($todo_sum)>30){
                       $todo_sum=substr($todo_sum,0,30).'...';
                   }
                   echo $todo_sum;

                   ?></a>
                   <span class="pull-right todo-status" >  
                     @if ($todo->status == 'NOT_STARTED')
                    <small class="label label-danger"><i class="fa fa-ban" aria-hidden="true"></i> {{$todo->status}}</small>
                  @elseif ($todo->status == 'ONGOING')
                    <small class="label label-success"><i class="fa fa-spinner" aria-hidden="true"></i> {{$todo->status}}</small>
                  @elseif ($todo->status == 'POSTPONED')
                    <small class="label label-warning"><i class="fa fa-pause" aria-hidden="true"></i> {{$todo->status}}</small>
                  @elseif ($todo->status == 'PUBLISHED')
                    <small class="label label-primary"><i class="fa fa-newspaper-o" aria-hidden="true"></i> {{$todo->status}}</small>
                  @elseif ($todo->status == 'DONE')
                    <small class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> {{$todo->status}}</small>
                  @endif
                  <input type="hidden" name="todo_id" value="{{$todo->id}}">
                  </span>
                   </span>
                <span class="description"><i class="fa fa-user" aria-hidden="true"></i>{{$todo->user->full_name}} <i class="fa fa-calendar" aria-hidden="true"></i>{{$todo->created_at->diffForHumans()}}
                
                </span>
              </div>
              <!-- /.user-block -->

              <div class="cox-footer">
                <a href="{{ route('todo.edit',$todo->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                 <a href="{{ route('todo.delete',$todo->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>

              <a class="pull-right" href=@if($todo->discussion) "{{route('discussion.list',['todo',$todo->id])}}"@endif > 
                  <span class="badge">{{count($todo->discussion)}} 
                  Discussion{{count($todo->discussion)>1?"s":""}} 
                  </span>
                  </a>
              </div>
            </div>
            <!-- /.box-header -->


          </div>
@endforeach
{{$schedueltodos->links()}}
@else   <center><h2>No TODOs yet</h2></center>
@endif
</div>
<div id="status-options" class="well">
  <option value="1" class="label label-danger">NOT_STARTED</option>
  <hr>
  <option value="2" class="label label-success">ONGOING</option>
  <hr>
  <option value="3" class="label label-warning">POSTPONED</option>
  <hr>
  <option value="4" class="label-primary">DONE</option>
</div>
<script src="{{ asset('js/todoChangeStatus.js') }}">
 
  
</script>

@endsection
