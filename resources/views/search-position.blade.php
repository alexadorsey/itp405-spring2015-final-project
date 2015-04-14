@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
@stop


@section('content')
    <h1>{{ count($reviews) }} results for 'Software Engineer'</h1>
    <div id="review-sort">
        <h4>Sort by:</h4>

        <h6>Date Posted:</h6>
        <input type="radio" class="sort-by" name="sort_by" value="date_posted_newest" checked onclick="sortReviews({{ $position->id }}, 'date_posted_newest')">
            <span class="sort-by-type">Newest to Oldest</span>
        <br/>
        <input type="radio" class="sort-by" name="sort_by" value="date_posted_oldest" onclick="sortReviews({{ $position->id }}, 'date_posted_oldest')">
            <span class="sort-by-type">Oldest to Newest</span>
        <br/><br/>
         <h6>Company Rating:</h6>
        <input type="radio" class="sort-by" name="sort_by" value="company_rating_high" onclick="sortReviews({{ $position->id }}, 'company_rating_high')">
            <span class="sort-by-type">High to Low</span>
        <br/>
        <input type="radio" class="sort-by" name="sort_by" value="company_rating_low" onclick="sortReviews({{ $position->id }}, 'company_rating_low')">
            <span class="sort-by-type">Low to High</span>
        <br/>
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
				<span class="post-date">Posted {{ DATE_FORMAT(new DateTime($review->date_posted), 'n/j/y') }}</span>
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
@stop


@section('javascript')
	<script type="text/javascript" src="{{ asset('fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fancyBox/source/jquery.fancybox.pack.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
@stop







  