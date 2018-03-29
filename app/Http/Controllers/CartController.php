<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\CartEntry;
use Validator;
use App\Booking;


use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index() {
        $user = Auth::id();
        $cart = Cart::where('cust_id', $user)->first();
        $entries = CartEntry::with('booking.asset.location.building', 'booking.asset.location.region')->where('cart_id', $cart->id)->where('deleted_at', '=', null)->get();
        return $entries;
    }


    public function count()
    {
        $user = Auth::id();

        $cart = Cart::where('cust_id', $user)->first();
        if($cart) {
            $cartItems = CartEntry::where('cart_id', $cart->id)->count();
            return $cartItems;
        }

    }

    public function destroy(Request $request)
    {

        $returnData = array();
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:bookings',
        ]);

        $book_id = request('id');

        if ($validator->fails()) {
            $returnData['status'] = 'Error';
            $returnData['message'] = 'Invalid Booking';
            return json_encode($returnData);
        }

        try {
            $booking = Booking::find($book_id);
            $cartEntry = CartEntry::where('booking_id', $book_id)->first();

            $booking->deleted_at = date('Y-m-d H:i:s');
            $booking->save();

            $cartEntry->deleted_at = date('Y-m-d H:i:s');
            $cartEntry->save();

            $returnData['status'] = 'Success';
            $returnData['message'] = 'Booking has been deleted';
            return json_encode($returnData);

        } catch(Exception $e) {
            $returnData['status'] = 'Error';
            $returnData['message'] = 'Invalid Booking';
            return json_encode($returnData);
        }
    }

    public function checkout(Request $request) {
        $data = json_decode(request('data'));

        $badReturn = false;
        $today = date('Y-m-d', strtotime('+3 weekdays'));
        $badBookings = array();
        $invalidCnt = 0;
        foreach($data as $entry) {
            if(date('Y-m-d', strtotime($entry->booking->time_from)) <= $today) {
                $badReturn = true;
                $badBookings[] = $entry->booking->id;
                $invalidCnt++;
            }
        }
        if($badReturn) {
            $returnData['status'] = 'Invalid';
            $returnData['message'] = 'You have ' . $invalidCnt . ' invalid entries.  These entries have been removed from your card.  Please try again';
            $returnData['data'] = $badBookings;
            return json_encode($returnData);
        }
        return $badBookings;
    }
}
