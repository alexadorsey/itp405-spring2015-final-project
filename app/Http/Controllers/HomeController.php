<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\View;
use App\Models\Company;
use App\Models\Position;
use App\Models\Location;
use App\Models\Review;
use App\Models\Company_Location;
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
		$locations = Location::all();
    
		return view('home', [
			'title' => 'Home',
			'companies' => $companies,
			'positions' => $positions,
			'locations' => $locations
        ]);
    }

	
	
    /**************************************/
	/* Search Results */
    public function search(Request $request) {
        $company_id = $request->input('company-id');
		$position_id = $request->input('position-id');
		$location_id = $request->input('location-id');
		
		$position = Position::find($position_id);
		$location = Location::find($location_id);
		
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
		if (!Auth::check()) {
			 return redirect('login');
		}
		
		$company_id = \Illuminate\Support\Facades\Request::input('company_id');
		$company = Company::find($company_id);
		
		return view('review', [
			'title' => 'Review ' . $company->name,
			'company' => $company
        ]);
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
