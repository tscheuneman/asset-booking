<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Region;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    public function index() {
        $region = Region::paginate(25);
        return view('admin.regions.regions',
            [
                'regions' => $region
            ]
        );
    }

    public function create() {
        return view('admin.regions.regionCreate');
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

        \Session::flash('flash_created',request('name') . ' has been created');
        return redirect('/admin/locations/regions');
    }

    public function edit($id)
    {
        $region = Region::find($id);
        return view('admin.regions.regionEdit',
            [
                'region' => $region
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'id' => 'exists:regions',
            'name' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        try {
            $region = Region::find($id);

            $region->name = request('name');
            $region->longitude = request('longitude');
            $region->latitude = request('latitude');

            $region->save();

            \Session::flash('flash_created',request('name') . ' has been edited');
            return redirect('/admin/locations/regions');
        } catch(QueryException $e) {
            \Session::flash('flash_deleted','Error editing region');
            return redirect('/admin/locations/regions');
        }

    }

    public function destroy($id)
    {
        try {
            $region = Region::find($id);
            $region_name = $region->name;
            $region->delete();

            \Session::flash('flash_deleted',$region_name . ' has been deleted');
            return redirect('/admin/locations/regions');
        } catch(QueryException $e) {
            \Session::flash('flash_deleted','Error deleting region');
            return redirect('/admin/locations/regions');
        }

    }

}
