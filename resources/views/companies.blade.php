@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/companies.css') }}" type="text/css">
@stop


@section('content')
	<div class="inner-body">
    <h1>{{ count($companies) }}
    @if ( count($companies) == 1)
        company
    @else
        companies
    @endif
    </h1>
    <div id="company-sort">
        <input type="hidden">
        <h4>Sort by:</h4>
        <h6>Number of Reviews:</h6>
        <input type="radio" class="sort-by" name="sort_by" value="date_posted_newest" checked onclick="sortReviews({{ $companies }}, 'date_posted_newest')">
            <span class="sort-by-type">Newest to Oldest</span>
        <br/>
        <input type="radio" class="sort-by" name="sort_by" value="date_posted_oldest" onclick="sortReviews({{ $companies }}, 'date_posted_oldest')">
            <span class="sort-by-type">Oldest to Newest</span>
        <br/><br/>
         <h6>Company Rating:</h6>
        <input type="radio" class="sort-by" name="sort_by" value="company_rating_high" onclick="sortReviews({{ $companies }}, 'company_rating_high')">
            <span class="sort-by-type">High to Low</span>
        <br/>
        <input type="radio" class="sort-by" name="sort_by" value="company_rating_low" onclick="sortReviews({{ $companies }}, 'company_rating_low')">
            <span class="sort-by-type">Low to High</span>
        <br/>
    </div>
    <div id="companies">
        @foreach ($companies as $company)
			<div class="company-box">
                @if ($company->icon)
                   <img class="company-logo" src="{{ $company->icon }}"/>
                @endif
                <a href="company/{{ $company->name }}"><span class="company-name">{{ $company->name }}</span></a><br/>
                <p>Number of reviews: {{ count($company->reviews()->where("approved", "=", 1)->get()) }}</p>
                <p>Positions: 
					@if (count($company->positions()->get()) == 0)
						--
					@else
						@foreach($company->positions()->take(5)->get() as $position)
							{{ $position->name }}
						@endforeach
					@endif
                </p>
                @if (count($company->reviews()->where("approved", "=", 1)->get()) == 0)
                    <span class="glyphicon glyphicon-thumbs-up rating-icon"></span><span class="rating">No reviews yet.</span>
                @else
                    <span class="glyphicon glyphicon-thumbs-up rating-icon"></span><span class="rating">{{ $company->recommend_percent() }}% Recommend</span>
                @endif
				<table>
                    <col width="10%">
                    <col width="95%">
					<tr>
						<td class="pro">Pros:</td>
						<td>Stuff about the company</td>
					</tr>
					<tr>
						<td class="pro">Cons:</td>
						<td>More stuff</td>
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
    <script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
@stop







  