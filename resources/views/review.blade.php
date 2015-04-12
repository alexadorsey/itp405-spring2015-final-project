@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/review.css') }}" type="text/css">
@endsection


@section('content')
	<p>Review {{ $company->name }}</p>
@endsection			

	
@section('javascript')
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@endsection
