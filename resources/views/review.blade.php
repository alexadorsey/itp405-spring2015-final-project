@extends('layout')


@section('content')
	<p>Review {{ $company->name }}</p>
@endsection			

	
@section('javascript')
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@endsection
