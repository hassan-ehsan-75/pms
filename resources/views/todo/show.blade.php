
<?php
/* Default values */
$_PAGE_TITLE='TODO';
$_PAGE_SUB_TITLE='';
?>
@extends('layout.gui')
@section('content')

<div class="container-fluid" >
<!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
			  <!-- Add todo picture later -->
                <img class="img-circle" src="{{ asset($todo->user->getAttachment()) }}" alt="User Image"/>
                <span class="username"><a href="#">
                  <?php $todo_sum=strip_tags(html_entity_decode($todo->description));
                   if (strlen($todo_sum)>30){
                       $todo_sum=substr($todo_sum,0,30).'...';
                   }
                   echo $todo_sum;

                   ?>
                </a></span>
                <span class="description">
                @if($todo->created_at)
                <i class="fa fa-user" aria-hidden="true"></i>{{ $todo->user->full_name }} <i class="fa fa-calendar" aria-hidden="true"></i>{{ $todo->created_at->diffForHumans() }}

                @else
                <i></i>
                @endif
                <span class="todo-status">
                @if ($todo->status == 'NOT_STARTED')
      						<small class="label label-danger">
                    <i class="fa fa-ban" aria-hidden="true"></i> {{$todo->status}}</small>
      					@elseif ($todo->status == 'ONGOING')
      						<small class="label label-success"><i class="fa fa-spinner" aria-hidden="true"></i> {{$todo->status}}</small>
      					@elseif ($todo->status == 'POSTPONED')
      						<small class="label label-warning"><i class="fa fa-pause" aria-hidden="true"></i> {{$todo->status}}</small>
      					@elseif ($todo->status == 'PUBLISHED')
      						<small class="label label-primary"><i class="fa fa-newspaper-o" aria-hidden="true"></i> {{$todo->status}}</small>
      					@elseif ($todo->status == 'DONE')
      						<small class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> {{$todo->status}}</small>
                  
      					@endif
                <input type="hidden" name="todo_id"  value="{{$todo->id}}">
              </span>
                <span class="pull-right">
                 @if($todo->updated_by)
                Last Update: <i class="fa fa-user" aria-hidden="true"></i> {{ $todo->updated_by }} <i class="fa fa-calendar" aria-hidden="true"></i> {{ $todo->updated_at->diffForHumans() }}

                @else
                <i></i>
                  @endif
                </span>
                </span>
               
              </div>
              <!-- /.user-block -->

            <!-- /.box-header -->
            <div id="description" class="box-body">
              <!-- post text -->

				{!!$todo->description!!}
         <span class="pull-right">
         @if($todo->assigned_to)
              Assigned To: {{\App\User::find($todo->assigned_to)->full_name}}
              @endif
              </span>
              </div>
             
            <div class="box-footer">

               <a href="{{ route('todo.delete',$todo->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>

               <a href="{{ route('todo.edit',$todo->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

               <a href="{{ route('todo.discuss',$todo->id) }}" class="btn btn-xs btn-success"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-comment" aria-hidden="true"></i></a>

                <a class='pull-right' href=@if($todo->discussion) "{{route('discussion.list',['todo',$todo->id])}}"@endif >
                  <span class="badge">{{count($todo->discussion)}}
                  Discussion{{count($todo->discussion) > 1 ? 's' : ''}}
                 <i class="fa fa-commenting" aria-hidden="true"></i> </span></a>
            </div>

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
