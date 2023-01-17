@if (count($errors))
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">

	<div class="form-group">
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert"
			aria-hidden="true">
		&times;
		</button>
		<ul >

		@foreach ($errors->all() as $error)
			<li>{{$error}}</li>
		@endforeach
		</ul>
	</div>
	</div>

	</div>
	</div>
@endif