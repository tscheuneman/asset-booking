<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Asset;
use Cas;
use App\Region;
use App\Category;

class IndexController extends Controller
{
    public function index() {
        $assets = Asset::with('location.building', 'location.region', 'category')->get();
        $region = Region::orderBy('name', 'ASC')->get();

        $categories = Category::orderBy('name', 'ASC')->get();
        return view('index.map',
            [
                'assets' => $assets,
                'user' => Cas::user(),
                'region' => $region,
                'categories' => $categories
            ]
        );
    }
    public function show() {
        $assets = Asset::with('location.building', 'category')->get();
        return $assets;
    }

    public function campusShow() {
        $campus = Region::orderBy('name', 'ASC')->get();
        return $campus;
    }
}
