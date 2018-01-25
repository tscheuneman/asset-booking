<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Emadadly\LaravelUuid\Uuids;

class Building extends Model
{
    use Uuids;
    public $incrementing = false;

    public function location()
    {
        return $this->belongsTo('App\Location','uuid', 'building_id');
    }


    public static function getByDistance($lat, $lng, $distance)
    {
        $results = DB::select(DB::raw('SELECT id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(latitude) ) ) ) AS distance FROM buildings HAVING distance < ' . $distance . ' ORDER BY distance LIMIT 12'));
        return (array)$results;
    }

    public function scopeSearchBuilding($query, $key) {
        if ($key!='') {
            $query->where(function ($query) use ($key) {
                $query->where("name", "LIKE","%$key%");
            });
        }
        return $query;
    }
}
