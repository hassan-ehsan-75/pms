<?php
   /* Default values */
   $_PAGE_TITLE='Dashboard';
   $_PAGE_SUB_TITLE='';
   ?>
@extends('layout.gui')
@section('content')
{{-- expr --}}
</br>

<!--Annoucment is only shown when there are any-->
@if(count(\App\Announcement::orderBy('created_at','DESC')->limit(5)->get()) != 0)
<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-bullhorn" aria-hidden="true"></i> Announcements</h3>
   </div>
   <div class="box-footer no-padding">
      <ul class="nav nav-pills nav-stacked">
         @foreach (\App\Announcement::orderBy('created_at','DESC')->limit(5)->get() as $announcement)
         <li>
            <a href="{{route('announcement.index')}}" class="uppercase">
				<div class="row">
				<div class="col-md-10">
				<span class="badge bg-green">
						<i class="fa fa-bullhorn" aria-hidden="true"></i>
					</span>

					{{$announcement->title}}
				</div>
				<span class="col-md-2">
					<small>
						<i class="fa fa-calendar" aria-hidden="true"></i>
						{{$announcement->created_at->diffForHumans()}}
					</small>

				</span>
				</div>
            </a>
         </li>
         @endforeach
      </ul>
   </div>
</div>
@endif



<div class="row">
  
   <div class="col-md-6">
      <div class="box box-primary">
         <div class="box-header with-border">
            <h3 class="box-title"> <i class="fa fa-tasks" aria-hidden="true"></i>  Recent Project</h3>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
		  @if(count(\App\Project::orderBy('created_at','DESC')->limit(5)->get()) != 0)
            <ul class="products-list product-list-in-box">
               @foreach (\App\Project::orderBy('created_at','DESC')->limit(5)->get() as $project)
               <li class="item">
                  <div class="product-img">
                     <img class="img-circle" src="{{asset($project->getAttachment())}}" alt="Product Image">
                  </div>
                  <div class="product-info">
                     <a href="{{route('project.show',$project->id)}}" class="product-title">
                     {{$project->title}}
                     </a>
                     @if ($project->status == 'NOT_STARTED')
                     <span class="label label-danger pull-right"><i class="fa fa-ban" aria-hidden="true"></i> {{$project->status}}</span>
                     @elseif ($project->status == 'ONGOING')
                     <span class="label label-success pull-right"><i class="fa fa-spinner" aria-hidden="true"></i> {{$project->status}}</span>
                     @elseif ($project->status == 'POSTPONED')
                     <span class="label label-warning pull-right"><i class="fa fa-pause" aria-hidden="true"></i> {{$project->status}}</span>
                     @elseif ($project->status == 'PUBLISHED')
                     <span class="label label-primary pull-right"><i class="fa fa-newspaper-o" aria-hidden="true"></i> {{$project->status}}</span>
                     @elseif ($project->status == 'DONE')
                     <span class="label label-success pull-right"><i class="fa fa-check" aria-hidden="true"></i> {{$project->status}}</span>
                     @endif
                     <span class="product-description">
                        <div class="container">
                           <div class="row">
                              <div class="col-md-1"><small> <i class="fa fa-user" aria-hidden="true"></i>
                                 {{$project->user->full_name}}
                                 </small>
                              </div>
                              <div class="col-md-1"><small> <i class="fa fa-calendar" aria-hidden="true"></i>
                                 {{$project->created_at->diffForHumans()}}
                                 </small>
                              </div>

						</div>
						</div>

						   <div class="pull-right">
						   <small class="badge">
                                 <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                 {{count(\App\Task::where('project_id' , $project->id)->get())}}

                                 </small>

								<small class="badge">
                                 <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                 {{count($project->discussions)}}
                                 </small>
                              </div>
                     </span>

               </li>
               @endforeach
               <!-- /.item -->
            </ul>
				@else
				<center><h4>No projects yet</h4></center>
			   @endif
            </div>
			 @if(count(\App\Project::orderBy('created_at','DESC')->get()) > 5)
            <div class="box-footer text-center">
               <a href="{{route('project.index')}}" class="uppercase">View All Projects</a>
            </div>
			  @endif
		
         </div>
      </div>
   

      <div class="col-md-6">
         <div class="box box-warning">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-thumb-tack" aria-hidden="true"></i>  Recent Task</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			 @if(count(\App\Task::orderBy('created_at','DESC')->limit(5)->get()) != 0)
               <ul class="products-list product-list-in-box">
                  @foreach (\App\Task::orderBy('created_at','DESC')->limit(5)->get() as $task)
                  <li class="item">
                     <div class="product-img">
                        <div class="badge bg-blue">
                           <i class="fa fa-thumb-tack fa-3x" aria-hidden="true"></i>
                        </div>
                     </div>
                     <div class="product-info">
                        <a href="{{route('task.show',$task->id)}}" class="product-title">
                        <?php $task_sum=strip_tags(html_entity_decode($task->content));
							$todo_all=count(\App\ToDo::where('task_id' , $task->id)->get());
                           $todo_done=count(\App\ToDo::where([['task_id' , $task->id],['status' ,'DONE']])->get());
                           $todo_ongoing=\App\ToDo::where([['task_id' , $task->id],['status' ,'ONGOING']])->get();
                           if($todo_all!=0)
								$todo_precent=($todo_done*100)/$todo_all;
							else
								$todo_precent=0;

							echo $todo_precent==100?'<strike>':'';
							echo strlen($task_sum)>30?substr($task_sum,0,30).'...':$task_sum;
							echo $todo_precent==100?'</strike>':'';
						?>

                        </span></a>
                        <div class="pull-right">
                           <a href="{{route('project.show',$task->project->id)}}"><small class="label label-default">
                           <i class="fa fa-tasks" aria-hidden="true"></i>
                           {{$task->project->title}}
                           </small></a>
						 </div>
                           <span class="product-description">
                              <div class="container">
                                 <div class="row">
                                    <div class="col-md-1"><small>
                                       <i class="fa fa-user" aria-hidden="true"></i>
                                       {{$task->user->full_name}}
                                       </small>
                                    </div>

									  <div class="col-md-1"><small>
                                       <i class="fa fa-calendar" aria-hidden="true"></i>
                                       {{$task->created_at->diffForHumans()}}
                                       </small>
                                    </div>

                                 </div>
                              </div>

                        @if($todo_all>0)
                        <br>
                        <div class="progress-group">
                        <span class="progress-text">TODO Progress</span>
                        <span class="progress-number"><b>{{$todo_done}}</b>/{{$todo_all}} </span>
                        <div class="progress sm">
                        <div class="progress-bar progress-bar-{{$todo_precent==100?'green':'yellow'}}" style="width: {{$todo_precent}}%"></div>
                        </div>
                        </div>
						<a><small class="badge pull-right"> <i class="fa fa-commenting-o" aria-hidden="true"></i>  {{count($task->discussions)}}</small></a>
						
						@if(count($todo_ongoing)>0)
						<span class="badge bg-green pull-right">  <i class="fa fa-spinner" aria-hidden="true"></i> {{count($todo_ongoing)}} </span>	 
						
						<small><i>
						       @foreach($todo_ongoing as $ongoing)
							   <br>   
							   <a href="{{route('todo.show',$ongoing->id)}}">
								<span class="badge bg-green">
							   <i class="fa fa-spinner" aria-hidden="true"></i>
							 ({{$ongoing->updated_by}})
							   <?php
							   $task_sum_ongoing=strip_tags(html_entity_decode($ongoing->description));
								echo ''.strlen($task_sum_ongoing)>30?substr($task_sum_ongoing,0,30).'...':$task_sum_ongoing;
							
							   ?>
							   </span>
							   </a>
								
							<small>  {{ $ongoing->updated_at->diffForHumans() }} </small>  
							    @endforeach
								</i>
						</small>
                        @endif
                        @endif

						

                     </span>
            </div>
            </li>
            @endforeach
            <!-- /.item -->
            </ul>
			@else
			<center><h4>No tasks yet</h4></center>
			@endif

         </div>
		 @if(count(\App\Task::orderBy('created_at','DESC')->get())>5)
         <div class="box-footer text-center">
            <a href="{{route('task.index','all')}}" class="uppercase">View All tasks</a>
         </div>
		 @endif
      </div>
   </div>

