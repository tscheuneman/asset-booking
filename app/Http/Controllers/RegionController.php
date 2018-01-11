<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;

class RegionController extends Controller
{
    public function index() {
        $region = Region::get();
        return view('admin.regions',
            [
                'campuses' => $region
            ]
        );
    }

    public function create() {
        return view('admin.regionCreate');
    }

    public function store() {
        $campus = new Region();

        $this->validate(request(), [
            'name' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        $campus->name = request('name');
        $campus->longitude = request('longitude');
        $campus->latitude = request('latitude');

        $campus->save();
        return redirect('/admin/locations/campuses');
    }

}
