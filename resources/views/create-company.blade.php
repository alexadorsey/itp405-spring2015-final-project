@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop

@section('content')
    <div class="sign-up-header">
		<h1>Create a New Company</h1>
	</div>
	@if (Session::has('success'))
        <p class="success-message">{{ Session::get('success') }}</p>
    @endif
        
    @foreach ($errors->all() as $errorMessage)
        <p style="color:red">*{{ $errorMessage }}</p>
    @endforeach
	
	<form class="form-horizontal" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="form-group">
            <label for="name" class="control-label col-xs-5 input-type">Company Name:</label>
            <div class="col-xs-5 input-box">
                <input type="text" class="form-control" id="name" name="name">
            </div>
        </div>
			
		<div class="form-group">
            <label for="icon" class="control-label col-xs-5 input-type">Icon URL:</label>
            <div class="col-xs-5 input-box">
                <input type="text" class="form-control" id="icon" name="icon">
            </div>
        </div>
          
		<input type="submit" value="Add" class="btn btn-info"> 
    </form>
@stop


@section('javascript')
	<script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
@stop
