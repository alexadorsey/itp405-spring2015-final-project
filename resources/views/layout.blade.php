<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="_token" content="{{ csrf_token() }}" />
	<title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ secure_asset('fancyBox/source/jquery.fancybox.css') }}" type="text/css" media="screen" />
	<link href='https://fonts.googleapis.com/css?family=Hind|Muli' rel='stylesheet' type='text/css'>
	@yield('assets')
	
</head>
<body>
    <div class="site-wrapper">
      <div class="site-wrapper-inner">
          @yield('hello-image')
            
          @yield('content')
          
          <footer>
            <p>&copy Alexa Dorsey | USC ITP 405</p>
          </footer>

      </div>

    </div>

	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ secure_asset('fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('fancyBox/source/jquery.fancybox.pack.js') }}"></script>
	<script type="text/javascript" src="{{ secure_asset('js/layout.js') }}"></script>
	@yield('javascript')
</body>
</html>
