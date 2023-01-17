<?php
   /* Default values */
   $_PAGE_TITLE= $discussion->title;
   $_PAGE_SUB_TITLE="";
   ?>
@extends('layout.gui')
@section('content')

   <!-- Box Comment -->
   <div class="box box-widget">
      <div class="box-header with-border">
         <div class="user-block">
            <img class="img-circle" src="{{asset($discussion->user->getAttachment())}}" alt="User Image">
            <span class="username"><a href="#">{{$discussion->title}}</a></span>
            <span class="description">

             <small><i class="fa fa-user" aria-hidden="true"></i>{{$discussion->user->full_name}}</small>

            <small><i class="fa fa-calendar" aria-hidden="true"></i>{{$discussion->created_at->diffForHumans()}}</small>

            </span>
         </div>

         <!-- /.user-block -->
         <!-- /.box-header -->
         <div class="box-body">
            <div class="img-responsive">
               <blockquote>
                  <p>{!!$discussion->content!!}</p>
                  <small>Discussing  <cite title="Source Title">{{$discussion->type}}</cite> 
                  @if($discussion->type == 'project')
                  ({{$discussion->project->where('id',$discussion->link_id)->first()->title}})
                  @elseif($discussion->type == 'news')
                  ({{$discussion->news->where('id',$discussion->link_id)->first()->title}})
                  @elseif($discussion->type == 'todo')
                  (<?php $todo_sum=strip_tags(html_entity_decode($discussion->todo->where('id',$discussion->link_id)->first()->description));
                   if (strlen($todo_sum)>30){
                       $todo_sum=substr($todo_sum,0,30).'...';
                   }
                   echo $todo_sum;
                  ?>)
                  @elseif($discussion->type == 'task')
                  (<?php $task_sum=strip_tags(html_entity_decode($discussion->task->where('id',$discussion->link_id)->first()->content));
                   if (strlen($task_sum)>30){
                       $task_sum=substr($task_sum,0,30).'...';
                   }
                   echo $task_sum;
                  ?>)
                  @elseif($discussion->type == 'job')
                  ({{$discussion->task->where('id',$discussion->link_id)->first()->title}})
                  
                  @endif

                  </small>
               </blockquote>
            </div>

         </div>
         <div class="box-footer">
           @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $discussion->user_id )
           @if( Auth::user()->id == $discussion->user_id)
           <a href="{{ route('discussion.edit',$discussion->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
           @endif
           <a href="{{ route('discussion.delete',$discussion->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
           @endif
         </div>


         <div id="box-comments" class="box-footer box-comments">
            @foreach( $comments as $comment )
            <div class="box-comment">
               <!-- User image -->
               <div class="tools pull-right">
                  @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $comment->user_id )
                  <a href="{{ route('comment.delete',$comment->id) }}" onclick="return confirm('Are you sure?')">  <i class="fa fa-trash" aria-hidden="true"></i></a>
                  @endif
               </div>
               <img class="img-circle img-sm" src="{{ asset($comment->user->getAttachment()) }}" alt="User Image">
               <div class="comment-text">
                  <span class="username">
                  {{$comment->user->full_name}}
                  <span class="text-muted"> <i class="fa fa-calendar" aria-hidden="true"></i>{{$comment->created_at->diffForHumans()}}</span>
                  </span><!-- /.username -->
                  {!!$comment->content!!}
               </div>
               <!-- /.comment-text -->
            </div>
            <!-- /.box-comment -->
            @endforeach
            <!-- /.box-footer -->
           </div>
		   <div  class="box-footer">
               <form  id="comment_form" action="{{route('comment.store') }}" method="post">
                  {{csrf_field()}}
                  <img class="img-responsive img-circle img-sm" src="{{ asset(Auth::user()->getAttachment()) }}" alt="Alt Text">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                     <input id="comment_content" type="text" name="content" class="form-control input-sm" placeholder="Press enter to post comment" required>
                  </div>

                     <input id="discussion_id" name="discussion_id" type="hidden" value="{{$discussion->id}}" >

                  <!-- Loading (remove the following to stop the loading)-->
                  <div id="loading_icon" class="overlay">
                  </div>
                  <!-- end loading -->
               </form>
            </div>
            <!-- /.box-comment -->
         </div>
         <!-- /.box-footer -->
      </div>
   </div>

@endsection
