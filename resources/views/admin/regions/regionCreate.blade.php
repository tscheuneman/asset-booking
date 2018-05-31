@extends('layouts.admin')
@section('title')
    Create Region
@stop
@section('content')
    <h2>Create Region</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/locations/region') }}" enctype="multipart/form-data" id="submit">
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
            <label for="name">Region Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <hr />

        <button type="submit" class="btn btn-primary">Submit</button>

        @include('layouts.errors')

    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        let options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };

        function success(pos) {
            let crd = pos.coords;
            $('#latitude').val(crd.latitude);
            $('#longitude').val(crd.longitude);

        }

        function error(err) {
            console.warn(`ERROR(${err.code}): ${err.message}`);
        }

        navigator.geolocation.getCurrentPosition(success, error, options);



    </script>
@stop