@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
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
			<div id="top-header">
				<span id="page-header">{{ count($reviews) }}
				@if ( count($reviews) == 1)
					review
				@else
					reviews
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
				<div id="review-sort">
					<span>Sort by:</span>
					<select>
						<option class="sort-by" name="sort_by" value="date_posted_newest" checked onclick="sortReviews({{ $reviews }}, 'date_posted_newest')">Date Posted: Newest to Oldest</option>
						<option class="sort-by" name="sort_by" value="date_posted_newest" onclick="sortReviews({{ $reviews }}, 'date_posted_oldest')">Date Posted: Oldest to Newest</option>
						<option class="sort-by" name="sort_by" value="company_rating_high" onclick="sortReviews({{ $reviews }}, 'company_rating_high')">Company Rating: High to Low</option>
						<option class="sort-by" name="sort_by" value="company_rating_low" onclick="sortReviews({{ $reviews }}, 'company_rating_low')">Company Rating: Low to High</option>
					</select>
				</div>
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
						<br/>
						<span class="review-title" style="float:left;">{{ $review->position->name }} at {{ $review->city->name }}, {{ $review->state->abbreviation }}</span>
						<span class="post-date">Posted {{ DATE_FORMAT(new DateTime($review->created_at), 'n/j/y') }}</span>
						<div style="clear:both"></div>
						<span class="intern-date">{{ DATE_FORMAT(new DateTime($review->intern_start), 'F Y') }} - {{ DATE_FORMAT(new DateTime($review->intern_end), 'F Y') }}</span>
						<div class="clear"></div>
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
				@endforeach
				<hr/>
			</div>
		</div>	
		<div class="clear"></div>
	</div>
@stop


@section('javascript')
	<script type="text/javascript" src="{{ asset('fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fancyBox/source/jquery.fancybox.pack.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
@stop







  