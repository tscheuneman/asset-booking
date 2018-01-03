<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    //
    public function category() {
        return $this->belongsTo('App\Category', 'cat_id');

    }

    public function location()
    {
        return $this->hasOne('App\Location');
    }

    public function building() {
        return $this->hasManyThrough('App\Building', 'App\Location');
    }
}
