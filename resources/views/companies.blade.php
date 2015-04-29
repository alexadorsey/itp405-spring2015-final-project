@extends('layout')

@section('assets')
	<link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/companies.css') }}" type="text/css">
	<script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
@stop

@include('header');

@section('content')
<div class="inner-body">
	<div id="job-listings">
		<h4>Internship Postings:</h4>
		<p>Powered by CareerBuilder.com</p>
		@if (count($jobs) == 0)
			<span style="color: orange">No internships found.</span>
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
			<span id="page-header">{{ count($companies) }}
				@if ( count($companies) == 1)
					company
				@else
					companies
				@endif
			</span>
			
			<form id="sort-reviews" method="get">
				<input type="hidden" name="order" id="order" value="{{ $order }}">	
				<div id="review-sort">	
					<span>Sort by:</span>
					<select id="sort-by-options">
						<script>
							setSortByCompanies('{{ $order }}')
						</script>
					</select>
				</div>
			</form>
		</div>
		<div class="clear"></div>
		<div id="companies">
			<?php $i = 0; ?>
			@foreach ($companies as $company)
				@if ($i % 3 == 0)
					<div class="row-container">
					<?php $end_i = $i+3 ?>
				@endif
				<div class="company-box">
				
					<!-- Header -->
					<div class="company-header">
						@if ($company->icon)
						   <img class="company-logo" src="{{ $company->icon }}"/>
						@endif
						<a href="company/{{ $company->name }}"><span class="company-name">{{ $company->name }}</span></a>
					</div>
						
					<!-- Stats -->
					<div class="recommend">
						@if (count($company->reviews()->where("approved", "=", 1)->get()) == 0)
							<span class="glyphicon glyphicon-thumbs-up rating-icon title-icon title-icon-none"></span><span class="rating">--% Recommend</span>
						@else
							<span class="glyphicon glyphicon-thumbs-up rating-icon title-icon title-icon-recommend"></span><span class="rating">{{ $company->recommend_percent() }}% Recommend</span>
						@endif
					</div>
					<!-- Num Reviews -->
					<div class="num-reviews">
						<?php $num_reviews = count($company->reviews()->where("approved", "=", 1)->get()) ?>
						@if ($num_reviews == 0)
							<span class="num-review">No reviews</span>
						@elseif ($num_reviews == 1)
							<span class="num-review">1 review</span>
						@else
							<span class="num-review">{{ $num_reviews }} reviews</span>
						@endif
					</div>
						
					<!-- Positions -->
					<div class="positions">
					<br/>
					@if (count($company->positions()->get()) > 0)
						@foreach($company->positions()->take(5)->get() as $position)
							<span class="position">{{ $position->name }}</span>
						@endforeach
					@else
						<span class="position">No positions</span>
					@endif
					</div>

					<!-- Locations -->
					<div class="locations">
					@if (count($company->cities()->get()) > 0)
						@foreach($company->cities()->take(5)->get() as $location)
							<span class="location">{{ $location->name }}</span>
						@endforeach
					@else
						<span class="location">No locations</span>
					@endif
					</div>			
				</div>
				@if ($i == $end_i-1 || $i == count($companies)-1)
					</div>
					<div style="clear:both"></div>
				@endif
				<?php $i++ ?>
			@endforeach
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







  