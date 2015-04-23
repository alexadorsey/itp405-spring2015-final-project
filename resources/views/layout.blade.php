<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="_token" content="{{ csrf_token() }}" />
	<title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Hind|Muli' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{ asset('css/cover.css') }}" type="text/css">
	@yield('assets')
	
</head>
<body>
    <div class="site-wrapper">
      <div class="site-wrapper-inner">
        <div class="cover-container">
          @yield('hello-image')

          <div class="masthead clearfix">
            <div class="inner">
			
              <h3 class="masthead-brand">InternshipWatch.com</h3>
              <nav>
                <ul class="nav masthead-nav">
				@if ($title == 'Home')
					<li class="active"><a href="{{ url('home') }}">Home</a></li>
				@else
					<li><a href="{{ url('home') }}">Home</a></li>
				@endif
				
				@if ($title == 'Companies')
					<li class="active"><a href="{{ url('companies') }}">Companies</a></li>
				@else
					<li><a href="{{ url('companies') }}">Companies</a></li>
				@endif
				
				@if (Auth::check())
					@if ($title == 'Dashboard' || $title == 'Admin Dashboard')
						<li class="active"><a href="{{ url('dashboard') }}">Dashboard</a></li>
					@else
						<li><a href="{{ url('dashboard') }}">Dashboard</a></li>
					@endif
					<li><a href="{{ url('logout') }}">Logout</a></li>
				@else
					@if ($title == 'Sign Up')
						<li class="active"><a href="{{ url('signup') }}">Sign Up</a></li>
					@else
						<li><a href="{{ url('signup') }}">Sign Up</a></li>
					@endif
					
					@if ($title == 'Login')
						<li class="active"><a href="{{ url('login') }}">Login</a></li>
					@else
						<li><a href="{{ url('login') }}">Login</a></li>
					@endif
				@endif
                </ul>
              </nav>
            </div>
          </div>
        </div>
            
          @yield('content')
        
          
          <footer>
            <p>&copy Alexa Dorsey | USC ITP 405</p>
          </footer>

      </div>

    </div>

	<!-- Scripts -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	@yield('javascript')
</body>
</html>
