<div class="cover-container">
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
          
          @if ($title == 'Review')
              <li class="active"><a href="{{ url('review') }}">Review</a></li>
          @else
                @if (!Auth::check())
                    <li><a id="login-header" data-fancybox-type="iframe" href="{{ url('login') }}">Review</a></li>
                @else
                    <li><a href="{{ url('review') }}">Review</a></li>
                @endif
              
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
                  <li class="active"><a id="sign-up-header" data-fancybox-type="iframe" href="{{ url('signup') }}">Sign Up</a></li>
              @else
                  <li><a id="sign-up-header" data-fancybox-type="iframe" href="{{ url('signup') }}">Sign Up</a></li>
              @endif
              
              @if ($title == 'Login')
                  <li class="active"><a id="login-header" data-fancybox-type="iframe" href="{{ url('login') }}">Login</a></li>
              @else
                  <li><a id="login-header" data-fancybox-type="iframe" href="{{ url('login') }}">Login</a></li>
              @endif
          @endif
          </ul>
        </nav>
      </div>
  </div>
</div>