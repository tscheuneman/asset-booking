<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class CartEntry extends Model
{
    use Uuids;
    public $incrementing = false;

    public function booking()
    {
        return $this->hasOne('App\Booking', 'id', 'booking_id');
    }
}
