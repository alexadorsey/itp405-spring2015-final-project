@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/review.css') }}" type="text/css">
@stop


@section('content')
	<h1>Write a review for an intership!</h1>
    
    <form method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div id="questions">
            @foreach ($errors->all() as $errorMessage)
                <p style="color:red">*{{ $errorMessage }}</p>
            @endforeach
            <p>Company:
                <span class="lead search-text">
                    <input type="hidden" name="company-id" id="company-id">
                    <input type="text" autocomplete="off" size="30" name="Company" id="company-input" list="company" style="color:black" placeholder="Find your company" onselect="getCompanyValue()">
                        <datalist id="company">
                        @foreach ($companies as $company)
                            <option id="{{ $company->id }}" value="{{ $company->name }}">
                        @endforeach
                        </datalist>
                </span>
            </p>
                
            <p>City:
                <span class="lead search-text">
                    <input type="hidden" name="city-id" id="city-id">
                    <input type="text" autocomplete="off" size="30" name="City" id="city-input" list="city" style="color:black" placeholder="City of internship">
                        <datalist id="city">
                        @foreach ($locations as $location)
                            <option value="{{ $location->city }}">
                        @endforeach
                        </datalist>
                </span>
            </p>
                
            <p>State:
                <span class="lead search-text">
                    <input type="hidden" name="state-id" id="state-id">
                    <input type="text" autocomplete="off" size="30" name="State" id="state-input" list="state" style="color:black" placeholder="State of internship">
                        <datalist id="state">
                        @foreach ($locations as $location)
                            <option value="{{ $location->state }}">
                        @endforeach
                        </datalist>
                </span>
            </p>
                
            <p>Position:
                <span class="lead search-text">
                    <input type="hidden" name="position-id" id="position-id">
                    <input type="text" autocomplete="off" size="30" name="Position" id="position-input" list="position" style="color:black" placeholder="Position you held" onselect="getPositionValue()">
                        <datalist id="position">
                        @foreach ($positions as $position)
                            <option value="{{ $position->name }}">
                        @endforeach
                        </datalist>
                </span>
            </p>
                
            <p>Start Month:
                <select name="month" id="start-month" name="Start Month" size="1">
                    @include('date.months')
                &nbsp;&nbsp;&nbsp; 
               Start Year:
                <select id="start-year" name="Start Year">
                    @include('date.years')
            </p>
            
            
            <p>End Month:
                <select name="month" id="end-month" name="End Month" size="1">
                    @include('date.months') 
                &nbsp;&nbsp;&nbsp; 
               End Year:
                <select id="end-year" name="End Year">
                    @include('date.years')
            </p>
            
            <hr/>
            
            <p>Pros:</p>
            <textarea name="Pros" rows="4" cols="60"></textarea>
                
            <p>Cons:</p>
            <textarea name="Cons" rows="4" cols="60"></textarea>
                
            <hr/>
            <p>Was the pay good?
                <input type="radio" name="Good Pay" value="1"> Yes 
                <input type="radio" name="Good Pay" value="0"> No
            </p>
                
            <p>Were the hours fair?
                <input type="radio" name="Fair Hours" value="1"> Yes 
                <input type="radio" name="Fair Hours" value="0"> No
            </p>
                
            <p>Is this company offering you future employment?
                <input type="radio" name="Future Work" value="1"> Yes 
                <input type="radio" name="Future Work" value="0"> No
            </p>
                
                
            <p>Would you recommend this internship?
                <input type="radio" name="Recommend" value="1"> Yes 
                <input type="radio" name="Recommend" value="0"> No
            </p>
            
            <br/>
            <button type="submit">
				<a href="#" class="btn btn-small btn-danger"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Submit</a>    
			</button>    
        </div>
    </form>
@stop		

	
@section('javascript')
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@stop
