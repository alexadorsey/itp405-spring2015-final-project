<?php namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    
    public function __construct() {
    }
    
    public function company() {
        return $this->belongsTo('App\Models\Company');
    }
    
    public function position() {
        return $this->belongsTo('App\Models\Position');
    }
    
    public function city() {
        return $this->belongsTo('App\Models\City');
    }
    
    public function state() {
        return $this->belongsTo('App\Models\State');
    }
    
    public static function validate($input) {
        return Validator::make($input, [
            'Company' => 'required|min:1',
            'City' => 'required|min:1',
            'State' => 'required|min:1',
            'Position' => 'required|min:1',
            'Start_Month' => 'required',
            'Start_Year' => 'required',
            'End_Month' => 'required',
            'End_Year' => 'required',
            'Pros' => 'required|min:1',
            'Cons' => 'required|min:1',
            'Good_Pay' => 'required',
            'Fair_Hours' => 'required',
            'Future_Work' => 'required',
            'Recommend' => 'required'
        ]);
    }
    
    public static function sortByOrder($reviews, $order) {
        if ($order == 'company_rating_high') {
			$reviews->sortByDesc(function($review) {
				return Company::find($review['company_id'])->recommend_percent();
			});
		}
		elseif ($order == 'company_rating_low') {
			$reviews->sortBy(function($review) {
				return Company::find($review['company_id'])->recommend_percent();
			});
		}
		elseif ($order == 'date_posted_newest') {
			$reviews->sortByDesc('created_at');
		}
		elseif ($order == 'date_posted_oldest') {
			$reviews->sortBy('created_at');
		}
        elseif ($order == 'num_reviews_high') {
			$reviews->sortByDesc(function($review) {
				return count(Company::find($review['company_id'])->approvedReviews()->get());
			});
		}
        elseif ($order == 'num_reviews_low') {
			$reviews->sortBy(function($review) {
				return count(Company::find($review['company_id'])->approvedReviews()->get());
			});
		}
        elseif ($order == 'intern_date_recent') {
			$reviews->sortByDesc('intern_start');
		}
        elseif ($order == 'intern_date_old') {
			$reviews->sortBy('intern_start');
		}
        return $reviews;
    }
}

?>