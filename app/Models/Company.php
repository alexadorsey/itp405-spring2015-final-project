<?php namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    
    public static $recommend_rating;
	public static $compensation_rating;
	public static $fair_hours_rating;
	public static $future_work_rating;
    public static $num_reviews;
    
    public function cities() {
        return $this->belongsToMany('App\Models\City');
    }
    
    public function states() {
        return $this->belongsToMany('App\Models\State');
    }
    
    public function positions() {
        return $this->belongsToMany('App\Models\Position');
    }
    
    public function reviews() {
        return $this->hasMany('App\Models\Review');
    }
    
    public function images() {
        return $this->hasMany('App\Models\Image');
    }
    
    public function reviewsSortedByPosition() {
        $reviews = $this->reviews()->get();
        //order by count of position id;
        $reviews->sortByDesc(function($review) {
			return count($review->position_id);
		});
        $reviews->reverse()->reverse();
        dd($reviews);
        
        
    }
    
    public function recommend_percent() {
        $reviews = $this->reviews();
        $num_reviews = count($reviews->get());
        $num_recommend = count($reviews->where('recommend', '=', '1')->get());
        
        if ($num_reviews > 0) {
            return round($num_recommend/$num_reviews * 100);  
        }
        return 0;
        
    }
    
    
    public static function setStats($reviews) {
        self::$num_reviews = count($reviews);
            if (self::$num_reviews > 0) {
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
                    
            self::$recommend_rating = self::calcPercentage($recommend_count);
            self::$compensation_rating = self::calcPercentage($compensation_count);
            self::$fair_hours_rating = self::calcPercentage($fair_hours_count);
            self::$future_work_rating = self::calcPercentage($future_work_count);
        }
    }
    
    
    private static function calcPercentage($num) {
        return round($num/self::$num_reviews * 100);
    }
    
    public static function validate($input) {
        return Validator::make($input, [
            'name' => 'required|max:255',
        ]);
    }
}

?>