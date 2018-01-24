<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function bookings(Request $request)
    {
        $this->validate(request(), [
            'id' => 'exists:assets',
        ]);
        return request('asset_id');

    }
}
