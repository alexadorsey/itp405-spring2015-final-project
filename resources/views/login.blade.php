@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop


@section('hello-image')	
	<img id="hello-pic" src="{{ asset('img/awesome.png') }}">
@stop


@section('content')
    <h1>Login</h1>
    
    @if (Session::has('fail'))
        <p class="error-message">{{ Session::get('fail') }}</p>
    @endif
    
    <form method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control"> 
        </div>
            
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control"> 
        </div>
            
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember_me">
                Remember Me
            </label>
        </div>
        
        
        <input type="submit" value="Login" class="btn btn-danger">
        
    </form>
@stop