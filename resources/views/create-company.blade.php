@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop

@section('content')
    <h1>Create a New Company</h1>
	<hr/>
	@if (Session::has('success'))
        <p class="success-message">{{ Session::get('success') }}</p>
    @endif
        
    @foreach ($errors->all() as $errorMessage)
        <p style="color:red">*{{ $errorMessage }}</p>
    @endforeach
    
    <form id="create-company-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <div class="form-group">
            <label for="name">Company Name:</label>
            <input type="text" id="name" name="name" class="form-control"> 
        </div>
            
        <div class="form-group">
            <label for="icon">Icon URL:</label>
            <input type="text" id="icon" name="icon" class="form-control"> 
        </div>
            
        
        <input class="fancybox-buttons fancy-add" type="submit" value="Add">
        
    </form>
@stop


@section('javascript')
	<script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
@stop
