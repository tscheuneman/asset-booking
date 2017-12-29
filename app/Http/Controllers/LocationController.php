<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
use App\Campus;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function verify(Request $request) {
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $distance = 1.2;

        $getBuilding = Building::getByDistance($lat, $lng, $distance);
        $getCampus = Campus::getByDistance($lat, $lng, 10);

        $arrayVal = array();
        $prevBuildings = array();
        $counter = 0;
        foreach($getBuilding as $building) {
            $val =  Building::find($building->id);

            if(!in_array(trim(strtoupper($val['name'])), $prevBuildings)) {
                $arrayVal[$counter] = array(
                    "id" => $val["id"],
                    "name" => ucwords(strtolower($val["name"])),
                    "lat" => $val["latutide"],
                    "lng" => $val["longitude"],
                );
                $prevBuildings[] = trim(strtoupper($val['name']));
                $counter++;
            }
        }


        $campus = Campus::find($getCampus['id']);

        $array = array(
          "campus" => array(
            "id" => $campus["id"],
            "name" => $campus["name"],
            "lat" => $campus["latitude"],
            "lng" => $campus["longitude"],
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
