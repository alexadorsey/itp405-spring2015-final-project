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
                    <input type="hidden" name="company-id" id="company-id" {{ Request::old('company-id') }}>
                    <input type="text" autocomplete="off" size="30" name="Company" id="company-input"
                        list="company" style="color:black" placeholder="Find your company"
                        onselect="getCompanyValue()" value="{{ Request::old('Company') }}">
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
                        @foreach ($cities as $city)
                            <option value="{{ $city->city }}">
                        @endforeach
                        </datalist>
                </span>
            </p>
                
            <p>State:
                <span class="lead search-text">
                    <input type="hidden" name="state-id" id="state-id">
                    <input type="text" autocomplete="off" size="30" name="State" id="state-input" list="state" style="color:black" placeholder="State of internship">
                        <datalist id="state">
                        @foreach ($states as $state)
                            <option value="{{ $state->name }}">
                        @endforeach
                        </datalist>
                </span>
            </p>
                
            <p>Position:
                <span class="lead search-text">
                    <input type="hidden" name="position-id" id="position-id">
                    <input type="text" autocomplete="off" size="30" name="Position" id="position-input"
                        list="position" style="color:black" placeholder="Position you held"
                        onselect="getPositionValue()">
                        <datalist id="position">
                        @foreach ($positions as $position)
                            <option id="{{ $position->id }}" value="{{ $position->name }}">
                        @endforeach
                        </datalist>
                </span>
            </p>
                
            <p>Start Month:
                <select id="start-month" name="Start_Month" size="1">
                    @include('date.months')
                &nbsp;&nbsp;&nbsp; 
               Start Year:
                <select id="start-year" name="Start_Year">
                    @include('date.years')
            </p>
            
            
            <p>End Month:
                <select id="end-month" name="End_Month" size="1">
                    @include('date.months') 
                &nbsp;&nbsp;&nbsp; 
               End Year:
                <select id="end-year" name="End_Year">
                    @include('date.years')
            </p>
            
            <hr/>
            
            <p>Pros:</p>
            <textarea name="Pros" rows="4" cols="60">{{ Request::old('Pros') }}</textarea>
                
            <p>Cons:</p>
            <textarea name="Cons" rows="4" cols="60">{{ Request::old('Cons') }}</textarea>
                
            <hr/>
            <p>Was the pay good?
                <input type="radio" name="Good_Pay" value="1"> Yes 
                <input type="radio" name="Good_Pay" value="0"> No
            </p>
                
            <p>Were the hours fair?
                <input type="radio" name="Fair_Hours" value="1"> Yes 
                <input type="radio" name="Fair_Hours" value="0"> No
            </p>
                
            <p>Is this company offering you future employment?
                <input type="radio" name="Future_Work" value="1"> Yes 
                <input type="radio" name="Future_Work" value="0"> No
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
