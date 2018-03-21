<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Building;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;
use App\Http\Controllers\Controller;


class BuildingController extends Controller
{
    public function index() {
        $buildings = Building::where('deleted_at', '=', null)->paginate(config('adminSettings.entries-per-page'));

        if($keyword = Input::get('keyword', '')) {
            $buildings = Building::SearchBuilding($keyword)->paginate(config('adminSettings.entries-per-page'));

        }

        return view('admin.buildings.buildings',
            [
                'buildings' => $buildings
            ]
        );
    }
    public function create() {
        return view('admin.buildings.buildingCreate');
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
        return view('admin.buildings.buildingEdit',
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
        try {
            $build = Building::find($id);
            $build->name = request('name');
            $build->longitude = request('longitude');
            $build->latitude = request('latitude');

            $build->save();

            \Session::flash('flash_created',request('name') . ' has been edited');
            return redirect('/admin/locations/buildings');
        } catch(QueryException $e) {
            \Session::flash('flash_deleted','Error editing building');
            return redirect('/admin/locations/buildings');
        }

    }

    public function destroy($id)
    {
        try {
            $build = Building::find($id);
            $build_name = $build->name;

            $build->deleted_at = date('Y-m-d H:i:s');
            $build->save();

            \Session::flash('flash_deleted',$build_name . ' has been deleted');
            return redirect('/admin/locations/buildings');
        } catch(QueryException $e) {
            \Session::flash('flash_deleted','Error: deleting building');
            return redirect('/admin/locations/buildings');
        }

    }


}
