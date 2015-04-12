@extends('layout')


@section('content')
    <h1>Dashboard</h1>
        
    <p>Welcome, {{ Auth::user()->first_name }}</p>  
    
    <br/>
    <a href="{{ url('logout') }}">Logout</a>
        
@endsection			

	
@section('javascript')
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@endsection
