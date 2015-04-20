@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" type="text/css">
@stop


@section('content')
    <h1>Welcome {{ $user->first_name }}!</h1>
    
    <div id="review-sort">
        @if (count($reviews) == 0)
            <span id="num-reviews">No internship reviews yet.</span>
        @elseif (count($reviews) == 1))
            <span id="num-reviews">{{ count($reviews) }} internship review</span>
        @else
            <span id="num-reviews">{{ count($reviews) }} internship reviews</span>
        @endif
        
    </div>
         
    <div id="reviews">
        @foreach ($reviews as $review)
				
			<div class="review">
                @if ($review->company->icon)
                   <img class="company-logo" src="{{ $review->company->icon }}"/>
                @endif
                <a href="company/{{ $review->company->name }}"><span class="company-name">{{ $review->company->name }}</span></a>
                <a href="#" class="btn btn-sm btn-danger delete" onclick="confirmDelete('{{ url('dashboard/deleteReview/' . $review->id) }}'); return false;"><span class="glyphicon glyphicon-remove"></span></a>    
                <br/>
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
    
    <br/>
    <a href="{{ url('logout') }}">Logout</a>
        
@endsection			

	
@section('javascript')
    <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
@endsection
