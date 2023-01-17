<?php
   $_PAGE_TITLE='Project: "'.$project->title .'"';
   $_PAGE_SUB_TITLE='';
   ?>
@extends('layout.gui')
@section('content')
<div class="container-fluid">
<div class="box box-widget">
   <div class="box-header with-border">
      <div class="user-block">
         <img class="img-circle" src="{{asset($project->user->getAttachment())}}" alt="User Image">
         <span class="username">
         <a href="{{route('project.show',$project->id)}}">{{$project->title}} </a>
         </span>
         <span class="description"> 
         <small><i class="fa fa-user" aria-hidden="true"></i> {{$project->user->full_name}}  </small>
         <small ><i class="fa fa-calendar" aria-hidden="true"></i>{{$project->created_at->diffForHumans()}}  </small> 
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
         <span class="pull-right">
            @if($project->phase)
            @if($project->phase == 'Desgin')
            <i class="fa  fa-paint-brush"></i> Desgin
            @elseif($project->phase == 'Development')
            <i class="fa fa-code"></i> Development

            @elseif($project->phase == 'Testing')
            <i class="fa fa-cogs"></i> Testing
             @elseif($project->phase == 'Release')
            <i class="fa fa-copyright"></i> Release
            @endif
            @endif
         </span>
         </span>
      </div>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
      <div  class="description-wrapper">
         @if($project->attachment)
         <img class="description-img" src="{{asset($project->getAttachment())}}" alt="Attachment Image">
         @endif  
         <!-- post text -->
         {!!$project->description!!}
         <hr>
         
         <!--the chart partial-->

         @include('project.pieChart', ['doneTodos'=>$doneTodos,'onGOing'=>$onGoing,'notStarted'=>$notStarted,'postPoned'=>$postPoned])


      </div>
   </div>
   <div class="box-footer">
      <a href="{{ route('project.discuss',$project->id) }}" class="btn btn-xs btn-success"> <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-comment" aria-hidden="true"></i></a>	
      @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' )
      <a href="{{ route('task.create',$project->id) }}" class="btn btn-xs btn-primary">  <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
      <a href="{{ route('project.edit',$project->id) }}" class="btn btn-xs btn-warning"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
      <a href="{{ route('project.delete',$project->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">  <i class="fa fa-trash" aria-hidden="true"></i></a>
      @endif
      <small class="pull-right">
       <a href=@if($project->discussions) "{{route('discussion.list',['project',$project->id])}}"@endif > 
      <span class="badge">{{count($project->discussions)}} 
      Discussion{{count($project->discussions)>1?"s":""}} <i class="fa fa-commenting-o" aria-hidden="true"></i>
      </span>
      </a>								
      <a href="{{ route('task.index',$project->id) }}" > 
      <span class="badge">{{count($project->tasks)}} 
      Task{{count($project->tasks)>1?"s":""}} <i class="fa fa-thumb-tack" aria-hidden="true"></i>
      </span>
      </a>
     
      </small>
   </div>
</div>
</div>
<!-- /.project box end -->
<!-- discussions -->
<div class="row">
   <div class="col-md-6">
      <div class="box box-primary">
         <div class="box-header with-border">
            <h3 id="discussions" class="box-title">Project discussions</h3>
         </div>
         @if(count($discussions)> 0)
         @foreach($discussions as $discussion)
         <div class="box box-widget">
            <div class="box-header with-border">
               <div class="user-block">
                  <a href="{{route('user.profile',$discussion->user->id)}}"> 
                  <img class="img-circle" src="{{asset($discussion->user->getAttachment())}}" alt="User Image">
                  </a>
                  <span class="username">  <a href="{{route('discussion.show',$discussion->id)}}"> {{$discussion->title}}</a></span>
                  <span class="description">
                  <small ><i class="fa fa-user" aria-hidden="true"></i> {{$discussion->user->full_name}}  </small>
                  <small ><i class="fa fa-calendar" aria-hidden="true"></i>{{$discussion->created_at->diffForHumans()}}  </small> 
                  <b>
                  <a class="pull-right badge" href="{{route('discussion.show',$discussion->id)}}"> 
                  {{App\DiscussionComment::all()->where('discussion_id',$discussion->id)->count()}} 
                  comment{{App\DiscussionComment::all()->where('discussion_id',$discussion->id)->count()>1?"s":""}}
                  </a>
                  </b>
                  </span>
               </div>
               <!-- /.user-block -->
            </div>
         </div>
         @endforeach
         @else
         <center>
            <h4>No discussions yet</h4>
         </center>
         @endif
      </div>
   </div>
   <!-- tasks -->
   <div class="col-md-6">
      <div class="box box-warning">
         <div class="box-header with-border">
            <h3 class="box-title">Project tasks</h3>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
            @if(count($project->tasks) > 0)
            <ul class="products-list product-list-in-box">
               @foreach ($project->tasks as $task)
               <li class="item">
                  <div class="product-img">
                     <div class="icon">
                        <i class="fa fa-thumb-tack fa-3x" aria-hidden="true"></i>
                     </div>
                  </div>
                  <div class="product-info">
                     <a href="{{route('task.show',$task->id)}}" class="product-title">
                     <?php $task_sum=strip_tags(html_entity_decode($task->content));
                        if (strlen($task_sum)>40){
                            $task_sum=substr($task_sum,0,40).'...';
                        }
                        echo $task_sum;
                        ?>
                     </span></a>
                     <span class="product-description">
                      
                         
                              <div class="col-md-1"><small>
                                 <i class="fa fa-user" aria-hidden="true"></i>
                                 {{$task->user->full_name}}
                                 </small>
                              <small>
                                 <i class="fa fa-calendar" aria-hidden="true"></i>
                                 {{$task->created_at->diffForHumans()}}
                                 </small>
                              </div>
                              <small>
                                  <a href="{{route('todo.index',$task->id)}}" class="pull-right badge">  
                                 {{count(\App\ToDo::where('task_id' , $task->id)->get())}}
                                 TODO{{ App\ToDo::where('task_id' , $task->id)->count()>1?"s":""}}
                                 <i class="fa fa-check-square" aria-hidden="true"></i>
                                 </a>
                                 </small>
                            
                           
                      
                     </span>
                  </div>

               </li>

               @endforeach
               <!-- /.item -->
            </ul>
            @else
            <center>
               <h4>No tasks yet</h4>
            </center>
             @endif
            </div>
            
           
         </div>
      </div>
   


@endsection