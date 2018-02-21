@extends('layouts.installers')
@section('title')
    Booking for {{$booking->customer->username}}
@stop
@section('content')
    @if(Session::has('lateItem'))
        <br>
        <div class="alert alert-danger"><span class="glyphicon glyphicon-remove-circle"></span><em> {!! session('lateItem') !!}</em></div>
    @endif
    @if(Session::has('howManyDays'))
        <br>
        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('howManyDays') !!}</em></div>
    @endif
    <h1>Booking for {{$booking->customer->username}}</h1>
    <hr>
    <a href="#" id="showBooking"><span class="changeInfo">Show</span> Booking Info</a>
    <div id="bookingInfo">
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
    </div>
    <hr>
    <div id="installSecondary" class="row">
        <div class="col-xs-6">
            <span class="title">Latest Image</span>
            <img src="{{url('storage/' . $booking->asset->latest_image)}}" alt="" class="largeImage">
        </div>
        <div class="col-xs-6">
            <span class="title">Installer Form</span>
            <form method="POST" action="{{ url('/installers/install/' . $booking->id) }}" enctype="multipart/form-data" id="submit">

                <input type="hidden" id="book_id" name="book_id" value="{{$booking->id}}">
                <input type="hidden" id="asset_id" name="asset_id" value="{{$booking->asset->id}}">
                <input type="hidden" id="cust_id" name="cust_id" value="{{$booking->customer->id}}">
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
        $(document).ready(function() {
            populateSpecs();
            $('#showBooking').on('click', function() {
                let changeVal = "Show";
                if($('.changeInfo', this).text() === "Show") {
                    changeVal = "Hide";
                }
                $('#bookingInfo').stop().slideToggle(500);
                $('.changeInfo', this).text(changeVal);
            });
        });

        function populateSpecs() {
            let mainObj = '{!! $booking->asset->specifications !!}';
            mainObj = JSON.parse(mainObj);
            mainObj.forEach(function(elm) {
                $('.tags').append('<span class="tag"><strong>'+elm.slug+'</strong>: ' + elm.value);
            });

        }
    </script>
@stop