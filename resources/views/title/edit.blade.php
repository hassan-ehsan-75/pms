<?php
/* Default values */
$_PAGE_TITLE='Title Create';
$_PAGE_SUB_TITLE='create title';
?>
?>
@extends('layout.gui')
@section('content')
    <div class="container-fluid">
       
       <form class="form-horizontal"  method="post" action="{{route('title.update',$title->id)}}">
         {{csrf_field()}}
         <fieldset>
            <!-- Form Name -->
            <legend></legend>
            <div class="box-body">
               <!-- Select Basic -->
               <div class="form-group">
                  <label class="col-md-2 control-label" for="title_name">Title Name:</label>
                  <div class="col-md-4">
                     <input type="text" class="form-control" name="title_name" required="" 
                     value="{{$title->title_name}}">
                     <span class="help-block">the name of the title</span>
                  </div>
               </div>
           <button type="submit" class="btn btn-primary">Save</button>
       </form>

@endsection