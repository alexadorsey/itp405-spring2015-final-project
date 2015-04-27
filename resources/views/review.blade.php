@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('css/review.css') }}" type="text/css">
@stop

@include('header')

@section('content')
	<div class="inner-body">
        <div id="job-listings">
			<h4>Internship Postings:</h4>
			<p>Powered by CareerBuilder.com</p>
			<?php $index=0; $count = 0 ?>
			@while ($count<7 && $index<count($jobs))
				<?php $job = $jobs[$index] ?>
				@if (!is_array($job["CompanyDetailsURL"]))
					<span class="job-listings-company">{{ $job["Company"] }}</span><br/>
					<span class="job-listings-location">{{ $job["Location"] }}</span><br/>
					<span class="job-listings-job"><a target="_blank" href="{{ $job["CompanyDetailsURL"] }}">{{ $job["JobTitle"] }}</a></span><br/><br/>
					<?php $count++; ?>
				@endif
				<?php $index++; ?>
			@endwhile
		</div>  
          
        <div id="right-col">
			<h1>Write a review for an intership!</h1>
			<hr/>
			
			@foreach ($errors->all() as $errorMessage)
				<p style="color:red">*{{ $errorMessage }}</p> 
			@endforeach
			
			<form class="form-horizontal" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="questions left">
				
					<!-- Company -->
					<div class="form-group">
						<input type="hidden" name="company-id" id="company-id" {{ Request::old('company-id') }}>
						<label for="company-input" class="control-label col-xs-3 input-type">Company:</label>
						<div class="col-xs-8 input-box">
							<input type="text" class="form-control" autocomplete="off" name="Company" id="company-input"
								list="company" style="color:black" placeholder="Company you interned for"
								onselect="getCompanyValue()" value="{{ Request::old('Company') }}">
							<datalist id="company">
							@foreach ($companies as $company)
								<option id="{{ $company->id }}" value="{{ $company->name }}">
							@endforeach
							</datalist>
						</div>
					</div>
						
					<!-- Position -->
					<div class="form-group">
						<input type="hidden" name="position-id" id="position-id" {{ Request::old('position-id') }}>
						<label for="position-input" class="control-label col-xs-3 input-type">Position:</label>
						<div class="col-xs-8 input-box">
							<input type="text" class="form-control" autocomplete="off" name="Position" id="position-input"
								list="position" style="color:black" placeholder="Find your Position"
								onselect="getPositionValue()" value="{{ Request::old('Position') }}">
							<datalist id="position">
							@foreach ($positions as $position)
								<option id="{{ $position->id }}" value="{{ $position->name }}">
							@endforeach
							</datalist>
						</div>
					</div>
						
						
					<!-- Start Date -->
					<div class="form-group">
						<label for="start-month" class="control-label col-xs-3 input-type">Start Month:</label>
						<div class="col-xs-3 input-box">
								<select class="form-control" id="start-month" name="Start_Month" size="1">
								@include('date.months')
						</div>
							
						<label for="start-year" class="control-label col-xs-2 input-type">Year:</label>
						<div class="col-xs-3 input-box">
							<select class="form-control" id="start-year" name="Start_Year">
									@include('date.years')
						</div>
					</div>
					
					<hr/>
					
					<!-- Pros -->
					<div class="form-group">
						<label for="pros" class="control-label col-xs-2 input-type">Pros:</label>
						<div class="col-xs-10 input-box">
							<textarea class="form-control" id="pros" name="Pros" rows="4" cols="50">{{ Request::old('Pros') }}</textarea>
						</div>
					</div>
						
					<hr/>   
				</div>
					
				<div class="questions right">
					<!-- City -->
					<div class="form-group">
						<input type="hidden" name="city-id" id="city-id">
						<label for="city-input" class="control-label col-xs-3 input-type">City:</label>
						<div class="col-xs-8 input-box">
							<input type="text" class="form-control" autocomplete="off" name="City" id="city-input"
								list="city" style="color:black" placeholder="City of internship" value="{{ Request::old('City') }}">
							<datalist id="city">
								@foreach ($cities as $city)
									<option value="{{ $city->name }}">
								@endforeach
							</datalist>
						</div>
					</div>
						
					<!-- State -->
					<div class="form-group">
						<input type="hidden" name="state-id" id="state-id">
						<label for="state-input" class="control-label col-xs-3 input-type">State:</label>
						<div class="col-xs-8 input-box">
							<input type="text" class="form-control" autocomplete="off" name="State" id="state-input"
								list="state" style="color:black" placeholder="State of internship" value="{{ Request::old('State') }}">
							<datalist id="state">
								@foreach ($states as $state)
									<option value="{{ $state->name }}">
								@endforeach
							</datalist>
						</div>
					</div>
						
					<!-- End Date -->
					<div class="form-group">
						<label for="end-month" class="control-label col-xs-3 input-type">End Month:</label>
						<div class="col-xs-3 input-box">
								<select class="form-control" id="end-month" name="End_Month" size="1">
								@include('date.months')
						</div>
						<label for="end-year" class="control-label col-xs-2 input-type">Year:</label>
						<div class="col-xs-3 input-box">
							<select class="form-control" id="end-year" name="End_Year">
									@include('date.years')
						</div>
					</div>
					<hr/>
						
					<!-- Cons -->
					<div class="form-group">
						<label for="cons" class="control-label col-xs-2 input-type">Cons:</label>
						<div class="col-xs-10 input-box">
							<textarea class="form-control" id="cons" name="Cons" rows="4" cols="50">{{ Request::old('Cons') }}</textarea>
						</div>
					</div>
					<hr/>
						
				</div>
				<div style="clear:both"></div>
					
				
				<div class="form-group">
					<label for="good-pay" class="control-label col-xs-6 input-question">Was the pay good?</label>
					<div class="col-xs-6 input-box">
							<input type="radio" id="good-pay" name="Good_Pay" value="1"> Yes 
							<input type="radio" id="good-pay" name="Good_Pay" value="0"> No
					</div>
				</div>
					
				<div class="form-group">
					<label for="fair-hours" class="control-label col-xs-6 input-question">Were the hours fair?</label>
					<div class="col-xs-6 input-box">
							<input type="radio" id="fair-hours" name="Fair_Hours" value="1"> Yes 
							<input type="radio" id="fair-hours" name="Fair_Hours" value="0"> No
					</div>
				</div>
					
				<div class="form-group">
					<label for="future-work" class="control-label col-xs-6 input-question">Is this company offering you future employment?</label>
					<div class="col-xs-6 input-box">
							<input type="radio" id="future-work" name="Future_Work" value="1"> Yes 
							<input type="radio" id="future-work" name="Future_Work" value="0"> No
					</div>
				</div>
				
				<div class="form-group">
					<label for="recommend" class="control-label col-xs-6 input-question">Would you recommend this internship?</label>
					<div class="col-xs-6 input-box">
							<input type="radio" id="recommend" name="Recommend" value="1"> Yes 
							<input type="radio" id="recommend" name="Recommend" value="0"> No
					</div>
				</div>	
				
				<br/>
				<button type="submit" class="btn btn-small btn-info">Submit</button> 
			</form>
		</div>
	</div>
@stop		

	
@section('javascript')
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@stop
