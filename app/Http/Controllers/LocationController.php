<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
use App\Region;
use App\Asset;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->get('id');
        $assets = Asset::with('location.building', 'category')->find($id);

        return $assets;

    }

    public function verify(Request $request) {
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $distance = 1.2;

        $getBuilding = Building::getByDistance($lat, $lng, $distance);
        $getRegion = Region::getByDistance($lat, $lng, 10);

        $arrayVal = array();
        $prevBuildings = array();
        $counter = 0;

        foreach($getBuilding as $building) {
            $val =  Building::find($building->id);

            if(!in_array(trim(strtoupper($val['name'])), $prevBuildings)) {
                $arrayVal[$counter] = array(
                    "id" => $val["id"],
                    "name" => utf8_decode(ucwords(strtolower($val["name"]))),
                    "lat" => $val["latutide"],
                    "lng" => $val["longitude"],
                );
                $prevBuildings[] = trim(strtoupper($val['name']));
                $counter++;
            }
        }

        $region = Region::find($getRegion['id']);

        $array = array(
          "region" => array(
            "id" => $region["id"],
            "name" => $region["name"],
            "lat" => $region["latitude"],
            "lng" => $region["longitude"],
          ),
          "building" => $arrayVal
        );

        return $array;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
