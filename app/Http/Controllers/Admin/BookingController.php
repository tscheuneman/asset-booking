<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Booking;
use App\Asset;
use Validator;
use Cas;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminBaseController;
use App\Cart;
use App\CartEntry;
use Illuminate\Database\QueryException;

class BookingController extends AdminBaseController
{
    public function bookings(Request $request)
    {

        $this->validate(request(), [
            'asset_id' => 'required|string|exists:assets,id',
        ]);

        $asset_id = request('asset_id');
        $date = date("Y-m-d H:i:s", strtotime('+3 months'));

        $returnData['bookings'] = Booking::where('asset_id', '=', $asset_id)->where('time_to', '<=', $date)->where('active', '=', true)->get();
        $returnData['asset'] = Asset::with('location.building', 'location.region', 'category')->where('deleted_at', '=', null)->where('id', $asset_id)->first();
        return json_encode($returnData);

    }

    public function store(Request $request, $id)
    {
        $asset_id = $id;
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

        $val = Booking::where([
            ['asset_id', '=', $asset_id],
            ['active', '=', true]
        ])->where(function($q) use ($startDate, $endDate) {
            $q->whereBetween('time_from', [$startDate, $endDate])
                ->orWhereBetween('time_to', [$startDate, $endDate]);
        })->first();

        if (Auth::check()) {
                $user = Auth::id();

                $userCart = Booking::where([
                    ['asset_id', '=', $asset_id],
                    ['cust_id', '=', $user],
                    ['active', '=', true]
                ])->where(function($q) use ($startDate, $endDate) {
                    $q->whereBetween('time_from', [$startDate, $endDate])
                        ->orWhereBetween('time_to', [$startDate, $endDate]);
                })->first();

                if($userCart != null) {
                    $returnData['status'] = 'Error';
                    $returnData['message'] = 'This is already in your cart';
                    return json_encode($returnData);
                }
        }

        if($val === null) {
            if (Auth::check())
            {
                try {
                    $user = Auth::id();
                    $asset_id = $id;

                    $startTime = date('Y-m-d H:i:s', strtotime($startDate));
                    $endTime = date('Y-m-d H:i:s', strtotime($endDate));

                    try {
                        $cart = Cart::where('cust_id', $user)->first();
                        if (!$cart) {
                            $newCart = new Cart();
                            $newCart->cust_id = $user;
                            $newCart->save();
                            $cart_id = $newCart->id;
                        }
                        else {
                            $cart_id = $cart->id;
                        }

                    } catch(QueryException $e) {
                        $returnData['status'] = 'Error';
                        $returnData['message'] = 'Failed to add to cart';
                        return json_encode($returnData);
                    }

                    $booking = new Booking();
                    $booking->asset_id = $asset_id;
                    $booking->time_from = $startTime;
                    $booking->time_to = $endTime;
                    $booking->cust_id = $user;
                    $booking->save();

                    try {
                        $cartEntry = new CartEntry();
                        $cartEntry->booking_id = $booking->id;
                        $cartEntry->cart_id = $cart_id;
                        $cartEntry->save();
                    } catch(QueryException $e) {
                        $returnData['status'] = 'Error';
                        $returnData['message'] = 'Failed to add to cart2';
                        return json_encode($returnData);
                    }
                    $entry = CartEntry::with('booking.asset.location.building', 'booking.asset.location.region')->where('id', $cartEntry->id)->first();


                    return $entry;

                } catch(QueryException $e) {
                    $returnData['status'] = 'Error';
                    $returnData['message'] = 'Failed to create booking';
                    return json_encode($returnData);
                }

            }
            else {
                $returnData['status'] = 'Error';
                $returnData['message'] = 'Not logged In';
                return json_encode($returnData);
            }
        }
        else {
            $returnData['status'] = 'Error';
            $returnData['message'] = 'That time range is already booked!';
            return json_encode($returnData);
        }

    }

}
