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

        \Session::flash('flash_created',request('name') . ' has been created');
        return redirect('/admin/locations/buildings');
    }


    public function edit($id)
    {
        $building = Building::find($id);
        return view('admin.buildingEdit',
            [
                'building' => $building
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'id' => 'exists:buildings',
            'name' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);
        $build = Building::find($id);
        $build->name = request('name');
        $build->longitude = request('longitude');
        $build->latitude = request('latitude');

        $build->save();

        \Session::flash('flash_created',request('name') . ' has been edited');
        return redirect('/admin/locations/buildings');
    }

    public function destroy($id)
    {
        $build = Building::find($id);
        $build_name = $build->name;
        $build->delete();

        \Session::flash('flash_deleted',$build_name . ' has been deleted');
        return redirect('/admin/locations/buildings');
    }

}
