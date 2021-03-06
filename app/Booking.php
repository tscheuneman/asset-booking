<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Booking extends Model
{
    use Uuids;
    public $incrementing = false;

    public function asset()
    {
        return $this->hasOne('App\Asset', 'id', 'asset_id')->select('id', 'name', 'location_id', 'cat_id', 'specifications', 'latest_image');
    }

    public function customer()
    {
        return $this->hasOne('App\User', 'id', 'cust_id');
    }

}
