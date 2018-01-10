<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Building;

class BuildingController extends Controller
{
    public function index() {
        $buildings = Building::get();
        return view('admin.buildings',
            [
                'buildings' => $buildings
            ]
        );
    }
    public function create() {
        return view('admin.buildingCreate');
    }

    public function store() {
        $build = new Building();

        $this->validate(request(), [
            'name' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        $build->name = request('name');
        $build->longitude = request('longitude');
        $build->latitude = request('latitude');

        $build->save();
        return redirect('/admin/locations/buildings');
    }
}
