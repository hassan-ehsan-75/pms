<?php
/* Default values */
$_PAGE_TITLE='ApiToken Create';
$_PAGE_SUB_TITLE='create token';
?>
?>
@extends('layout.gui')
@section('content')
		<div class="container-fluid">
			 
			 <form class="form-horizontal"  method="post" action="{{route('apiToken.store')}}">
         {{csrf_field()}}
         <fieldset>
            <!-- Form Name -->
            <legend></legend>
            <div class="box-body">
               <!-- Select Basic -->
               <div class="form-group">
                  <label class="col-md-2 control-label" for="platform">platform</label>
                  <div class="col-md-4">
                     <input type="text" class="form-control" name="platform" required="">
                     <span class="help-block">Token platform</span>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-2 control-label" for="secret_key">secret key</label>
                  <div class="col-md-4">
                     <input type="text" class="form-control" name="secret_key" required="">
                     <span class="help-block">Token secretkey </span>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-2 control-label" for="type">key type</label>
                  <div class="col-md-4">
                     <select name="type" class="form-control">
                       
                       <option value="private">private</option>
                       <option value="public">public</option>
                       
                     </select>
                     <span class="help-block">Token key type </span>
                  </div>
               </div>
           </div></fieldset>
           <button type="submit" class="btn btn-primary">Save</button>
       </form>

@endsection