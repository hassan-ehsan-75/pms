
<?php
/* Default values */
$_PAGE_TITLE='Users List';
$_PAGE_SUB_TITLE='all Users';
?>
@extends('layout.gui')
@section('content')



  @if(Auth::user()->hasPermission('Admin')  || Auth::user()->hasPermission('Manger') )

 <hr>
	<a href="{{route('user.create') }}" class="btn btn-success">New user <i class="fa fa-user" aria-hidden="true"></i></a>
  @endif
 <hr>

<div class="row">

@foreach ($users as $user)
<div class="col-md-6">
<div class="box box-widget">
<div class="box-header with-border">
            <!-- Add the bg color to the header using any of the bg-* classes -->



                <h4><b><a href="{{route('user.profile',$user->id)}}"> {{$user->full_name}} ({{$user->getTitle()}})</a></b></h4>
				<small><i class="fa fa-user" aria-hidden="true"></i> {{$user->creator->full_name}}  </small>
				<small><i class="fa fa-calendar" aria-hidden="true"></i> {{$user->created_at->toFormattedDateString()}} </small>
				<small><i class="fa fa-lock" aria-hidden="true"></i> {{$user->getPermission()}} </small>
                </div>
                <div class="box-body">

				<div class="row">
				<div class="col-md-3">
				<img class="img-thumbnail" src="{{asset($user->getAttachment())}}" alt="User Image">
				</div>
				<div class="col-md-9">
				<small><i class="fa fa-envelope-o" aria-hidden="true"></i> <a href="mailto:{{$user->email}}">{{$user->email}}</a></small><br>
				@if($user->phone)
				<small><i class="fa fa-phone" aria-hidden="true"></i> {{$user->phone}}</a></small><br>
				@else <small><i class="fa fa-phone" aria-hidden="true"></i> Not Avaliable</a></small><br>
				@endif
				@if($user->skype)
				<small><i class="fa fa-skype" aria-hidden="true"></i> {{$user->skype}}</a></small><br>
				@else <small><i class="fa fa-skype" aria-hidden="true"></i> Not Avaliable</a></small><br>
				@endif
				@if($user->location)
				<small><i class="fa fa-map-marker" aria-hidden="true"></i> {{$user->location}}</a></small><br>
				@else <small><i class="fa fa-map-marker" aria-hidden="true"></i> Not Avaliable</a></small><br>
				@endif
				@if($user->facebook)
				<small><i class="fa fa-facebook-square" aria-hidden="true"></i> {{$user->facebook}}</a></small><br>
				@else <small><i class="fa fa-facebook-square" aria-hidden="true"></i> Not Avaliable</a></small><br>
				
				@endif
				@if($user->linkedin)
				<small><i class="fa fa-linkedin-square" aria-hidden="true"></i> {{$user->linkedin}}</a></small>
				<br>
				@else <small><i class="fa fa-linkedin-square" aria-hidden="true"></i> Not Avaliable</a></small><br>
				@endif
				@if($user->twiter)
				<small><i class="fa fa-twitter" aria-hidden="true"></i> {{$user->twiter}}</a></small><br>
				@else <small><i class="fa fa-twitter" aria-hidden="true"></i> Not Avaliable</a></small><br>
				@endif
				</div>
				</div>

              </div>


              @if(Auth::user()->getPermission() == 'Admin' || Auth::user()->getPermission() == 'Manger')
				      <div class="box-footer">
               <a href="{{route('user.edit',$user->id)}}" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
      			<a href="{{route('user.delete',$user->id)}}" class="btn btn-xs btn-danger delete" onclick="return confirm('Are you sure?')" ><i class="fa fa-trash" aria-hidden="true"></i></a>
				 </div>
				@endif


          </div>
       </div>

	@endforeach


</div>



@endsection
