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
        return $this->hasOne('App\Building', 'uuid', 'building_id');
    }

    /*
    public function region()
    {
        return $this->hasOne('App\Region', 'uuid', 'region_id');
    }
    public function buildingData()
    {
        return $this->belongsTo('App\Building', 'building_id','uuid');
    }
*/
}
