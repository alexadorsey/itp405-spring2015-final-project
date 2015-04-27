@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop

@section('content')
    <h1>Edit Company</h1>
    <hr/>
	@if (Session::has('success'))
        <p class="success-message">{{ Session::get('success') }}</p>
    @endif
	
    <form method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <div class="form-group">
            <label for="company-name">Company Name:</label>
            <br/>
            <input type="text" id="company-name" name="company-name" class="form-control" value="{{ $company->name }}">
        </div>
            
        
        <div class="form-group">
            <label for="icon">Icon URL:</label>
            <input type="text" id="icon" name="icon" class="form-control" value="{{ $company->icon }}"> 
        </div>
          
          
		<input class="fancybox-buttons fancy-add" type="submit" value="Edit">

        
    </form>
@stop