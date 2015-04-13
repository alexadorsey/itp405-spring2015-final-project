@extends('layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/search-position.css') }}" type="text/css">
@stop


@section('content')
    <h1>{{ count($companies) }} results for 'Software Engineer'</h1>
    
    <div id="company-results">
        <table>
        <col width="10%">
        <col width="90%">
        @foreach ($companies as $company)
            <tr>
                <td>
                @if ($company->icon)
                    <img class="company-logo" src="{{ $company->icon }}"/>
                @endif
                </td>
                <td>
                    <p class="company-name">{{ $company->name }}</p>
                    <p><span class="glyphicon glyphicon-thumbs-up" class="recommend"></span><span class="title-recommend">{{ $company->recommend_percent() }}% Recommend</span></p>
                    <?php $reviews = $company->reviews()->get()?>
                    <p>{{ count($reviews) }} review(s)</p>
                </td>
                    

            </tr>
        @endforeach
        </table>
    </div>

@stop


@section('javascript')
	<script type="text/javascript" src="{{ asset('fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fancyBox/source/jquery.fancybox.pack.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@stop







  