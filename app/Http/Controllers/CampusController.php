<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campus;

class CampusController extends Controller
{
    public function index() {
        $campuses = Campus::get();
        return view('admin.campuses',
            [
                'campuses' => $campuses
            ]
        );
    }

    public function create() {
        return view('admin.campusCreate');
    }

    public function store() {
        $campus = new Campus();

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
