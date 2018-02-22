<?php

namespace App\Http\Controllers\Installers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Booking;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pendingBookings = Booking::where('active', true)->count();
        $lateBookings = Booking::where('active', true)->where('time_from', '<', date('Y-m-d'))->count();
        $bookingInfo = Booking::with('asset.location.building', 'asset.location.region', 'customer')->where('active', true)->where('time_from', '<=', date('Y-m-d', strtotime('+7 days')))->orderBy('time_from', 'asc')->get();
        return view('installers.main',
            [
                'pendingBookings' => $pendingBookings,
                'lateBookings' => $lateBookings,
                'bookingInfo' => $bookingInfo
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function error()
    {
        return view('installers.error');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
