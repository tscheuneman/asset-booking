<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function Asset()
    {
        return $this->hasOne('App\Asset');
    }

    public function building()
    {
        return $this->belongsTo('App\Building', 'building_id');
    }
    public function region()
    {
        return $this->belongsTo('App\Region', 'region_id');
    }
    public function buildingData()
    {
        return $this->belongsTo('App\Building', 'building_id');
    }

}
