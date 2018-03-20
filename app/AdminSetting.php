<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class AdminSetting extends Model
{
    use Uuids;
    public $incrementing = false;

}
