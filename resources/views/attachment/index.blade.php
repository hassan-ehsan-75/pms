<?php
/* Default values */
$_PAGE_TITLE='Attachment List';
$_PAGE_SUB_TITLE='All attachment';
?>
@extends('layout.gui')
@section('content')
	{{-- expr --}}
<div class="container-fluid">
@if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger')
 <hr>
  <a href="{{route('attachment.create')}}" class="btn btn-success"> Create attachment <i class="fa fa-paperclip" aria-hidden="true"></i></a>
  @endif
 <hr>
 	@if($attachments->count() != 0)
	 <div class="row">
	@foreach($attachments as $attachment)
	<div class="col-md-3">
			  <div class="box box-widget">
				
				<div class="box-body">
				  <!-- post text -->
				  <small><b>{{$attachment->title}}</b></small>  
				  
				  
				  
				<a class="btn btn-xs btn-success pull-right" href="/{{$attachment->attachment_url}}"><i class="fa fa-link" aria-hidden="true"></i></a>
					 @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger' || Auth::user()->id == $attachment->user_id)
				   
					<a href="{{route('attachment.delete',$attachment->id) }}" class="btn btn-xs btn-danger pull-right" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash" aria-hidden="true"></i></a>
					@endif
			  
			  <br>
			   
			  <small class="label label-primary">{{$attachment->extension}}</small>
			  
				  </div>
				  <div class="box-footer">
					
				<a href="{{route('user.profile',$attachment->user->id)}}"><small class="label label-default"><i class="fa fa-user" aria-hidden="true"></i>{{$attachment->user->full_name}}</small></a>
					<small class="label label-default"><i class="fa fa-calendar" aria-hidden="true"></i>{{$attachment->created_at->diffForHumans()}}</small>
					  
				  </div>
			   
			  </div>
		</div>
			  
	@endforeach
	</div>
	@else <center><h4>No Attachments yet</h4></center>
	@endif
</div>
@endsection