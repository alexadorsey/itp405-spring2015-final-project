<?php namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    
    public function position() {
        return $this->belongsTo('App\Models\Position');
    }
    
    public function location() {
        return $this->belongsTo('App\Models\Location');
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