</div>
<div class="row">
  
   <div class="col-md-6">
      <div class="box box-success">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-commenting-o" aria-hidden="true"></i>  Recent Discussion</h3>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
		  @if(count(\App\Discussion::orderBy('created_at','DESC')->limit(5)->get()) != 0)
            <ul class="products-list product-list-in-box">
               @foreach (\App\Discussion::orderBy('created_at','DESC')->limit(5)->get() as $discussion)
               <li class="item">
                  <div class="product-img">
                     <img class="img-circle" src="{{asset($discussion->user->getAttachment())}}" alt="Product Image">
                  </div>
                  <div class="product-info">
                     <a href="{{route('discussion.show',$discussion->id)}}" class="product-title">
                     @if ($discussion->type == 'task')
                     <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                     @elseif ($discussion->type == 'project')
                     <i class="fa fa-tasks" aria-hidden="true"></i>
                     @elseif ($discussion->type == 'todo')
                     <i class="fa fa-check-square" aria-hidden="true"></i>
                     @elseif ($discussion->type == 'news')
                     <i class="fa fa fa-newspaper-o" aria-hidden="true"></i>
                      @elseif ($discussion->type == 'job')
                     <i class="fa fa fa-briefcase" aria-hidden="true"></i>
                      @elseif ($discussion->type == 'announcement')
                     <i class="fa fa fa-bullhorn" aria-hidden="true"></i>
                     @endif
                     {{$discussion->title}}
                     </a>
                     <span class="product-description">
                        <div class="row">
                           <div class="col-md-2"><small> <i class="fa fa-user" aria-hidden="true"></i>
                              {{$discussion->user->full_name}}
                              </small>
                           
                              <small > <i class="fa fa-calendar" aria-hidden="true"></i>
                              {{$discussion->created_at->diffForHumans()}}
                              </small>
                           </div>
                           <div class="col-md-2 pull-right"><small>
                              <span class="pull-right">{{count($discussion->discussionComments)}} Comments </span>
                              </small>
                           </div>
                        </div>
                     </span>
                  </div>
               </li>
               @endforeach
               <!-- /.item -->
            </ul>
			@else
				<center><h4>No discussions yet</h4></center>
			  @endif
         </div>
		 	  @if(count(\App\Discussion::orderBy('created_at','DESC')->get()) > 5)
         <div class="box-footer text-center">
            <a href="{{route('discussion.index')}}" class="uppercase">View All Discussion</a>
         </div>
		  @endif
         <!-- /.col -->
      </div>
   </div>
   <!-- /.row -->
 
   <div class="col-md-6">
      <div class="box box-success">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-check-square" aria-hidden="true"></i> Recent TODOs</h3>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
            @if(count(\App\ToDo::orderBy('created_at','DESC')->limit(5)->get()) != 0)
            <ul class="products-list product-list-in-box">
               @foreach (\App\toDo::orderBy('created_at','DESC')->limit(5)->get() as $todo)
               <li class="item">
                  <div class="product-img">
                     <img class="img-circle" src="{{asset($todo->user->getAttachment())}}" alt="Product Image">
                  </div>
                  <div class="product-info">
                     <a href="{{route('todo.show',$todo->id)}}" class="product-title">
                     <?php $todo_sum=strip_tags(html_entity_decode($todo->description));
                        if (strlen($todo_sum)>30){
                            $todo_sum=substr($todo_sum,0,30).'...';
                        }
                        echo $todo_sum;

                        ?>
                     </a>
                     <span class="todo-status pull-right">
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
                     <span class="product-description">
                        <div class="row">
                           <div class="col-md-2"><small> <i class="fa fa-user" aria-hidden="true"></i>
                              {{$todo->user->full_name}}
                              </small>
                          
                              <small > <i class="fa fa-calendar" aria-hidden="true"></i>
                              {{$todo->created_at->diffForHumans()}}
                              </small>
                           </div>
                           <div class="col-md-2 pull-right">
                              <a><small class="badge pull-right"> <i class="fa fa-commenting-o" aria-hidden="true"></i>  {{count($todo->discussion)}}</small></a>
                           </div>
                        </div>
                     </span>
                  </div>
               </li>
               @endforeach
               <!-- /.item -->
            </ul>
            @else
            <center>
               <h4>No TODOs yet</h4>
            </center>
            @endif
         </div>
		  @if(count(\App\ToDo::orderBy('created_at','DESC')->get())>5 )
         <div class="box-footer text-center">
            <a href="{{route('todo.index','all')}}" class="uppercase">View All TODOs</a>
         </div>
		   @endif
         <!-- /.col -->
      </div>
   </div>
   <!-- /.row -->
