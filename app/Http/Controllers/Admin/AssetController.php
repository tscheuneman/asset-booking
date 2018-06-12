<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use Illuminate\Http\Request;
use App\Asset;
use App\Category;
use App\Location;
use App\Building;
use App\User;
use File;
use App\Jobs\ProcessImage;
use Mockery\Exception;
use App\Http\Controllers\AdminBaseController;
use Illuminate\Support\Facades\Auth;


class AssetController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::with('location.building', 'category.parentcatrecursive', 'location.region')->where('deleted_at', '=', null)->paginate(config('globalSettings.entries-per-page'));
        return view('admin.assets.assets',
            [
                'assets' => $assets
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Category::with('subcats.subcats')->where('toplevel', '=', true)->get(['id', 'name']);
        $dept = Department::get(['id', 'name']);
        return view('admin.assets.assetCreate',
            [
                'cat' => $cat,
                'dept' => $dept
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'building' => 'required|string|exists:buildings,id',
            'regionID' => 'string|required|exists:regions,id',
            'name' => 'required',
            'category' => 'required|string|exists:categories,id',
            'department' => 'nullable|exists:departments,id',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'color' => 'nullable',
            'material' => 'nullable',
            'image' => 'required|image',
            'specs' => 'json'
        ]);

        $specs = request('specs');

        try {
            $path = $request->file('image')->store(
                'images/', 'public'
            );
        }
        catch(Exception $e) {
            \Session::flash('flash_deleted',request('name') . ' Error uploading file');
            return redirect('/admin/assets');
        }

        $asset = new Asset();
        $location = new Location();

        $specification = $specs;

        $location->longitude = request('longitude');
        $location->latitude = request('latitude');
        $location->building_id = request('building');
        $location->asset_id = 0;
        $location->region_id = request('regionID');
        $location->save();
        $locationID = $location->id;

        $asset->cat_id = request('category');
        $asset->name = request('name');
        $asset->location_id = $locationID;
        if($request->department == null) {
            $asset->department_id = null;
        }
        else {
            $asset->department_id = $request->department;
        }

        $asset->specifications = $specification;
        $asset->latest_image = $path;
        $asset->save();

        $location->asset_id = $asset->id;

        $location->save();

        ProcessImage::dispatch($path, 500, 60);
        \Session::flash('flash_created',request('name') . ' has been created');
        return redirect('/admin/assets');


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
        $asset = Asset::with('location.building', 'category', 'location.region')->where('id', '=', $id)->first();
        $cat = Category::with('subcats.subcats')->where('toplevel', '=', true)->get(['id', 'name']);
        $dept = Department::get(['id', 'name']);
        return view('admin.assets.assetEdit',
            [
                'cat' => $cat,
                'asset' => $asset,
                'dept' => $dept
            ]
        );
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



        $this->validate(request(), [
            'id' => 'required|exists:assets',
            'loc_id' => 'required|exists:locations,id',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'building' => 'required|string|exists:buildings,id',
            'regionID' => 'string|required|exists:regions,id',
            'name' => 'required',
            'category' => 'required|string',
            'department' => 'nullable|exists:departments,id',
            'image' => 'image',
            'specs' => 'json'
        ]);

        $specs = request('specs');

        if(request('image') != null) {
            try {
                $path = $request->file('image')->store(
                    'images/', 'public'
                );
            }
            catch(Exception $e) {
                \Session::flash('flash_deleted',request('name') . ' Error uploading file');
                return redirect('/admin/assets');
            }
        }

        $specification = $specs;

        try {
            $asset = Asset::find($id);
            $location = Location::find(request('loc_id'));

            $location->longitude = request('longitude');
            $location->latitude = request('latitude');
            $location->building_id = request('building');
            $location->asset_id = $id;
            $location->region_id = request('regionID');
            $location->save();
            $locationID = $location->id;


            $asset->cat_id = request('category');
            $asset->name = request('name');
            $asset->location_id = $locationID;
            $asset->specifications = $specification;
            if($request->department == null) {
                $asset->department_id = null;
            }
            else {
                $asset->department_id = $request->department;
            }

            if(request('image') != null) {
                File::delete(public_path(). '/storage/' .$asset->latest_image);
                $asset->latest_image = $path;
                ProcessImage::dispatch($path, 500, 60);
            }
            $asset->save();


            \Session::flash('flash_created',request('name') . ' has been edited');
            return redirect('/admin/assets');
        } catch(QueryException $e) {
            \Session::flash('flash_deleted','Error editing asset');
            return redirect('/admin/assets');
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $asset = Asset::find($id);
            $asset_name = $asset->name;

            $location = Location::where('asset_id', '=', $asset->id)->first();

            $asset->deleted_at = date('Y-m-d H:i:s');
            $asset->save();

            $location->deleted_at = date('Y-m-d H:i:s');
            $location->save();


            \Session::flash('flash_deleted',$asset_name . ' has been deleted');
            return redirect('/admin/assets');
        } catch(QueryException $e) {
            \Session::flash('flash_deleted', 'Error deleting asset');
            return redirect('/admin/assets');
        }


    }

    /**
     * Get all assets belonging to user deptartment.
     *
     *
     * @return \App\Asset[]
     */
    public function getAllAssets() {
        $depts=array();
        $user = User::with('departments')->where('id', Auth::id())->first();
        foreach($user->departments as $dept) {
            $depts[] = $dept->department_id;

        }
        return Asset::with('loclonglat', 'catmarker')->where('deleted_at', '=', null)->whereIn('department_id', $depts)->orWhere('department_id', null)->select('id', 'cat_id', 'location_id')->get();
    }
}
