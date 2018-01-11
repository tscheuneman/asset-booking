<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Region extends Model
{
    public static function getByDistance($lat, $lng, $distance)
    {
        $results = DB::select(DB::raw('SELECT id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(latitude) ) ) ) AS distance FROM regions HAVING distance < ' . $distance . ' ORDER BY distance LIMIT 1'));
        return (array)$results[0];
    }

    public function locations()
    {
        return $this->hasMany('App\Location', 'region_id')->selectRaw('region_id, count(*) as aggregate')
            ->groupBy('region_id');
    }

}
