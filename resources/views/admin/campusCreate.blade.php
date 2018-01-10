@extends('layouts.admin')
@section('title')
    Create Campus
@stop
@section('content')
    <h2>Create Campus</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/locations/campus') }}" enctype="multipart/form-data">
        {{csrf_field()}}


        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude" readonly required>
        </div>

        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude" readonly required>
        </div>

        <div class="form-group">
            <label for="name">Campus Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <hr>

        <button type="submit" class="btn btn-primary">Submit</button>

        @include('layouts.errors')

    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        var options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };

        function success(pos) {
            var crd = pos.coords;
            $('#latitude').val(crd.latitude);
            $('#longitude').val(crd.longitude);

        };

        function error(err) {
            console.warn(`ERROR(${err.code}): ${err.message}`);
        };

        navigator.geolocation.getCurrentPosition(success, error, options);



    </script>
@stop