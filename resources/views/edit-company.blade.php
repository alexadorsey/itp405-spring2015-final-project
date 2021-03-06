@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop

@section('content')
    <div class="sign-up-header">
		<h1>Edit Company</h1>
	</div>
	@if (Session::has('success'))
        <p class="success-message">{{ Session::get('success') }}</p>
    @endif
	
	<form class="form-horizontal" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="form-group">
            <label for="company-name" class="control-label col-xs-5 input-type">Company Name:</label>
            <div class="col-xs-5 input-box">
                <input type="text" class="form-control" id="company-name" name="company-name" value="{{ $company->name }}">
            </div>
        </div>
			
		<div class="form-group">
            <label for="icon" class="control-label col-xs-5 input-type">Icon URL:</label>
            <div class="col-xs-5 input-box">
                <input type="text" class="form-control" id="icon" name="icon" value="{{ $company->icon }}">
            </div>
        </div>
          
		<input type="submit" value="Edit" class="btn btn-info"> 
    </form>
@stop