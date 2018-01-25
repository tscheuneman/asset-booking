<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Admin extends Model
{
    use Uuids;

    public static function getName($asurite) {
        return static::select('first_name', 'last_name')->where('username', $asurite)->first();
    }

}
