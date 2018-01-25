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
        return $this->belongsTo('App\Category', 'cat_id', 'uuid');

    }

    public function location()
    {
        return $this->hasOne('App\Location');
    }

    public function building() {
        return $this->hasManyThrough('App\Building', 'App\Location');
    }

}
