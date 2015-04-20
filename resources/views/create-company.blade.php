@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop

@section('content')
    <h1>Create a New Company</h1>
        
    @foreach ($errors->all() as $errorMessage)
        <p style="color:red">*{{ $errorMessage }}</p>
    @endforeach
    
    <form method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <div class="form-group">
            <label for="name">Company Name:</label>
            <input type="text" id="name" name="name" class="form-control"> 
        </div>
            
        <div class="form-group">
            <label for="icon">Icon URL:</label>
            <input type="text" id="icon" name="icon" class="form-control"> 
        </div>
            
        
        <a href="/dashboard/" class="btn btn-danger edit-button">Cancel</a>
        <input type="submit" value="Add" class="btn btn-danger edit-button">
        
    </form>
@stop