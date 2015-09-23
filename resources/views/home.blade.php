@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/home.css') }}" type="text/css">
@stop

@include('header')

@section('content')
	<script type="text/javascript">
		if (window.location.href == "http://itp405-final-project.herokuapp.com/home") {
			window.location.replace("http://alexadorsey.com/websites/itp405-spring2015-final-project/public/");
		}	
	</script>
	<div class="inner cover">
		<h1 class="cover-heading">How was that internship?</h1>
		<p class="lead">Search below to read reviews on internships.<br/>
		Fair pair? Good hours? Worth it? Find out!</p>
	</div>
		
	<br/>	
	<form method="post" action="search">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="order" id="order" value="date_posted_newest">
		<div id="search-box">
		
			<!-- Company -->
			<div class="search-group">
				<div class="form-group">
				<label for="company-input">Company:</label>
				<input type="hidden" name="company-id" id="company-id">
				<input type="text" class="form-control" autocomplete="off" name="Company" id="company-input"
						list="company" placeholder="Microsoft, Bloomberg..."
						onchange="getCompanyValue()">
					<datalist id="company">
					@foreach ($companies as $company)
						<option id="{{ $company->id }}" value="{{ strtolower($company->name) }}">
					@endforeach
					</datalist>
				</div>
			</div>
				
			<!-- Position -->
			<div class="search-group">
				<div class="form-group">
				<label for="position-input">Position:</label>
				<input type="hidden" name="position-id" id="position-id">
				<input type="text" class="form-control" autocomplete="off" name="Position" id="position-input"
						list="position" placeholder="Software Engineer, Accountant..."
						onchange="getPositionValue()">
					<datalist id="position">
					@foreach ($positions as $position)
						<option id="{{ $position->id }}" value="{{ strtolower($position->name) }}">
					@endforeach
					</datalist>
				</div>
			</div>
				
			<div class="search-group">
				<div class="form-group">
					<input type="hidden" name="city-id" id="city-id">
					<label for="city-input" class="control-label input-type">City:</label>
					<div class="input-box">
						<input type="text" class="form-control" autocomplete="off" name="City" id="city-input"
							list="city" placeholder="Mountain View, New York...">
						<datalist id="city">
							@foreach ($cities as $city)
								<option value="{{ strtolower($city->name) }}">
							@endforeach
						</datalist>
					</div>
				</div>
			</div>
			
			<div style="clear:both"></div>	
				
			<button type="submit" class="btn lead search-btn btn-lg btn-info">Search</button>
		</div>
	</form>
@stop			

	
@section('javascript')
	<script type="text/javascript" src="{{ asset('/js/home.js') }}"></script>
@stop
