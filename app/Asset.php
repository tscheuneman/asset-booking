<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Asset extends Model
{
    use Uuids;
    public $incrementing = false;
    //
    public function category() {
        return $this->belongsTo('App\Category', 'cat_id', 'id');

    }

    public function location()
    {
        return $this->hasOne('App\Location', 'id', 'location_id');
    }

    public function building() {
        return $this->hasManyThrough('App\Building', 'App\Location');
    }

    /* Public Calls */
    public function publicCategory() {
        return $this->belongsTo('App\Category', 'cat_id', 'id')->select('id', 'name', 'description');
    }
    public function publicLocation()
    {
        return $this->hasOne('App\Location', 'id', 'location_id')->select('id', 'asset_id', 'building_id','region_id');
    }

    public function publicBuilding() {
        return $this->hasManyThrough('App\Building', 'App\Location');
    }

}
