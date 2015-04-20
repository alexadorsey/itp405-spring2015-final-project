@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
@stop


@section('content')
	<div class="inner-body">
    <h1>{{ count($reviews) }}
    @if ( count($reviews) == 1)
        review
    @else
        reviews
    @endif
    @if ($position)
        for {{ $position->name }}
    @endif
    @if ($location)
        in {{ $location->name }}
    @endif
    @if (!$position && !$location)
        all internships
    @endif
    </h1>
    <div id="review-sort">
        <span>Sort by:</span>
        <!--<span>Date Posted:</span>-->
		<select>
			<option class="sort-by" name="sort_by" value="date_posted_newest" checked onclick="sortReviews({{ $reviews }}, 'date_posted_newest')">Date Posted: Newest to Oldest</option>
			<option class="sort-by" name="sort_by" value="date_posted_newest" onclick="sortReviews({{ $reviews }}, 'date_posted_oldest')">Date Posted: Oldest to Newest</option>
			<option class="sort-by" name="sort_by" value="company_rating_high" onclick="sortReviews({{ $reviews }}, 'company_rating_high')">Company Rating: High to Low</option>
			<option class="sort-by" name="sort_by" value="company_rating_low" onclick="sortReviews({{ $reviews }}, 'company_rating_low')">Company Rating: Low to High</option>
		</select>
		<!--
		<span>Company Rating:</span>
		<select>
			
		</select>
		
        <input type="radio" class="sort-by" name="sort_by" value="date_posted_newest" checked onclick="sortReviews({{ $reviews }}, 'date_posted_newest')">
            <span class="sort-by-type">Newest to Oldest</span>
        <input type="radio" class="sort-by" name="sort_by" value="date_posted_oldest" onclick="sortReviews({{ $reviews }}, 'date_posted_oldest')">
            <span class="sort-by-type">Oldest to Newest</span>
         <span>Company Rating:</span>
        <input type="radio" class="sort-by" name="sort_by" value="company_rating_high" onclick="sortReviews({{ $reviews }}, 'company_rating_high')">
            <span class="sort-by-type">High to Low</span>
        <input type="radio" class="sort-by" name="sort_by" value="company_rating_low" onclick="sortReviews({{ $reviews }}, 'company_rating_low')">
            <span class="sort-by-type">Low to High</span>
			-->
    </div>
	
	<div id="job-listings">
		<h4>Job Postings:</h4>
		@for ($i = 0; $i<5; $i++)
			<?php $job = $jobs[$i] ?>
			<p><a target="_blank" href="{{ $job->url }}" >{{ $job->title }}</a></p>
		@endfor
	</div>	
	
    <div id="reviews">
        @foreach ($reviews as $review)
				
				<div class="review">
                @if ($review->company->icon)
                   <img class="company-logo" src="{{ $review->company->icon }}"/>
                @endif
                <a href="company/{{ $review->company->name }}"><span class="company-name">{{ $review->company->name }}</span></a><br/>
				<span class="review-title" style="float:left;">{{ $review->position->name }} at {{ $review->city->name }}, {{ $review->state->abbreviation }}</span>
				<span style="float:right">
					@if ($review->recommend == 0)
						<span class="glyphicon glyphicon-thumbs-up review-icon neg-review-rating"></span>
					@else
						<span class="glyphicon glyphicon-thumbs-up review-icon pos-review-rating"></span>
					@endif
					
					@if ($review->fair_hours == 0)
						<span class="glyphicon glyphicon-time review-icon neg-review-rating"></span>
					@else
						<span class="glyphicon glyphicon-time review-icon pos-review-rating"></span>
					@endif
					
					@if ($review->compensation == 0)
						<span class="glyphicon glyphicon-usd review-icon neg-review-rating"></span>
					@else
						<span class="glyphicon glyphicon-usd review-icon pos-review-rating"></span>
					@endif
					
					@if ($review->future_work == 0)
						<span class="glyphicon glyphicon-briefcase review-icon neg-review-rating"></span>
					@else
						<span class="glyphicon glyphicon-briefcase review-icon pos-review-rating"></span>
					@endif
		
				</span>
				<div style="clear:both"></div>
				<span class="intern-date">{{ DATE_FORMAT(new DateTime($review->intern_start), 'F Y') }} - {{ DATE_FORMAT(new DateTime($review->intern_end), 'F Y') }}</span>
				<span class="post-date">Posted {{ DATE_FORMAT(new DateTime($review->created_at), 'n/j/y') }}</span>
				<div class="clear"></div>
				<table>
                    <col width="10%">
                    <col width="95%">
					<tr>
						<td class="pro">Pros:</td>
						<td>{{ $review->pros }}</td>
					</tr>
					<tr>
						<td class="pro">Cons:</td>
						<td>{{ $review->cons }}</td>
					</tr>
                </table>
			</div>
            <hr/>
				
			@endforeach
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







  