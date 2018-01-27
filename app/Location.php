<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Location extends Model
{
    use Uuids;
    public $incrementing = false;


    public function Asset()
    {
        return $this->hasOne('App\Asset');
    }

    public function building()
    {
        return $this->hasOne('App\Building', 'id', 'building_id');
    }
    public function publicBuilding()
    {
        return $this->hasOne('App\Building', 'id', 'building_id')->select('id', 'name');
    }


    public function region()
    {
        return $this->hasOne('App\Region', 'id','region_id');
    }

    public function publicRegion()
    {
        return $this->hasOne('App\Region', 'id','region_id')->select('id', 'name');
    }

    public function buildingData()
    {
        return $this->belongsTo('App\Building', 'id','building_id');
    }

}
