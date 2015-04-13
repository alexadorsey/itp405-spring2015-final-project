<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\View;
use App\Models\Company;
use App\Models\Position;
use App\Models\Location;
use App\Models\Review;
use App\Models\City;
use App\Models\State;
use Auth;


class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
    /*
	public function __construct()
	{
		$this->middleware('auth');
	}
	*/

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	
	
	
	/**************************************/
	/* Homepage */
	public function home() {
		$companies = Company::all();
		$positions = Position::all();
		$cities = City::all();
		$states = State::all();
    
		return view('home', [
			'title' => 'Home',
			'companies' => $companies,
			'positions' => $positions,
			'cities' => $cities,
			'states' => $states
        ]);
    }

	
	
    /**************************************/
	/* Search Results */
	
	public function search(Request $request) {
		
		$position_id = $request->input('position-id');
		$location_val = $request->input('location-input');
		
		$position = Position::find($position_id);
		$companies = Position::find($position_id)->companies()->get();
		
		
		return view('search-position', [
			'title' => 'Search Position',
			'position' => $position,
			'companies' => $companies
        ]);
        
		/*
		return view('search-position', [
			'title' => 'Search Position'
		]);
		*/
	}
	
	
	
    public function search2(Request $request) {
        $company_id = $request->input('company-id');
		$position_id = $request->input('position-id');
		$city_name = $request->input('City');
		$state_name = $request->input('State');
		
		
		$position = Position::find($position_id);
		
		$images = Company::find($company_id)->images()->get();
		
		if ($company_id != "") {
			$company = Company::find($company_id);
			$reviews = Company::find($company_id)->reviews()->get();
			$reviews->load('position', 'location');

			
			/* Company Statistics */
			Company::setStats($reviews);

			return view('search', [
				'title' => $company->name,
				'company' => $company,
				'reviews' => $reviews,
				//'position' => $position,
				//'location' => $location,
				'images' => $images,
				'recommend_rating' => Company::$recommend_rating,
				'compensation_rating' => Company::$compensation_rating,
				'fair_hours_rating' => Company::$fair_hours_rating,
				'future_work_rating' => Company::$future_work_rating
			]);
		}
		
		elseif ($position_id != "" && $location_id != "") {
			$pos = $position->companies()->get();
			$loc = $location->companies()->get();
			$companies = $loc->intersect($pos);
		}
		
		elseif ($position_id != "") {
			$companies = $position->companies()->get();
		}
		
		elseif ($location_id != "") {
			$companies = $location->companies()->get();
		}
		
		return view('search', [
			'title' => 'Search Results',
			'companies' => $companies,
		]);
		
    }
	
	
	/**************************************/
	/* Review */
	public function review(Request $request) {
		/*
		if (!Auth::check()) {
			 return redirect('login');
		}
		*/
		/*
		$company_id = \Illuminate\Support\Facades\Request::input('company_id');
		$company = Company::find($company_id);
		*/
		$companies = Company::all();
		$positions = Position::all();
		$cities = City::all();
		$states = State::all();
		
		/*
		$url = "https://api.insideview.com/api/v1/companies";
		$jsonString = file_get_contents($url);
		dd($jsonString);
		*/
		
		return view('review', [
			'title' => 'Review an Intership',
			'companies' => $companies,
			'positions' => $positions,
			'cities' => $cities,
			'states' => $states
        ]);
    }
	
	public function postReview(Request $request) {
		$validation = Review::validate($request->all());
		if (!$validation->passes()) {
			return redirect('/review')
                ->withInput()
                ->withErrors($validation);
		}
		
		$company_id = $request->input('company-id');
		$position_id = $request->input('position-id');
		$city_name = $request->input('City');
		$state_name = $request->input('State');
		
		$start_month = $request->input('Start_Month');
		$start_year = $request->input('Start_Year');
		$end_month = $request->input('End_Month');
		$end_year = $request->input('End_Year');
		
		$pay = $request->input('Good_Pay');
		$hours = $request->input('Fair_Hours');
		$future = $request->input('Future_Work');
		$recommend = $request->input('Recommend');
		
		$pros = $request->input('Pros');
		$cons = $request->input('Cons');
		
		// See if company exists
		$company = Company::find($company_id);
				
		if (!$company) { // If it doesn't, create it
			$company = new Company();
			$company->name = $request->input('Company');
			$company->save();
		}

		
		// See if city exists
		$city = City::where('name', '=', $city_name)->first();
		
		if (!$city) {
			$city = new City();
			$city->name = $city_name;
			$city->save();
		}
		Company::find($company->id)->cities()->sync([$city->id], false);
		
		
		// See if state exists
		$state = State::where('name', '=', $state_name)->first();
		
		if (!$state) {
			$state = new State();
			$state->name = $state_name;
		}
		Company::find($company->id)->states()->sync([$state->id], false);
		
		
		// See if position exists
		$position = Position::find($position_id);
		
		if (!$position) {
			$position = new Position();
			$position->name = $request->input('Position');
			$position->save();
		}
		Company::find($company->id)->positions()->sync([$position->id], false);
		
		
		// Make review
		$review = new Review();
		$review->user_id = Auth::id();
		$review->company_id = $company->id;
		$review->city_id = $city->id;
		$review->state_id = $state->id;
		$review->position_id = $position->id;
		$review->intern_start = date($start_year . '-'. $start_month . '-01');
		$review->intern_end = date($end_year . '-'. $end_month . '-01');
		$review->compensation = $pay;
		$review->fair_hours = $hours;
		$review->future_work = $future;
		$review->recommend = $recommend;
		$review->pros = $pros;
		$review->cons = $cons;
		$review->save();
		dd($review);
		
	}
	
	
		
	/**************************************/
	/* Dashboard */
	public function dashboard() {
		if (!Auth::check()) {
			 return redirect('login');
		}
		
		return view('dashboard', [
			'title' => 'Dashboard'
		]);
	}

}
