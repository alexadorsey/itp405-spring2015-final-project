@extends('layout')


@section('content')
    <h1>Dashboard</h1>
        
    Welcome, {{ Auth::user()->first_name }}    
    
    <br/>
    <a href="{{ url('logout') }}">Logout</a>
        
@endsection			

	
@section('javascript')
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@endsection
