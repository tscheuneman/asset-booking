<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;

class BookingController extends Controller
{
    public function bookings(Request $request)
    {

        $this->validate(request(), [
            'asset_id' => 'required|integer|exists:assets,id',
        ]);

        $asset_id = request('asset_id');
        $date = date("Y-m-d H:i:s", strtotime('+3 months'));

        return Booking::where('asset_id', '=', $asset_id)->where('time_to', '<=', $date)->get();

    }
}
