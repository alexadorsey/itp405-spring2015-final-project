@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop

@section('content')
    <div class="sign-up-header">
		<h1>Edit Position</h1>
	</div>
	@if (Session::has('success'))
        <p class="success-message">{{ Session::get('success') }}</p>
    @endif
	
	<form class="form-horizontal" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="form-group">
            <label for="position-name" class="control-label col-xs-5 input-type">Position Name:</label>
            <div class="col-xs-5 input-box">
                <input type="text" class="form-control" id="position-name" name="position-name" value="{{ $position->name }}">
            </div>
        </div>
          
		<input type="submit" value="Edit" class="btn btn-info"> 
    </form>
@stop