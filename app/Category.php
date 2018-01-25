<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Category extends Model
{
    use Uuids;
    public $incrementing = false;

    public function getAssets() {
        return $this->hasMany('Asset', 'cat_id', 'uuid');
    }
}
