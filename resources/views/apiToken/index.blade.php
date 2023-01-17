<?php
/* Default values */
$_PAGE_TITLE='ApiTokens List';
$_PAGE_SUB_TITLE='all tokens';
?>
@extends('layout.gui')
@section('content')
	<hr>
  <a href="{{route('apiToken.create')}}" class="btn btn-success"> New Token <i class="fa fa-edit" aria-hidden="true"></i></a>
 
 <hr>

		<?php $id=0; ?>
	    @foreach ($tokens as $token)
			<?php $id++; ?>
	    <div class="box">
		<div class="box-header">
		<h4 class="box-title">Platform: {{$token->platform}} 
		@if($token->type == 'public')
		<span id="token_type" class="badge badge-yellow"> {{$token->type}} </span>
		@else <span id="token_type" class="badge badge-green"> {{$token->type}} </span>
		@endif

		</h4>
	    <div class="box-tools"><a href="{{ route('apiToken.delete',$token->id) }}" class="btn  btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>

	    <a href="{{ route('apiToken.edit',$token->id) }}" class="btn  btn-xs btn-warning"><i class="fa fa-edit" aria-hidden="true"></i></a>
	    </div>
		</div>
			<div class="box-body">
				<h5 class="text-info">Secretc Key:</h5>
				  <div class="input-group">
					<input id="<?php echo 'key'.$id;?>" type="text" class="form-control" value="{{$token->secret_key}}"  disabled />
					<span class="input-group-btn">
						<button class="btn btn-default" type="button"  title="Copy to Clipboard"
						onclick="copyText('#<?php echo 'key'.$id;?>')">
						<i class="fa fa-clipboard" aria-hidden="true"></i>
						</button>
					</span>
				</div>
  
				<h5 class="text-info">Token:</h5>
				  <div class="input-group">
					<input id="<?php echo 'tkn'.$id;?>" type="text" class="form-control copy-input" value="{{$token->token}}" disabled />
					<span class="input-group-btn">
						<button class="btn btn-default" type="button"  title="Copy to Clipboard"
						onclick="copyText('#<?php echo 'tkn'.$id;?>')">
						<i class="fa fa-clipboard" aria-hidden="true"></i>
						</button>
					</span>
				</div>
					
						
			</div>
	    </div>
	    			
	    @endforeach
	    {{$tokens->links()}}


	
@endsection