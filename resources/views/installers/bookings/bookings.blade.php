@extends('layouts.installers')
@section('title')
    Booking for {{$booking->customer->username}}
@stop
@section('content')
    @if(Session::has('flash_deleted'))
        <div class="alert alert-warning"><span class="glyphicon glyphicon-remove-circle"></span><em> {!! session('flash_deleted') !!}</em></div>
    @endif
    @if(Session::has('flash_created'))
        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_created') !!}</em></div>
    @endif
    <br>
    <h1>Booking for {{$booking->customer->username}}</h1>
    <hr>
    <div class="blockData">
        <span class="title">Time </span>
        <div class="bookingTime">
            <strong>Booked At: </strong> {{date('Y-m-d h:i:s a', strtotime($booking->created_at))}}
            <br class="clear" />
            <div class="bookingTimeBooked">
                <strong>Booking Start: </strong> {{date('Y-m-d', strtotime($booking->time_from))}}
                <br/>
                <strong>Booking End: </strong> {{date('Y-m-d', strtotime($booking->time_to))}}
            </div>
        </div>
    </div>

    <div class="blockData">
        <span class="title">Customer </span>
        <div class="bookingTime">
            <strong>Customer Email: </strong> {{$booking->customer->email}}
        </div>
    </div>

    <div class="blockData">
        <span class="title">Location Info </span>
        <div class="bookingTime">
            <strong>Region: </strong> {{$booking->asset->location->region->name}}
            <br>
            <strong>Building: </strong> {{$booking->asset->location->building->name}}
            <br>
            <br>
            <a class="editAction" href="http://maps.google.com/?q={{$booking->asset->location->latitude}},{{$booking->asset->location->longitude}}" target="_blank">Open in Google Maps</a>
        </div>
    </div>

    <div class="blockData">
        <span class="title">Asset Info </span>
        <div class="bookingTime">
            <strong>Name: </strong> {{$booking->asset->name}}
            <br>
            <strong>Specifications: </strong>
            <div class="tags">

            </div>
        </div>
    </div>
    <br class="clear" />
    <hr>
    <div id="installSecondary" class="row">
        <div class="col-xs-6">
            <span class="title">Latest Image</span>
            <img src="{{url('storage/' . $booking->asset->latest_image)}}" alt="" class="largeImage">
        </div>
        <div class="col-xs-6">
            <span class="title">Installer Form</span>
            <form method="POST" action="{{ url('/installers/install/' . $booking->id) }}" enctype="multipart/form-data" id="submit">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="installer">Installer</label>
                    <input type="text" class="form-control" id="installer" name="installer" value="{{$installer}}" required>
                </div>

                <div class="form-group">
                    <label for="image">Update Image</label>
                    <input type="file" class="form-control-file" name="image" id="image" accept="image/*;capture=camera" required>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" class="form-control" id="notes" rows="5"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <br><br>
                @include('layouts.errors')

            </form>
        </div>
    </div>


    <script>
        populateSpecs();
        function populateSpecs() {
            let mainObj = '{!! $booking->asset->specifications !!}';
            mainObj = JSON.parse(mainObj);
            mainObj.forEach(function(elm) {
                $('.tags').append('<span class="tag"><strong>'+elm.slug+'</strong>: ' + elm.value);
            });

        }
    </script>
@stop