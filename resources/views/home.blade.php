<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="{{ asset('css/cover.css') }}" type="text/css">
	
</head>
<body>
    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">
		
		<img id="hello-pic" src="{{ asset('img/awesome.png') }}">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">InternshipWatch.com</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="#">Home</a></li>
                  <li><a href="#">Companies</a></li>
				  <li><a href="#">Sign Up</a></li>
				  <li><a href="#">Log In</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">How was that internship?</h1>
            <p class="lead">Search any company below to read reviews on their internships. Fair pair? Good hours? Worth it? Find out!</p>
		  </div>
			

        </div>
			<form method="get" action="/search">
			<div id="search-box">
				<span class="lead search-text">
					<input type="hidden" name="company-id" id="company-id">
					<input type="text" autocomplete="off" size="30" id="company-input" list="company" style="color:black" placeholder="Search by company" onselect="getCompanyValue()">
						<datalist id="company">
						@foreach ($companies as $company)
							<option id="{{ $company->id }}" value="{{ $company->name }}">
						@endforeach
						</datalist>
				</span>
					
				<span class="lead search-text">
					<input type="hidden" name="position-id" id="position-id">
					<input type="text" autocomplete="off" size="30" id="position-input" list="position" style="color:black" placeholder="Search by job position" onselect="getPositionValue()">
						<datalist id="position">
							@foreach ($positions as $position)
								<option id="{{ $position->id }}" value="{{ $position->name }}">
							@endforeach
						</datalist>
				</span>
				
				<span class="lead search-text">
					<input type="hidden" name="location-id" id="location-id">
					<input type="text" autocomplete="off" size="30" id="location-input" list="location" style="color:black" placeholder="Search by location" onselect="getLocationValue()">
						<datalist id="location">
							@foreach ($locations as $location)
								<option id="{{ $location->id }}" value="{{ $location->city }}">
							@endforeach
						</datalist>
				</span>
				<p class="lead search-btn">
					<button type="submit">
							<a href="#" class="btn btn-lg btn-danger">Search</a>    
					</button>
				</p>
			</div>
			</form>
			<footer>
				<p>&copy Alexa Dorsey | USC ITP 405</p>
			</footer>

      </div>

    </div>

	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
</body>
</html>
