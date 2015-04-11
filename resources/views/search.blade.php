<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="{{ asset('css/cover.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/company-page.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fancyBox/source/jquery.fancybox.css') }}" type="text/css" media="screen" />

	
</head>
<body>
    <!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fancyBox/source/jquery.fancybox.pack.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
    <script type="text/javascript">
    (function ($, F) {
        F.transitions.resizeIn = function() {
            var previous = F.previous,
                current  = F.current,
                startPos = previous.wrap.stop(true).position(),
                endPos   = $.extend({opacity : 1}, current.pos);
    
            startPos.width  = previous.wrap.width();
            startPos.height = previous.wrap.height();
    
            previous.wrap.stop(true).trigger('onReset').remove();
    
            delete endPos.position;
    
            current.inner.hide();
    
            current.wrap.css(startPos).animate(endPos, {
                duration : current.nextSpeed,
                easing   : current.nextEasing,
                step     : F.transitions.step,
                complete : function() {
                    F._afterZoomIn();
    
                    current.inner.fadeIn("fast");
                }
            });
        };
    
    }(jQuery, jQuery.fancybox));

	$(document).ready(function() {

		$(".fancybox")
            .attr('rel', 'gallery')
            .fancybox({
                nextMethod : 'resizeIn',
                nextSpeed  : 250,
                
                prevMethod : false,
                
            });
    });
</script>
    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">
		
          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">InternshipWatch.com</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">Companies</a></li>
				  <li><a href="#">Sign Up</a></li>
				  <li><a href="#">Log In</a></li>
                </ul>
              </nav>
            </div>
          </div>
            <div id="review-btn">
					<button type="submit">
							<a href="#" class="btn btn-small btn-danger"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Review</a>    
					</button>
				</div>
            <!--
            <div id="review-btn">
                <h6><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Review</h6>
            </div>
            -->

            <div id="company-header">
                <h1 id="company-title">{{ $company->name }}
                <img id="company-logo" src="{{ $company->icon }}"/>
                </h1>
                <div class="clear"></div>
                <a href="http://www.google.com/about/careers">{{ $company->job_site }}</a>
            </div>
            
            
            
            <div class="inner-body">
            <hr/>
            <div id="company-stats">
                <div id="stats">
                    <p><span class="glyphicon glyphicon-thumbs-up" id="title-recommend-icon"></span></span><span id="title-recommend">{{ $recommend_rating }}% Recommend</span></p>
                    <hr style="width: 20%"/>
                    <p><span class="glyphicon glyphicon-time title-icon"></span><span class="title-text">{{ $fair_hours_rating }}% say Fair Hours</span></p>
                    <p><span class="glyphicon glyphicon-usd title-icon"></span></span><span class="title-text">{{ $compensation_rating }}% say Good Pay</span></p>
                    <p><span class="glyphicon glyphicon-briefcase title-icon"></span></span><span class="title-text">{{ $future_work_rating }}% say Future Work</span></p>
                    <hr style="width: 20%"/>
                </div>
					
				<div id="images">
				@for ($i = 0; $i < count($images); $i++)
					@if ($i % 2 == 0)
						<div class="img-box img-left">
					@else
						<div class="img-box img-right">
					@endif
					<a class="fancybox rel="group" href="{{ $images[$i]->src }}">
                        <img class="company-img" src="{{ $images[$i]->src }}" alt=""/></a>
                    </div>
					
				@endfor
				</div>	
            </div>
                
            <div id="reviews">
                
				@foreach ($reviews as $review)
					
					<div class="review">
                    <span class="review-title" style="float:left;">{{ $position->name }} at {{ $location->city }}, {{$location->state }}</span>
                    <span style="float:right">
						@if ($review->recommend == 0)
							<span class="glyphicon glyphicon-thumbs-up review-icon neg-review-rating"></span>
						@else
							<span class="glyphicon glyphicon-thumbs-up review-icon pos-review-rating"></span>
						@endif
						
						@if ($review->fair_hours == 1)
							<span class="glyphicon glyphicon-time review-icon neg-review-rating"></span>
						@else
							<span class="glyphicon glyphicon-time review-icon pos-review-rating"></span>
						@endif
						
						@if ($review->compensation == 0)
							<span class="glyphicon glyphicon-usd review-icon neg-review-rating"></span>
						@else
							<span class="glyphicon glyphicon-usd review-icon pos-review-rating"></span>
						@endif
						
						@if ($review->future_work == 0)
							<span class="glyphicon glyphicon-briefcase review-icon neg-review-rating"></span>
						@else
							<span class="glyphicon glyphicon-briefcase review-icon pos-review-rating"></span>
						@endif

                    </span>
                    <div style="clear:both"></div>
                    <span class="intern-date">{{ DATE_FORMAT(new DateTime($review->intern_start), 'F Y') }} - {{ DATE_FORMAT(new DateTime($review->intern_end), 'F Y') }}</span>
                    <span class="post-date">Posted {{ DATE_FORMAT(new DateTime($review->date_posted), 'n/j/y') }}</span>
                    <div class="clear"></div>
                    <table>
                        <tr>
                            <td class="pro">Pros:</td>
                            <td>{{ $review->pros }}</td>
                        </tr>
                        <tr>
                            <td class="pro">Cons:</td>
							<td>{{ $review->cons }}</td>
                        </tr>
                    </table>
                </div>
					
				@endforeach
				
				<!--   
                <div class="review">
                    <span class="review-title" style="float:left;">Software Engineer at Mountain View, CA</span>
                    <span style="float:right">
                        <span class="glyphicon glyphicon-thumbs-up review-icon"></span>
                        <span class="glyphicon glyphicon-time review-icon"></span>
                        <span class="glyphicon glyphicon-usd review-icon"></span>
                        <span class="glyphicon glyphicon-briefcase review-icon"></span>
                    </span>
                    <div style="clear:both"></div>
                    <span>May 2014 - August 2014</span>
                    <span class="post-date">Posted 3/22/15</span>
                    <table>
                        <tr>
                            <td class="pro">Pros:</td>
                            <td>Loved the culture and they provided training right from the start. I really feel like I learned a lot and definitely came out a better engineer.</td>
                        </tr>
                        <tr>
                            <td class="pro">Cons:</td>
                            <td>The work hours could get very long and a lot is expected from you even if this is your first internship.</td>
                        </tr>
                    </table>
                </div>
                    
                <div class="review">
                    <span class="review-title" style="float:left;">Software Engineer at Mountain View, CA</span>
                    <span style="float:right">
                        <span class="glyphicon glyphicon-thumbs-up review-icon"></span>
                        <span class="glyphicon glyphicon-time review-icon"></span>
                        <span class="glyphicon glyphicon-usd review-icon"></span>
                        <span class="glyphicon glyphicon-briefcase review-icon"></span>
                    </span>
                    <div style="clear:both"></div>
                    <span>May 2014 - August 2014</span>
                    <span class="post-date">Posted 3/22/15</span>
                    <table>
                        <tr>
                            <td class="pro">Pros:</td>
                            <td>Loved the culture and they provided training right from the start. I really feel like I learned a lot and definitely came out a better engineer.</td>
                        </tr>
                        <tr>
                            <td class="pro">Cons:</td>
                            <td>The work hours could get very long and a lot is expected from you even if this is your first internship.</td>
                        </tr>
                    </table>
                </div>
				-->
				
            </div>
            <div class="clear"></div>
            </div>
        </div>
            
            
		<footer>
            <p>&copy Alexa Dorsey | USC ITP 405</p>
        </footer>	
      </div>

    </div>
</body>
</html>






  