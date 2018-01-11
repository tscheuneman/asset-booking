@extends('layouts.admin')
@section('title')
    Create Asset
@stop
@section('content')
    <h2>Create Asset</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/assets') }}" enctype="multipart/form-data">
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
            <label for="building">Building</label>
            <select class="form-control" id="building" name="building">

            </select>
        </div>

        <div class="form-group">
            <label for="region">Region</label>
            <input type="text" class="form-control" id="region" name="region" readonly required>
        </div>

            <input type="hidden" class="form-control" id="campusID" name="regionID">

        <hr>

        <div class="form-group">
            <label for="name">Asset Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

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
            <input type="file" class="form-control-file" name="image" id="image" accept="image/*;capture=camera">
        </div>

        <hr>
        <h3>Specs</h3>
        <br>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="height">Height</label>
                <input type="text" class="form-control" id="height" name="height">
            </div>
            <div class="form-group col-md-6">
                <label for="width">Width</label>
                <input type="text" class="form-control" id="width" name="width">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="color">Color</label>
                <select class="form-control" id="color" name="color">
                    <option>N/A</option>
                    <option>One Sided, B&W</option>
                    <option>Two Sided, B&W</option>
                    <option>One Sided, Color</option>
                    <option>Two Sided, Color</option>
                    <option>Two, B&W & Color</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="material">Material</label>
                <select class="form-control" id="material" name="material">
                    <option>N/A</option>
                    <option>Canvas</option>
                    <option>Metal</option>
                    <option>Wood</option>
                    <option>Vinyl Wrap</option>
                </select>
            </div>
        </div>
        <hr>
        <br style="clear:both;" /><br />

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
            $.ajax({
                method: "GET",
                url: "{{ url('/admin/location/verify') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'lat': crd.latitude,
                    'lng': crd.longitude
                }
            }).done(function( msg ) {
                $('#campus').val(msg.campus.name).prop('readonly', true);

                msg.building.forEach(function(element) {
                    $('#building').append($('<option>', {
                        value: element.id,
                        text: element.name
                    }));
                });

                $('#buildingID').val(msg.building.id);
                $('#campusID').val(msg.campus.id);

             });
        };

        function error(err) {
            console.warn(`ERROR(${err.code}): ${err.message}`);
        };

        navigator.geolocation.getCurrentPosition(success, error, options);



    </script>
@stop