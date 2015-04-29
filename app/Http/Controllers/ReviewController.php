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

class ReviewController extends Controller {
    
    private $devkey = "WDHQ43364147NGQQZP5R";
    
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
	
    /* Submit Review */
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
    
}

?>