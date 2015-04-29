@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/signup.css') }}" type="text/css">
@stop

@section('content')
    <div class="sign-up-header">
		<h1>Edit City</h1>
	</div>
	@if (Session::has('success'))
        <p class="success-message">{{ Session::get('success') }}</p>
    @endif
	
	<form class="form-horizontal" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="form-group">
            <label for="city-name" class="control-label col-xs-5 input-type">City Name:</label>
            <div class="col-xs-5 input-box">
                <input type="text" class="form-control" id="city-name" name="city-name" value="{{ $city->name }}">
            </div>
        </div>
          
		<input type="submit" value="Edit" class="btn btn-info"> 
    </form>
@stop