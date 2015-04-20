@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop

@section('content')
    <h1>Edit Company</h1>
    
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
          
          
        <a href="/dashboard/" class="btn btn-danger edit-button">Cancel</a>
        <input type="submit" value="Edit" class="btn btn-danger edit-button">

        
    </form>
@stop