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


class DashboardController extends Controller {
	
	private $devkey = "WDHQ43364147NGQQZP5R";
    
    		
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
	
	/* Edit a city */
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