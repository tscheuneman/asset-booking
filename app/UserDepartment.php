<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class UserDepartment extends Model
{
    use Uuids;
    public $incrementing = false;

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }
}
