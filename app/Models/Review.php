<?php namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    
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
}

?>