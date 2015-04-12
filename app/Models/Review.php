<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    
    public function position() {
        return $this->belongsTo('App\Models\Position');
    }
    
    public function location() {
        return $this->belongsTo('App\Models\Location');
    }
}

?>