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
        return $this->belongsTo('App\Building', 'building');
    }

    public function buildingData()
    {
        return $this->belongsTo('App\Building', 'building');
    }

}
