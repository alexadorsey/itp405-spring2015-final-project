<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Position;
use App\Models\Location;
use App\Models\Review;
use App\Models\Company_Location;

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
	public function home() {
		$companies = Company::all();
		$positions = Position::all();
		$locations = Location::all();
    
		return view('home', [
			'companies' => $companies,
			'positions' => $positions,
			'locations' => $locations
        ]);
    }
    
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
			
			
			/* Company Statistics */
			Company::setStats($reviews);
			/*
			$num_reviews = count($reviews);
			$recommend_count = 0;
			$compensation_count = 0;
			$fair_hours_count = 0;
			$future_work_count = 0;
			
			foreach ($reviews as $review) {
				if ($review->recommend == 1) {
					$recommend_count++;
				}
				if ($review->compensation == 1) {
					$compensation_count++;
				}
				if ($review->fair_hours == 1) {
					$fair_hours_count++;
				}
				if ($review->future_work == 1) {
					$future_work_count++;
				}
			}
			
			$recommend_rating = ($recommend_count/$num_reviews * 100);
			$compensation_rating = $compensation_count/$num_reviews;
			$fair_hours_rating = $fair_hours_count/$num_reviews * 100;
			$future_work_rating = $future_work_count/$num_reviews;
			*/
			return view('search', [
				'company' => $company,
				'reviews' => $reviews,
				'position' => $position,
				'location' => $location,
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
			'companies' => $companies,
		]);
		
    }

}
