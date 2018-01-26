<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use Validator;
use Cas;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    public function bookings(Request $request)
    {

        $this->validate(request(), [
            'asset_id' => 'required|string|exists:assets,id',
        ]);

        $asset_id = request('asset_id');
        $date = date("Y-m-d H:i:s", strtotime('+3 months'));

        return Booking::where('asset_id', '=', $asset_id)->where('time_to', '<=', $date)->get();

    }

    public function store(Request $request, $id)
    {
        $returnData = array();
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            $returnData['status'] = 'Error';
            $returnData['message'] = 'Invalid Date';
            return json_encode($returnData);
        }



        $startDate = request('start_date');
        $endDate = request('end_date');

        if($startDate == date('Y-m-d') && $endDate == date('Y-m-d')) {
            $returnData['status'] = 'Error';
            $returnData['message'] = 'That is an invalid date!';
            return json_encode($returnData);
        }
        if($startDate > date('Y-m-d', strtotime('+3 months'))) {
            $returnData['status'] = 'Error';
            $returnData['message'] = 'That is an invalid date.  Not within allowed date range!';
            return json_encode($returnData);
        }

        $val = Booking::where('asset_id', '=', $id)->where('time_from', '>=', $startDate)->where('time_to', '<=', $endDate)->first();
        if($val === null) {
            if (Auth::check())
            {

                $user = Auth::id();
                $asset_id = $id;

                $startTime = date('Y-m-d H:i:s', strtotime($startDate));
                $endTime = date('Y-m-d H:i:s', strtotime($endDate));


                $booking = new Booking();
                    $booking->asset_id = $asset_id;
                    $booking->time_from = $startTime;
                    $booking->time_to = $endTime;
                    $booking->cust_id = $user;
                    $booking->save();

                $returnData['status'] = 'Success';
                $returnData['message'] = 'That time has been booked!';
                return json_encode($returnData);
            }
            else {
                return "Error, not logged in";
            }
        }
        else {
            $returnData['status'] = 'Error';
            $returnData['message'] = 'That time range is already booked!';
            return json_encode($returnData);
        }

    }

}
