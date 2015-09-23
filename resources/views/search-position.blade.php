@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
	<script type="text/javascript" src="{{ asset('/js/search.js') }}"></script>
@stop

@include('header')

@section('content')
	<div class="inner-body">
		<div id="job-listings">
			<h4>Internship Postings:</h4>
			<p>Powered by CareerBuilder.com</p>
			@if (count($jobs) == 0)
				<span class="job-listings-company">No internships</span>
			@else
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
			@endif
		</div>
		<div id="right-col">
			<div id="top-header">
				<span id="page-header">{{ count($reviews) }}
					@if ( count($reviews) == 1)
						review
					@else
						reviews
					@endif
					@if ($company)
						for '{{ $company->name }}'
					@endif
					@if ($position)
						for '{{ $position->name }}'
					@endif
					@if ($location)
						in '{{ $location->name }}'
					@endif
					@if (!$position && !$location)
						for 'all internships'
					@endif
				</span>
				
				<form id="sort-reviews" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="position-id" id="position-id" value="{{ $position_id }}">
					<input type="hidden" name="City" id="City" value="{{ $location_val }}">
					<input type="hidden" name="order" id="order" value="{{ $order }}">
					@if ($position)
						<input type="hidden" id="position-id" name="position-id" value="{{ $position->id }}">
					@else
						<input type="hidden" id="position-id" name="position-id" value="{{ null }}">
					@endif
					
					@if ($location)
						<input type="hidden" id="location-input" name="location-input" value="{{ $location->name }}">
					@else
						<input type="hidden" id="location-input" name="location-input" value="{{ null }}">
					@endif
					
					<div id="review-sort">	
						<span>Sort by: </span>
						<select id="sort-by-options" onchange="sortReviews(this.value)">
							<script>
								setSortBy('{{ $order }}')
							</script>
						</select>
					</div>
					<button style="visibility: hidden" type="submit">Click me</button>
				</form>
			</div>
			<div class="clear"></div>
		
			<div id="reviews">
				@foreach ($reviews as $review)
					<div class="review">
						<div class="top-review-row">
							@if ($review->company->icon)
							   <img class="company-logo" src="{{ $review->company->icon }}"/>
							@endif
							<a href="{{ url('company/' . $review->company->name) }}"><span class="company-name">{{ $review->company->name }}</span></a>
							<span style="float:right">
								@if ($review->fair_hours == 0)
									<span class="glyphicon glyphicon-time review-icon neg-review-rating"></span>
								@else
									<span class="glyphicon glyphicon-time review-icon title-icon-fair"></span>
								@endif
								
								@if ($review->compensation == 0)
									<span class="glyphicon glyphicon-usd review-icon neg-review-rating"></span>
								@else
									<span class="glyphicon glyphicon-usd review-icon title-icon-pay"></span>
								@endif
								
								@if ($review->future_work == 0)
									<span class="glyphicon glyphicon-briefcase review-icon neg-review-rating"></span>
								@else
									<span class="glyphicon glyphicon-briefcase review-icon title-icon-work"></span>
								@endif
								
								@if ($review->recommend == 0)
									<span class="glyphicon glyphicon-thumbs-up review-icon neg-review-rating"></span>
								@else
									<span class="glyphicon glyphicon-thumbs-up review-icon title-icon-recommend"></span>
								@endif
							</span>
						</div>
						
						<div class="bottom-review">
							<br/>
							<span class="review-title" style="float:left;">{{ $review->position->name }} in {{ $review->city->name }}, {{ $review->state->abbreviation }}</span>
							<span class="post-date">Posted {{ DATE_FORMAT(new DateTime($review->created_at), 'n/j/y') }}</span>
							<div style="clear:both"></div>
							<span class="intern-date">{{ DATE_FORMAT(new DateTime($review->intern_start), 'F Y') }} - {{ DATE_FORMAT(new DateTime($review->intern_end), 'F Y') }}</span>
							<div class="clear"></div>
							<hr class="review-hr"/>
							<table>
								<col class="pros-table-col" width="50%">
								<col class="cons-table-col" width="50%">
								<tr>
									<td class="pro"><span class="pro-text">PROS</span></td>
									<td class="pro"><span class="con-text">CONS</span></td>
									
								</tr>
								<tr>
									<td>{{ $review->pros }}</td>
									<td>{{ $review->cons }}</td>
								</tr>
							</table>
						</div>
					</div>
				@endforeach
			</div>
		</div>	
		<div class="clear"></div>
	</div>
@stop


@section('javascript')
	<script type="text/javascript" src="{{ asset('fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fancyBox/source/jquery.fancybox.pack.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/home.js') }}"></script>
@stop







  