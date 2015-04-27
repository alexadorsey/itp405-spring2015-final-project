@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop

@section('content')
	<div class="sign-up-header">
		<h1>Sign Up</h1>
	</div>
	<input type="hidden" id="redirect-url" value="{{ url('dashboard') }}">
	@if (count($errors->all()) == 0 && !$first)
		<script>
			var url = document.getElementById("redirect-url").value;
			window.top.location.href = url;
			parent.$.fancybox.close();
		</script>
	@else
		@foreach($errors->all() as $error)
			<p class="error-message">{{ $error }}</p>
		@endforeach
	@endif
		
    <form class="form-horizontal" id="sign-up-form">
		<div class="form-group">
            <label for="first-name" class="control-label col-xs-5 input-type">First Name:</label>
            <div class="col-xs-5 input-box">
                <input type="text" class="form-control" id="first-name" name="first-name" placeholder="First Name" value="{{ Request::old('first-name') }}">
            </div>
        </div>
			
		<div class="form-group">
            <label for="last-name" class="control-label col-xs-5 input-type">Last Name:</label>
            <div class="col-xs-5 input-box">
                <input type="text" class="form-control" id="last-name" name="last-name" placeholder="Last Name" value="{{ Request::old('last-name') }}">
            </div>
        </div>	
			
        <div class="form-group">
            <label for="email" class="control-label col-xs-5 input-type">Email:</label>
            <div class="col-xs-5 input-box">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ Request::old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="control-label col-xs-5 input-type">Password:</label>
            <div class="col-xs-5 input-box">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
        </div>
			
		<div class="form-group">
            <label for="password_confirmation" class="control-label col-xs-5 input-type">Confirm Password:</label>
            <div class="col-xs-5 input-box">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
            </div>
        </div>
<!--
        <div class="form-group">
            <div class="col-xs-offset-4 col-xs-5">
                <div class="checkbox">
                    <label><input type="checkbox"> Remember me</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-offset-4 col-xs-5">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </div>
-->
            
        <input type="submit" value="Sign Up" class="btn btn-info">
        
    </form>

@stop

