<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="_token" content="{{ csrf_token() }}" />
	<title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
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
					<li class="active"><a href="home">Home</a></li>
				@else
					<li><a href="home">Home</a></li>
				@endif
				
				@if ($title == 'Companies')
					<li class="active"><a href="#">Companies</a></li>
				@else
					<li><a href="#">Companies</a></li>
				@endif
				
				@if (Auth::check())
					@if ($title == 'Dashboard')
						<li class="active"><a href="dashboard"> Welcome, {{ Auth::user()->first_name }}</a></li>
					@else
						<li><a href="dashboard"> Welcome, {{ Auth::user()->first_name }}</a></li>
					@endif
				@else
					@if ($title == 'Sign Up')
						<li class="active"><a href="signup">Sign Up</a></li>
					@else
						<li><a href="signup">Sign Up</a></li>
					@endif
					
					@if ($title == 'Login')
						<li class="active"><a href="login">Login</a></li>
					@else
						<li><a href="login">Login</a></li>
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	@yield('javascript')
</body>
</html>
