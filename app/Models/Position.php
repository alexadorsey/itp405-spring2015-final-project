<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model {
    
    public function companies() {
        return $this->belongsToMany('App\Models\Company');
    }
    
    public function reviews() {
        return $this->hasMany('App\Models\Review');
    }
}

?>