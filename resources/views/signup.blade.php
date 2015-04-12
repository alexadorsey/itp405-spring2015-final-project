@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop


@section('hello-image')	
	<img id="hello-pic" src="{{ asset('img/awesome.png') }}">
@stop


@section('content')
    <h1>Sign Up</h1>
    
    <form method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <div class="form-group">
            <label for="first-name">First Name</label> <!-- for must be same as input id to put focus on name-->
            <input type="text" id="first-name" name="first-name" class="form-control"> 
        </div>
        
        <div class="form-group">
            <label for="last-name">Last Name</label> <!-- for must be same as input id to put focus on name-->
            <input type="text" id="last-name" name="last-name" class="form-control"> 
        </div>
            
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control"> 
        </div>
            
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control"> 
        </div>
        
        <div class="form-group">
            <label for="password_confirmation">Confirm password</label> <!-- password_confirmation to work with laravel -->
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"> 
        </div>
            
        @foreach($errors->all() as $error)
            <p class="error-message">{{ $error }}</p>
        @endforeach
            
        <input type="submit" value="Sign Up" class="btn btn-danger">
        
    </form>

@stop

