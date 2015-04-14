@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/company-page.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fancyBox/source/jquery.fancybox.css') }}" type="text/css" media="screen" />
@stop


@section('content')
	<form method="get" action="review">
		
		<div id="review-btn">
			<button type="submit">
				<a href="#" class="btn btn-small btn-danger"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Review</a>    
			</button>
		</div>
	</form>
	
	
	<div id="company-header">
		<h1 id="company-title">{{ $company->name }}
		<img id="company-logo" src="{{ $company->icon }}"/>
		</h1>
		<div class="clear"></div>
		<a href="http://www.google.com/about/careers">{{ $company->job_site }}</a>
	</div>


	<div class="inner-body">
		<hr/>
		<div id="company-stats">
			<div id="stats">
				<p><span class="glyphicon glyphicon-thumbs-up" id="title-recommend-icon"></span></span><span id="title-recommend">{{ $recommend_rating }}% Recommend</span></p>
				<hr style="width: 20%"/>
				<p><span class="glyphicon glyphicon-time title-icon"></span><span class="title-text">{{ $fair_hours_rating }}% say Fair Hours</span></p>
				<p><span class="glyphicon glyphicon-usd title-icon"></span></span><span class="title-text">{{ $compensation_rating }}% say Good Pay</span></p>
				<p><span class="glyphicon glyphicon-briefcase title-icon"></span></span><span class="title-text">{{ $future_work_rating }}% say Future Work</span></p>
				<hr style="width: 20%"/>
			</div>
				
			<div id="images">
			@for ($i = 0; $i < count($images); $i++)
				@if ($i % 2 == 0)
					<div class="img-box img-left">
				@else
					<div class="img-box img-right">
				@endif
				<a class="fancybox rel="group" href="{{ $images[$i]->src }}">
					<img class="company-img" src="{{ $images[$i]->src }}" alt=""/></a>
				</div>
				
			@endfor
			</div>	
		</div>
	
		<div id="reviews">
			@foreach ($reviews as $review)
				<div class="review">
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
				
			@endforeach
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







  