<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Emadadly\LaravelUuid\Uuids;

class Region extends Model
{
    use Uuids;
    public $incrementing = false;

    public static function getByDistance($lat, $lng, $distance)
    {
        $query = 'SELECT id, longitude, latitude,
            (3959 * acos(cos(radians('.$lat.')) 
            * cos(radians(region.latitude))
            * cos(radians(region.longitude) - radians('. $lng .') ) + sin(radians('.$lat.')) 
            * sin(radians(region.latitude)))) 
            AS distance
            FROM regions as region
            HAVING distance < ' .$distance. ' 
            ORDER BY distance 
            LIMIT 1';

        $results = DB::select(DB::raw($query));
        return (array)$results[0];
    }

    public function locations()
    {
        return $this->hasMany('App\Location', 'region_id')->selectRaw('region_id, count(*) as aggregate')
            ->groupBy('region_id');
    }

}
