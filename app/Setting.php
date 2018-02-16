<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Setting extends Model
{
    use Uuids;
    public $incrementing = false;


    public function setting()
    {
        return $this->hasOne('App\UserSetting', 'setting_id', 'id');
    }
}
