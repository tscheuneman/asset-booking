@extends('layouts.admin')
@section('title')
    Edit Region
@stop
@section('content')
    <h2>Edit {{$region->name}}</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/locations/region') }}/{{$region->id}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" value="{{$region->id}}">
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude" required value="{{$region->longitude}}">
        </div>

        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude" required value="{{$region->latitude}}">
        </div>

        <div class="form-group">
            <label for="name">Region Name</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{$region->name}}">
        </div>

        <hr>

        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
        <br><br> <br><br> <br><br>
        <div type="submit" class="btn btn-warning getCurr">Get Current Location</div>

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

        $(document).ready(function() {
            $('.getCurr').on('click', function() {
                navigator.geolocation.getCurrentPosition(success, error, options);
            });
        });



    </script>
@stop