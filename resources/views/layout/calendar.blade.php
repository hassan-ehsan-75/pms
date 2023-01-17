<?php
/* default values */
$_PAGE_TITLE='Calendar';
$_PAGE_SUB_TITLE='calendar';
?>

@extends('layout.gui')

@section('content')

<div class="col-md-11">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-black">
              @foreach($tasks as $task)
               <?php $task_sum=strip_tags(html_entity_decode($task->content));
              $todo_all=count(\App\ToDo::where('task_id' , $task->id)->get());
                           $todo_done=count(\App\ToDo::where([['task_id' , $task->id],['status' ,'DONE']])->get());
                          
                           if($todo_all!=0)
                $todo_precent=floor(($todo_done*100)/$todo_all);
              else
                $todo_precent=0;

              // echo $todo_precent==100?'<strike>':'';
              $task_title = strlen($task_sum)>30?substr($task_sum,0,30).'...':$task_sum;
              // echo $todo_precent==100?'</strike>':'';
            ?>
                <div class="col-sm-6">
                  <!-- Progress bars -->
                  <div class="clearfix">
                    <span class="pull-left">{{$task_title}}</span>
                    <small class="pull-right">{{$todo_precent}}</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: {{$todo_precent}}%;"></div>
                  </div>
                </div>
                <!-- /.col -->
              @endforeach

          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->


<script >
  @include('layout.calendarjs')
</script>


@endsection
