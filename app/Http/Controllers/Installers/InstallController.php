<?php

namespace App\Http\Controllers\Installers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Asset;
use Cas;
use File;
use App\Jobs\ProcessImage;
use App\Installation;

class InstallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(Request $request, $id)
    {
        $this->validate(request(), [
            'book_id' => 'required|string|exists:bookings,id',
            'asset_id' => 'string|required|exists:assets,id',
            'cust_id' => 'string|required|exists:users,id',
            'installer' => 'required|string|exists:installers,username',
            'notes' => 'nullable|string',
            'image' => 'required|image',
        ]);

        try {
            $path = $request->file('image')->store(
                'images/', 'public'
            );
        }
        catch(Exception $e) {
            \Session::flash('flash_deleted',request('name') . ' Error uploading file');
            return redirect('/admin/assets');
        }

        try {

            $asset = Asset::find(request('asset_id'));
            File::delete(public_path() . '/storage/' . $asset->latest_image);
            $asset->latest_image = $path;
            ProcessImage::dispatch($path, 500, 60);

            $asset->save();

            $booking = Booking::find($id);
                $booking->active = false;
                $booking->save();

             $installation = new Installation();
                $installation->customer_id = request('cust_id');
                $installation->asset_id = request('asset_id');
                $installation->booking_id = request('book_id');
                $installation->save();

            \Session::flash('flash_created', 'Asset has been installed');
            return redirect('/installers');
        } catch(QueryException $e) {
            \Session::flash('flash_deleted','Error Installing');
            return redirect('/installers/install/' . $id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::with('asset', 'asset.location.building', 'asset.location.region', 'customer')->find($id);
        $installer = Cas::user();
        \Session::flush('lateItem');
        if(date('Y-m-d', strtotime($booking->time_from)) < date('Y-m-d')) {
            $currentTime = time();
            $dueTime = strtotime($booking->time_from);
            $datediff = $currentTime - $dueTime;

            \Session::flash('lateItem', 'This item is currently '.round($datediff / (60 * 60 * 24)).' days late');
        }
        else {
            $currentTime = time();
            $dueTime = strtotime($booking->time_from);
            $datediff = $currentTime - $dueTime;
            \Session::flash('howManyDays', round($datediff / (60 * 60 * 24)) . ' days until this is due');
        }
        return view('installers.bookings.bookings',
            [
                'booking' => $booking,
                'installer' => $installer
            ]
        );
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
