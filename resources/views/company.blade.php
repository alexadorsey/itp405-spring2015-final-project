@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('css/company-page.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fancyBox/source/jquery.fancybox.css') }}" type="text/css" media="screen" />
@stop

@include('header')

@section('content')
	<div class="inner-body">
		<div id="job-listings">
			<h4>Internship Postings:</h4>
			<p>Powered by CareerBuilder.com</p>
			@if (count($jobs) == 0)
				<span style="color: orange">No internships for this company found.</span>
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
			<div id="company-header">
				<h1 id="company-title"><img id="company-logo" src="{{ $company->icon }}"/>{{ $company->name }}</h1>
				<div class="clear"></div>
			</div>
			<div id="company-stats">
				<div id="stats">
					@if (count($reviews) == 0)
						<span class="glyphicon glyphicon-thumbs-up title-icon title-icon-recommend"></span>--% Recommend
						<span class="glyphicon glyphicon-time title-icon title-icon-fair"></span>--% say Fair Hours
						<span class="glyphicon glyphicon-usd title-icon title-icon-pay"></span>--% say Good Pay
						<span class="glyphicon glyphicon-briefcase title-icon title-icon-work"></span>--% say Future Work
					@else
						<span class="glyphicon glyphicon-thumbs-up title-icon title-icon-recommend"></span>{{ $recommend_rating }}% Recommend
						<span class="glyphicon glyphicon-time title-icon title-icon-fair"></span>{{ $fair_hours_rating }}% say Fair Hours
						<span class="glyphicon glyphicon-usd title-icon title-icon-pay"></span>{{ $compensation_rating }}% say Good Pay
						<span class="glyphicon glyphicon-briefcase title-icon title-icon-work"></span>{{ $future_work_rating }}% say Future Work
					@endif
				</div>
			</div>	
	
			<div id="reviews">
				<br/>
				@if (count($reviews) == 0)
					<h5>No reviews.</h5>
				@else
					@if (count($reviews) == 1)
						<span id="review-count">{{ count($reviews) }} review</span>
					@else
						<span id="review-count">{{ count($reviews) }} reviews</span>
					@endif
					<hr/>
					<br/>
					@foreach ($reviews as $review)
					<div class="review">
						<div class="top-review-row">
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
									<span class="glyphicon glyphicon-briefcase review-icon neg-review-rating future_work_icon"></span>
								@else
									<span class="glyphicon glyphicon-briefcase review-icon title-icon-work future_work_icon"></span>
								@endif
								
								@if ($review->recommend == 0)
									<span class="glyphicon glyphicon-thumbs-up review-icon neg-review-rating"></span>
								@else
									<span class="glyphicon glyphicon-thumbs-up review-icon title-icon-recommend"></span>
								@endif
							</span>
						</div>
						<br/>
						<span class="review-title" style="float:left;">{{ $review->position->name }} at {{ $review->city->name }}, {{ $review->state->abbreviation }}</span>						<div style="clear:both"></div>
						<span class="intern-date">{{ DATE_FORMAT(new DateTime($review->intern_start), 'F Y') }} - {{ DATE_FORMAT(new DateTime($review->intern_end), 'F Y') }}</span>
						<span class="post-date">Posted {{ DATE_FORMAT(new DateTime($review->created_at), 'n/j/y') }}</span>
						<div class="clear"></div>
						<hr/>
						<br/>
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
						<br/>
					</div>
					@endforeach
				@endif	
			</div>
		</div>
		<div class="clear"></div>
	</div>
@stop


@section('javascript')
	<script type="text/javascript" src="{{ asset('fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fancyBox/source/jquery.fancybox.pack.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/company-page.js') }}"></script>
@stop







  