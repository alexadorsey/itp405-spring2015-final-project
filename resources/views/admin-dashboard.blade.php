@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" type="text/css">
@stop


@section('content')
    <h1>Welcome Admin {{ $user->first_name }}!</h1>
        
    @if (Session::has('success'))
        <p class="success-message">{{ Session::get('success') }}</p>
    @endif
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
            <a href="#" onclick="editCompany('{{ url("dashboard/edit-company") }}'); return false;" class="btn btn-sm btn-danger">Edit</a>
            <br/>
            <a href="#" onclick="confirmDeleteCompany('{{ url("dashboard/delete-company") }}'); return false;" class="btn btn-sm btn-danger">Delete</a>
            <br/>
            <a href="{{ url('dashboard/create-company') }}" class="btn btn-sm btn-danger">Create New</a>    
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
                 <a href="#" class="btn btn-sm btn-danger">Edit</a>
                <br/>
                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                <br/>
                <a href="#" class="btn btn-sm btn-danger">Create New</a> 
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
                 <a href="#" class="btn btn-sm btn-danger">Edit</a>
                <br/>
                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                <br/>
                <a href="#" class="btn btn-sm btn-danger">Create New</a> 
        </div>
        </div>   
          
        <div id="reviews">
            <h3>Reviews Awaiting Approval</h3>
            @foreach ($reviews as $review)
                    
                <div class="review" id="review-{{ $review->id }}">
                    @if ($review->company->icon)
                       <img class="company-logo" src="{{ $review->company->icon }}"/>
                    @endif
                    <a href="company/{{ $review->company->name }}"><span class="company-name">{{ $review->company->name }}</span></a>
                    <a href="#" class="btn btn-sm btn-success delete" onclick="reviewReview('{{ url('dashboard/approve-review') }}', {{ $review->id }}); return false;"><span class="glyphicon glyphicon-ok"></span></a>    
                    <a href="#" class="btn btn-sm btn-danger delete" onclick="reviewReview('{{ url('dashboard/disapprove-review') }}', {{ $review->id }}); return false;"><span class="glyphicon glyphicon-remove"></span></a>
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
                <hr/>
                </div>
                
                    
                @endforeach
        </div>
        <div class="clear"></div>
    </div>
    
    <br/>
    <a href="{{ url('logout') }}">Logout</a>
        
@endsection			

	
@section('javascript')
    <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
@endsection
