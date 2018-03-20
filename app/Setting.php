<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Setting extends Model
{
    use Uuids;
    public $incrementing = false;


    public function adminSetting()
    {
        return $this->hasOne('App\AdminSetting', 'setting_id', 'id');
    }
}
