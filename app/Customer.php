<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Customer extends Model
{
    use Uuids;
    public $incrementing = false;

    public static function getName($asurite) {
        return static::select('first_name', 'last_name')->where('asurite', $asurite)->first();
    }

}
