@if ($flash=session('message'))
	<div class="alert alert-success alert-dismissable" id="flash-message">
		<button type="button" class="close" data-dismiss="alert"
			aria-hidden="true">
		&times;
		</button>
		{{$flash}}
	</div>
@endif