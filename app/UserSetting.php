<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class UserSetting extends Model
{
    use Uuids;
    public $incrementing = false;

}
