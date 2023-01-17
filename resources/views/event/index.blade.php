
<?php
/* Default values */
$_PAGE_TITLE='event List';
$_PAGE_SUB_TITLE='all events';
?>
@extends('layout.gui')
@section('content')
<div class="container-fluid">
@if(count($events) != 0)
@foreach($events as $event)
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="{{asset($event->user->getAttachment())}}" alt="User Image">
                <span class="username"><a href="{{ url($event->link_id) }}">
                  <h4>
                           {{$event->user->full_name }}
                        <small><i class="fa fa-clock-o"></i> {{$event->created_at->diffForHumans()}}</small>
                      </h4>
                      <p>
has {{$event->type}} a {{$event->content_type}} <b>{{strip_tags(html_entity_decode($event->title))}}</b>
</p>
                </a>
                
                   </span>
               
              </div>
              
            </div>
            <!-- /.box-header -->


          </div>
@endforeach
{{$events->links()}}
@else   <center><h2>No Events yet</h2></center>
@endif
</div>
@endsection
