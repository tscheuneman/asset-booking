<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Asset;
use Cas;
use App\Campus;

class IndexController extends Controller
{
    public function index() {
        $assets = Asset::with('location.building', 'category')->get();
        $campus = Campus::orderBy('name', 'ASC')->get();
        return view('index.map',
            [
                'assets' => $assets,
                'user' => Cas::user(),
                'campus' => $campus
            ]
        );
    }
    public function show() {
        $assets = Asset::with('location.building', 'category')->get();
        return $assets;
    }

    public function campusShow() {
        $campus = Campus::orderBy('name', 'ASC')->get();
        return $campus;
    }
}
