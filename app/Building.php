<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Emadadly\LaravelUuid\Uuids;

class Building extends Model
{
    use Uuids;
    public $incrementing = false;

    public static function getByDistance($lat, $lng, $distance)
    {
        $query = 'SELECT id, longitude, latitude,
            (3959 * acos(cos(radians('.$lat.')) 
            * cos(radians(building.latitude))
            * cos(radians(building.longitude) - radians('. $lng .') ) + sin(radians('.$lat.')) 
            * sin(radians(building.latitude)))) 
            AS distance
            FROM buildings as building
            HAVING distance < ' .$distance. ' 
            ORDER BY distance 
            LIMIT 18';
        $results = DB::select(DB::raw($query));
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
