<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Asset;
use Cas;
use App\Region;
use App\Category;
use App\User;
use App\Booking;

class IndexController extends Controller
{
    public function index() {
        $user = User::where('username', cas()->user())->first(['id']);
        return view('index.map',
            [
                'user' => $user,
            ]
        );
    }

    public function approval() {
        return view('index.approval');
    }

    public function getUser($id) {
        $user = User::find($id)->first(['id', 'first_name', 'last_name', 'department', 'agency_org', 'email']);
        return $user;
    }


    public function show() {
        $assets = Asset::with('location.building', 'category')->get();
        return $assets;
    }

    public function campusShow() {
        $campus = Region::orderBy('name', 'ASC')->get();
        return $campus;
    }

    public function userShow($username) {
        $date = date('Y-m-d');
        $user = User::select('id', 'username')->where('username', '=', $username)->first();
        $bookings = Booking::with('asset.publicLocation.publicBuilding', 'asset.publicCategory', 'asset.publicLocation.publicRegion')
            ->where('cust_id', '=', $user->id)->where('time_from', '>=', $date)->get();

        return view('index.user',
            [
                'user' => $user->username,
                'booking' => $bookings
            ]
        );
    }
}
