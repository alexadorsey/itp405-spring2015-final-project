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
		$position = null;
		$location = null;
		$reviews = null;
		if ($company_id != "") {
			$company_name = Company::find($company_id)->name;
			return $this->companyInfo($company_name);
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
		$jobs = $jobs["Results"]["JobSearchResult"];
		if (count($jobs) == 29) {
			$jobs = [$jobs];
		}
		
		return view('search-position', [
			'title' => 'Search Results',
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
	/* Review */
	public function review() {
		
		if (!Auth::check()) {
			return redirect('login');
			
		}
		
		$companies = Company::all();
		$positions = Position::all();
		$cities = City::all();
		$states = State::all();
		
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
		
		return view('review', [
			'title' => 'Review an Intership',
			'companies' => $companies,
			'positions' => $positions,
			'cities' => $cities,
			'states' => $states,
			'jobs' => $jobs
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
		/*
		User::find(1)->roles()->updateExistingPivot($roleId, $attributes);
		$pos = $company->positions()->where("position_id", "=", $position->id)->get();
		if (count($pos) > 0) {
			$company->positions()->updateExistingPivot('count', )
		}
		*/
		
		Company::find($company->id)->positions()->sync([$position->id], false);
		
		
		// Make review
		$review = new Review();
		$review->user_id = Auth::id();
		$review->company_id = $company->id;
		$review->city_id = $city->id;
		$review->state_id = $state->id;
		$review->position_id = $position->id;
		$review->intern_start = date($start_year . '-'. $start_month . '-02');
		$review->intern_end = date($end_year . '-'. $end_month . '-02');
		$review->compensation = $pay;
		$review->fair_hours = $hours;
		$review->future_work = $future;
		$review->recommend = $recommend;
		$review->pros = $pros;
		$review->cons = $cons;
		$review->save();
		
		return redirect(url('dashboard'))->with('success', 'Review awaiting approval.');
		
	}
	
	
		
	/**************************************/
	/* Dashboard */
	public function dashboard() {
		if (!Auth::check()) {
			 return redirect('login');
		}
		
		$user = Auth::user();
		$admin = Admin::where('user_id', '=', $user->id)->first();
	
		if ($admin) {
			$companies = Company::all();
			$positions = Position::all();
			$cities = City::all();
			$states = State::all();
			$reviews = Review::where("approved", "=", 0)->get();
			return view('admin-dashboard', [
				'title' => 'Admin Dashboard',
				'user' => $user,
				'companies' => $companies,
				'positions' => $positions,
				'cities' => $cities,
				'states' => $states,
				'reviews' => $reviews
			]);
		}
		
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
		
		$reviews = Review::where('user_id', '=', $user->id)->get();
		$reviews->load('position', 'city', 'state');
		$reviews->sortByDesc('created_at');
		
		return view('dashboard', [
			'title' => 'Dashboard',
			'user' => $user,
			'reviews' => $reviews,
			'jobs' => $jobs
		]);
	}
	
	public function deleteReview($review_id) {
		$review = Review::find($review_id);
		$review->delete();
		return redirect(url('dashboard'))->with('success', 'Review deleted successfully.');
	}
	
	
	public function approveReview($review_id, Request $request) {
		$review = Review::find($review_id);
		$review->approved = 1;
		$review->save();
		
		if ($request->ajax()) {
			return Response::json(['success'=>true]);
		} else {
			return Response::json(['success'=>false]);
		}
	}
	
	public function disapproveReview($review_id, Request $request) {
		$review = Review::find($review_id);
		$review->approved = 2;
		$review->save();
		
		if ($request->ajax()) {
			return Response::json(['success'=>true]);
		} else {
			return Response::json(['success'=>false]);
		}
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
	
	
	
	/* Create a company */
	public function createCompany() {
		return view('create-company', [
			'title' => 'Create Company',
		]);
	}
	
	public function postCreateCompany(Request $request) {
		$validation = Company::validate($request->all());
		if (!$validation->passes()) {
			return redirect('/dashboard/create-company')
                ->withInput()
                ->withErrors($validation);
		}
		
		// Make a new company
		$company = new Company();
		$company->name = $request->input('name');
		$icon = $request->input('icon');
		if ($icon) {
			$company->icon = $icon;
		}
		$company->save();
		
		return redirect('/dashboard/create-company')->with('success', $company->name . ' successfully added.');
		//return redirect('/dashboard')->with('success', $company->name . ' successfully added.');
	}
	
	
	/* Edit a company */
	public function editCompany($company_id) {
		$company = Company::find($company_id);
		return view('edit-company', [
			'title' => 'Edit Company',
			'company' => $company
        ]);
	}
	
	public function postEditCompany($company_id, Request $request) {
		// Edit company
		$company = Company::find($company_id);
		$company->name = $request->input('company-name');
		$icon = $request->input('icon');
		if ($icon) {
			$company->icon = $icon;
		}
		$company->save();
		return redirect('/dashboard/edit-company/' . $company->id)->with('success', $company->name . ' successfully edited.');
	}
	
	/* Delete a company */
	public function deleteCompany($company_id) {
		// Get company
		$company = Company::find($company_id);
		// Delete reviews of company
		$reviews = $company->reviews()->get();
		foreach ($reviews as $review) {
			$review->delete();
		}
		// Delete company
		$company->delete();
		return redirect(url('dashboard'))->with('success', $company->name . ' successfully deleted.');
	}
	
	
	
	
	/* Create a position */
	public function createPosition() {
		return view('create-position', [
			'title' => 'Create Position',
		]);
	}
	
	public function postCreatePosition(Request $request) {
		$validation = Position::validate($request->all());
		if (!$validation->passes()) {
			return redirect('/dashboard/create-position')
                ->withInput()
                ->withErrors($validation);
		}
		$position = new Position();
		$position->name = $request->input('name');
		$position->save();
		
		return redirect('/dashboard/create-position')->with('success', $position->name . ' successfully added.');
	}
	
	/* Edit a position */
	public function editPosition($position_id) {
		$position = Position::find($position_id);
		return view('edit-position', [
			'title' => 'Edit Position',
			'position' => $position
        ]);
	}
	
	public function postEditPosition($position_id, Request $request) {
		$position = Position::find($position_id);
		$position->name = $request->input('position-name');
		$position->save();
		return redirect('/dashboard/edit-position/' . $position->id)->with('success', $position->name . ' successfully edited.');
	}
	
	/* Delete a position */
	public function deletePosition($position_id) {
		$position = Position::find($position_id);
		$position->delete();
		return redirect(url('dashboard'))->with('success', $position->name . ' successfully deleted.');
	}
	
	
	/* Create a city */
	public function createCity() {
		return view('create-city', [
			'title' => 'Create City',
		]);
	}
	
	public function postCreateCity(Request $request) {
		$validation = City::validate($request->all());
		if (!$validation->passes()) {
			return redirect('/dashboard/create-city')
                ->withInput()
                ->withErrors($validation);
		}
		$city = new City();
		$city->name = $request->input('name');
		$city->save();
		
		return redirect('/dashboard/create-city')->with('success', $city->name . ' successfully added.');
	}
	
	/* Edit a position */
	public function editCity($city_id) {
		$city = City::find($city_id);
		return view('edit-city', [
			'title' => 'Edit City',
			'city' => $city
        ]);
	}
	
	public function postEditCity($city_id, Request $request) {
		$city = City::find($position_id);
		$city->name = $request->input('city-name');
		$city->save();
		return redirect('/dashboard/edit-city/' . $city->id)->with('success', $city->name . ' successfully edited.');
	}
	
	/* Delete a position */
	public function deleteCity($city_id) {
		$city = City::find($city_id);
		$city->delete();
		return redirect(url('dashboard'))->with('success', $city->name . ' successfully deleted.');
	}
	
	
}
