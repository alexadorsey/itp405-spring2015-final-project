<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\View;
use App\Models\Company;
use App\Models\Position;
use App\Models\Location;
use App\Models\Review;
use App\Models\City;
use App\Models\State;
use App\Models\Admin;
use Auth;
use Response;
use Input;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;


class HomeController extends Controller {
	
	private $devkey = "WDHQ43364147NGQQZP5R";
	
	
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
	/* Company Info */
	public function companyInfo($company_name) {
		$company = Company::where('name', '=', $company_name)->first();
		$cities = $company->cities()->get();
		$states = $company->states()->get();
		$images = $company->images()->get();
		$reviews = $company->approvedReviews()->orderBy('created_at', 'DESC')->get();
		$reviews->load('position', 'city', 'state');
		
		/* Company Statistics */
		Company::setStats($reviews);
		
		/* Internships at that company */
		$url = "http://api.careerbuilder.com/v1/jobsearch?DeveloperKey=" . $this->devkey . "&JobTitle=intern";
		$url .= "&CompanyName=". urlencode($company->name);
		$cache_string = "jobs-" . $company->name;
				
		if (Cache::has($cache_string)) { // if in cache and hasn't expired yet
			$json = Cache::get($cache_string);
		} else {
			$xml = simplexml_load_string(file_get_contents($url));
			$json = json_encode($xml);
			Cache::put($cache_string, $json, 180) ;
		}
		
		$jobs = json_decode($json,TRUE);
		if (count($jobs["Results"]) > 0) {
			$jobs = $jobs["Results"]["JobSearchResult"];
		} else {
			$jobs = [];
		}
		return view('company', [
			'title' => $company->company_name . 'Profile',
			'company' => $company,
			'reviews' => $reviews,
			'cities' => $cities,
			'states' => $states,
			'images' => $images,
			'recommend_rating' => Company::$recommend_rating,
			'compensation_rating' => Company::$compensation_rating,
			'fair_hours_rating' => Company::$fair_hours_rating,
			'future_work_rating' => Company::$future_work_rating,
			'jobs' => $jobs
		]);
	}
	
	
    /**************************************/
	/* Search */
	public function search(Request $request) {
		
		$url = "http://api.careerbuilder.com/v1/jobsearch?DeveloperKey=" . $this->devkey . "&JobTitle=intern";
		
		$cache_string = "jobs-";
		
		$company_id = $request->input('company-id');
		$position_id = $request->input('position-id');
		$location_val = $request->input('City');
		$order = $request->input('order');
        
        $company = null;
		$position = null;
		$location = null;
		$reviews = null;
		if ($company_id != "" && $position_id == "" && $location_val == "") {
			$company_name = Company::find($company_id)->name;
			return $this->companyInfo($company_name);
		}
        
        if ($company_id != "") {
            $company = Company::find($company_id);
            $reviews_company = $company->approvedReviews()->orderBy('created_at', 'DESC')->get();
        }
		
		if ($position_id != "") {
			$position = Position::find($position_id);
			$reviews_position = $position->approvedReviews()->orderBy('created_at', 'DESC')->get();
		}
		
		if ($location_val) {
			$location = City::where('name', '=', $location_val)->first();
			if ($location) {
				$reviews_location = City::find($location->id)->approvedReviews()->orderBy('created_at', 'DESC')->get();
			} else {
				$location = State::where('name', '=', $location_val)->first();
				if ($location) {
					$reviews_location = State::find($location->id)->approvedReviews()->orderBy('created_at', 'DESC')->get();
				}
			}
		}
		
        
		if ($position_id && $location_val) {
			// intersect
			$reviews = $reviews_position->intersect($reviews_location);
			$url .= "&keywords=". urlencode($position->name) . '&location=' . urlencode($location->name);
			$cache_string .= $position_id . "+" . urlencode($location->name);
		} elseif ($position_id) {
			$reviews = $reviews_position;
			$url .= "&keywords=" . urlencode($position->name);
			$cache_string .= $position_id;
		} elseif ($location_val) {
			$reviews = $reviews_location;
			$url .= "&location=" . urlencode($location->name);
			$cache_string .= urlencode($location->name);
		} else {
			$reviews = Review::where("approved", "=", 1)->get();
		}
                
        // intersect with company
        if ($company_id != "") {
            $reviews = $reviews->intersect($reviews_company);
        }
		
		$reviews->load('company', 'position', 'city', 'state');
		$reviews = Review::sortByOrder($reviews, $order);
		
		if (Cache::has($cache_string)) { // if in cache and hasn't expired yet
			$json = Cache::get($cache_string);
		} else {
			$xml = simplexml_load_string(file_get_contents($url));
			$json = json_encode($xml);
			Cache::put($cache_string, $json, 180) ;
		}
		
		$jobs = json_decode($json, TRUE);
        if (count($jobs["Results"]) > 0) {
            $jobs = $jobs["Results"]["JobSearchResult"];
            if (count($jobs) == 29) {
                $jobs = [$jobs];
            }    
        } else {
            $jobs = [];
        }
		
		
		return view('search-position', [
			'title' => 'Search Results',
            'company' => $company,
			'position' => $position,
			'position_id' =>$position_id,
			'location' => $location,
			'location_val' => $location_val,
			'reviews' => $reviews,
			'jobs' => $jobs,
			'order' => $order
        ]);
	}
	
	
	/**************************************/
	/* Companies */
	public function companies(Request $request) {
		$companies = Company::all();
		$order = $request->input('order');
		if (!$order) {
			$order = 'company_rating_high';
		}

		$companies = Company::sortByOrder($companies, $order);
		
		/* All internships */
		$url = "http://api.careerbuilder.com/v1/jobsearch?DeveloperKey=" . $this->devkey . "&JobTitle=intern";
		$cache_string = "jobs-all";
				
		if (Cache::has($cache_string)) { // if in cache and hasn't expired yet
			$json = Cache::get($cache_string);
		} else {
			$xml = simplexml_load_string(file_get_contents($url));
			$json = json_encode($xml);
			Cache::put($cache_string, $json, 180) ;
		}
		
		$jobs = json_decode($json,TRUE);
		if (count($jobs["Results"]) > 0) {
			$jobs = $jobs["Results"]["JobSearchResult"];
		} else {
			$jobs = [];
		}
				
		return view('companies', [
			'title' => 'Companies',
			'companies' => $companies,
			'jobs' => $jobs,
			'order' => $order
		]);
	}
	
	
}
