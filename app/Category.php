<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Category extends Model
{
    use Uuids;
    public $incrementing = false;

    public function getAssets() {
        return $this->hasMany('Asset', 'cat_id');
    }

    public function subcats() {
        return $this->hasMany('App\Category', 'parent_cat');
    }

    public function parentcat() {
        return $this->belongsTo('App\Category', 'parent_cat')->select('id', 'parent_cat', 'name');
    }

    public function parentcatrecursive()
    {
        return $this->parentcat()->with('parentcatrecursive');
    }
}
