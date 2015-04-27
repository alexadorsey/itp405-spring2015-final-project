@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop

@section('content')
	<div class="sign-up-header">
		<h1>Login</h1>
	</div>
	
	<input type="hidden" id="redirect-url" value="{{ url('dashboard') }}">
	@if (Session::has('fail'))
        <p class="error-message">{{ Session::get('fail') }}</p>
	@else
		@if (!$first)
			<script>
				var url = document.getElementById("redirect-url").value;
				window.top.location.href = url;
				parent.$.fancybox.close();
			</script>
		@endif
    @endif
    
    <form class="form-horizontal login-form" id="sign-up-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <div class="form-group">
            <label for="email" class="control-label col-xs-4 input-type">Email:</label>
            <div class="col-xs-4 input-box">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ Request::old('email') }}">
            </div>
        </div>
            
        <div class="form-group">
            <label for="password" class="control-label col-xs-4 input-type">Password:</label>
            <div class="col-xs-4 input-box">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
        </div>
		 
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember_me">
                Remember Me
            </label>
        </div>
        
        
        <input type="submit" value="Login" class="btn btn-info login-button">
        
    </form>
@stop