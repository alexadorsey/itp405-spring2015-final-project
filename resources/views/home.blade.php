@extends('layout')

@section('hello-image')	
	<img id="hello-pic" src="{{ asset('img/awesome.png') }}">
@stop


@section('content')
	<div class="inner cover">
		<h1 class="cover-heading">How was that internship?</h1>
		<p class="lead">Search any company below to read reviews on their internships.<br/>
		Fair pair? Good hours? Worth it? Find out!</p>
	</div>
		
		
	<form method="get" action="/search">
		<div id="search-box">
			<span class="lead search-text">
				<input type="hidden" name="company-id" id="company-id">
				<input type="text" autocomplete="off" size="30" id="company-input" list="company" style="color:black" placeholder="Search by company" onselect="getCompanyValue()">
					<datalist id="company">
					@foreach ($companies as $company)
						<option id="{{ $company->id }}" value="{{ $company->name }}">
					@endforeach
					</datalist>
			</span>
				
			<span class="lead search-text">
				<input type="hidden" name="position-id" id="position-id">
				<input type="text" autocomplete="off" size="30" id="position-input" list="position" style="color:black" placeholder="Search by job position" onselect="getPositionValue()">
					<datalist id="position">
						@foreach ($positions as $position)
							<option id="{{ $position->id }}" value="{{ $position->name }}">
						@endforeach
					</datalist>
			</span>
			
			<span class="lead search-text">
				<input type="text" autocomplete="off" size="30" name="location-input" id="location-input" list="location" style="color:black" placeholder="Search by location">
					<datalist id="location">
						@foreach ($cities as $city)
                            <option value="{{ $city->name }}">
                        @endforeach
						@foreach ($states as $state)
                            <option value="{{ $state->name }}">
                        @endforeach
					</datalist>
			</span>
			<p class="lead search-btn">
				<button type="submit">
						<a href="#" class="btn btn-lg btn-danger">Search</a>    
				</button>
			</p>
		</div>
	</form>
@stop			

	
@section('javascript')
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@stop
