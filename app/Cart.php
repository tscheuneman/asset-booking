<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Cart extends Model
{
    use Uuids;
    public $incrementing = false;
}
