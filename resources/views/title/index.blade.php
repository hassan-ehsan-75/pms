<?php
/* Default values */
$_PAGE_TITLE='Titles List';
$_PAGE_SUB_TITLE='All titles';
?>
@extends('layout.gui')
@section('content')
	{{-- expr --}}

@if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger')
 <hr>
  <a href="{{route('title.create')}}" class="btn btn-success"> Create title <i class="fa fa-briefcase" aria-hidden="true"></i></a>
  @endif
 <hr>
@if($titles->count() != 0)
 <div class="row">
@foreach($titles as $title)
<div class="col-md-6">
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <span class="username"><small>
                  {{$title->title_name}}
                </small>
                </span>
                <span class="description">
									<small ><i class="fa fa-calendar" aria-hidden="true"></i>{{$title->created_at->diffForHumans()}}  </small>
								</span>
              </div>
              <!-- /.user-block -->

            </div>
    
              <div class="box-footer">

                @if(Auth::user()->hasPermission('Admin') || Auth::user()->hasPermission('Manger'))

               <a href="{{ route('title.edit',$title->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
               
                <a href="{{ route('title.delete',$title->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                @endif



              </div>

          </div>
   </div>

@endforeach
{{$titles->links()}}
</div>
@else <center><h4>No titles yet</h4></center>
@endif

@endsection
