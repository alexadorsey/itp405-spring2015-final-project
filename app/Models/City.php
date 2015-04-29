<?php namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class City extends Model {
    
    public function companies() {
        return $this->belongsToMany('App\Models\Company');
    }
    
    public function reviews() {
        return $this->hasMany('App\Models\Review');
    }
    
    public function approvedReviews() {
        return $this->reviews()->where("approved", "=", 1);
    }
    
    public static function validate($input) {
        return Validator::make($input, [
            'name' => 'required|max:255',
        ]);
    }
}

?>