</div>

   <div class="box box-widget">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Recent news</h3>
      </div>
      <div class="box-body">
	  @if(count(\App\News::orderBy('id','DESC')->get()) != 0)
         @foreach (\App\News::orderBy('id','DESC')->limit(5)->get() as $news)
         <div class="col-md-6">
            <div class="box box-widget">
               <div class="box-header with-border">
                  <div class="user-block">
                     <img class="img-circle" src="{{asset($news->user->getAttachment())}}" alt="User Image">
                     <span class="username"><a href="{{route('news.show',$news->id)}}">
                     <small>
                     	 <?php $news_sum=strip_tags(html_entity_decode($news->title));
                        if (strlen($news_sum)>30){
                            $todo_sum=substr($news_sum,0,30).'...';
                        }
                        echo $news_sum;

                        ?>
                        </small>
                     </a>

					 @if ($news->status == 'DRAFT')
                     <span class="label label-success pull-right"><i class="fa fa-spinner" aria-hidden="true"></i><small> DRAFT</small></span>
                     @elseif ($news->status == 'PUBLISHED')
                     <span class="label label-primary pull-right"><i class="fa fa-newspaper-o" aria-hidden="true"></i><small> PUBLISHED</small></span>
                     @endif
                    
                     </span>
                     <span class="description">
					 <div class="row">
					<small ><i class="fa fa-user" aria-hidden="true"></i> {{$news->user->full_name}}</small>
					<small ><i class="fa fa-calendar" aria-hidden="true"></i> {{$news->created_at->diffForHumans()}} </small>

					</div>
					 </span>
                  </div>
                  <!-- /.user-block -->
               </div>
               <div class="box-body description-wrapper">
                  @if($news->attachment)
                  <img class="description-img" src="{{asset($news->getAttachment())}}" alt="Attachment Image">
                  @endif
                  <!-- post text -->
                  <?php
                     $striped=strip_tags($news->content);
                     echo strlen($striped)>300?substr($striped,0,300).'...':$striped;
                     ?>
					 <br>
					 <small class="badge pull-right"> <i class="fa fa-commenting-o" aria-hidden="true"></i> {{count($news->discussions)}}</small>
               </div>

            </div>
         </div>
         @endforeach
		 @else
			 <center><h4>No news yet</h4></center>
		 @endif
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
