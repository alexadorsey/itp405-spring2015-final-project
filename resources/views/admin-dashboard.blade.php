@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" type="text/css">
@stop

@include('header')

@section('content')
    <div class="inner-body">
        <div id="create-edit-box">
            <div class="create-div">
                <h4>Companies</h4>
                <div class="form-group">
                    <select id="company-id" name="company-id" required>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <span class="edit-button" onclick="editCompany('{{ url("dashboard/edit-company") }}'); return false;">Edit</span>
                <span class="edit-button" onclick="confirmDeleteCompany('{{ url("dashboard/delete-company") }}'); return false;">Delete</span>
                <a class="edit-button" data-fancybox-type="iframe" id="create-company" href="{{ url('dashboard/create-company') }}">New</a>
            </div>
            <hr/>
            <div class="create-div">
                <h4>Positions</h4>
                    <div class="form-group">
                        <select id="position-id" name="position-id" required>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="edit-button" onclick="editPosition('{{ url("dashboard/edit-position") }}'); return false;">Edit</span>
                    <span class="edit-button" onclick="confirmDeletePosition('{{ url("dashboard/delete-position") }}'); return false;">Delete</span>
                    <a class="edit-button" data-fancybox-type="iframe" id="create-position" href="{{ url('dashboard/create-position') }}">New</a>
            </div>
            <hr/>
            <div class="create-div">
                <h4>Cities</h4>
                    <div class="form-group">
                        <select id="city-id" name="city-id" required>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="edit-button" onclick="editCity('{{ url("dashboard/edit-city") }}'); return false;">Edit</span>
                    <span class="edit-button" onclick="confirmDeleteCity('{{ url("dashboard/delete-city") }}'); return false;">Delete</span>
                    <a class="edit-button" data-fancybox-type="iframe" id="create-city" href="{{ url('dashboard/create-city') }}">New</a>
            </div>
        </div>   
          
        <div id="right-col">
            <div id="company-header">
				<h1 id="company-title">Welcome Admin {{ $user->first_name }}!</h1>
                <h4>{{ count($reviews) }} Reviews Awaiting Approval</h4>
				<div class="clear"></div>
			</div>
            <div id="reviews">
				@foreach ($reviews as $review)
					<div class="review" id="review-{{ $review->id }}">
						<div class="top-review-row">
							@if ($review->company->icon)
							   <img class="company-logo" src="{{ $review->company->icon }}"/>
							@endif
							<a href="{{ url('company/' . $review->company->name) }}"><span class="company-name">{{ $review->company->name }}</span></a>
							<span class="approve-icons">
                                <span class="glyphicon glyphicon-ok review-icon delete review-ok" onclick="reviewReview('{{ url('dashboard/approve-review') }}', {{ $review->id }}); return false;"></span>
                                <span class="glyphicon glyphicon-remove review-icon delete review-remove" onclick="reviewReview('{{ url('dashboard/disapprove-review') }}', {{ $review->id }}); return false;"></span>
                            </span>
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
				<hr/>
			</div>
        </div>
        <div class="clear"></div>
    </div>
@endsection			

	
@section('javascript')
    <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
@endsection
