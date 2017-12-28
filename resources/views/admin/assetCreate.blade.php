@extends('layouts.admin')
@section('title')
    Create Asset
@stop
@section('content')
    <h2>Create Asset</h2>
    <hr>
    <form method="POST" action="/admin/assets">
        {{csrf_field()}}


        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude" disabled required>
        </div>

        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude" disabled required>
        </div>

        <div class="form-group">
            <label for="building">Building</label>
            <input type="text" class="form-control" id="building" name="building">
        </div>

        <div class="form-group">
            <label for="campus">Campus</label>
            <input type="text" class="form-control" id="campus" name="campus" required>
        </div>

        <hr>


        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" name="category">
                @foreach($categories as $cat)
                <option value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="email">Image</label>
            <input type="file" accept="image/*;capture=camera">
        </div>



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