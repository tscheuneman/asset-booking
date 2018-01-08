<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Asset;
use Cas;

class IndexController extends Controller
{
    public function index() {
        $assets = Asset::with('location')->get();
        return view('index.map',
            [
                'assets' => $assets
            ]
        );
    }
    public function show() {
        $assets = Asset::with('location')->get();
        return $assets;
    }
}
