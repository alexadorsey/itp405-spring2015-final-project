<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    
    public static $recommend_rating;
	public static $compensation_rating;
	public static $fair_hours_rating;
	public static $future_work_rating;
    public static $num_reviews;
    
    public function positions() {
        return $this->belongsToMany('App\Models\Position');
    }
    
    public function reviews() {
        return $this->hasMany('App\Models\Review');
    }
    
    public function images() {
        return $this->hasMany('App\Models\Image');
    }
    
    
    public static function setStats($reviews) {
        self::$num_reviews = count($reviews);
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
    
    
    private static function calcPercentage($num) {
        return round($num/self::$num_reviews * 100);
    }
}

?>