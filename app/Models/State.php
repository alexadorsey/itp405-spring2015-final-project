<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model {
    
    public function companies() {
        return $this->belongsToMany('App\Models\Company');
    }
    
    public function reviews() {
        return $this->hasMany('App\Models\Review');
    }
}

?>