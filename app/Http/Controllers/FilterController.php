<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\Category;

class FilterController extends Controller
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
    public function show(Request $request)
    {

        $this->validate(request(), [
            'buildingName' => 'string',
            'cat_id' => 'required|string',
            'region_id' => 'required|string'
        ]);

        $cat_id_arr = array();
        $region_id_arr = array();

        $cat_id = request('cat_id');
        $buildingName = request('buildingName');
        $region_id = request('region_id');


        if($cat_id == 0) {
            $assets = Asset::get();
            foreach($assets as $asset) {
                $cat_id_arr[] = $asset->id;
            }
        }
        else {
            $assets = Asset::where('cat_id', $cat_id)->get();
            if(!empty($assets)) {
                foreach($assets as $asset) {
                    $cat_id_arr[] = $asset->id;
                }
            }
        }

        if($region_id == 0) {
            $assets = Asset::get();
            foreach($assets as $asset) {
                $region_id_arr[] = $asset->id;
            }
        }
        else {
            $assets = Asset::whereHas('location', function($q) use($region_id) {
                $q->where('region_id', $region_id);
            })->get();
            if(!empty($assets)) {
                foreach($assets as $asset) {
                    $region_id_arr[] = $asset->id;
                }
            }
        }

        $result = array_values(array_intersect($region_id_arr, $cat_id_arr));
        return $result;

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
