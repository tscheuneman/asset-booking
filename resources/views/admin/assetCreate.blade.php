@extends('layouts.admin')
@section('title')
    Create Asset
@stop
@section('content')
    <h2>Create Asset</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/assets') }}" enctype="multipart/form-data" id="submit">
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
            <input type="hidden" class="form-control" id="specs" name="specs">
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
            <input type="file" class="form-control-file" name="image" id="image" accept="image/*;capture=camera" required>
        </div>

        <hr>
        <h3>Specs</h3>
        <br>
        <div id="specifications">

        </div>
        <hr>
        <br style="clear:both;" /><br />

        <button type="submit" class="btn btn-primary">Submit</button>
        <br><br>
        @include('layouts.errors')

    </form>

    <script>
        $(document).ready(function() {
            //Load Specs
            getSpecs();
            //On category change, load specs again
            $('select#category').on('change', function() {
                getSpecs();
            })

            $('#submit').submit(function() {
                let obj = [];
                try {
                    $('#specifications .specification').each(function() {
                        let elm = $(this);
                        let item = {};
                        let slug = $(this).data('slug');
                        item['id'] = $(this).data('id');
                        item['slug'] = slug;
                        item['value'] = $('#'+slug, elm).val();
                        obj.push(item);
                    });
                    let returnObj = JSON.stringify(obj);
                    $('#specs').val(returnObj);
                }
                catch(err) {
                    return false;
                }

            });
        });
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
                $('#region').val(msg.region.name).prop('readonly', true);

                msg.building.forEach(function(element) {
                    $('#building').append($('<option>', {
                        value: element.id,
                        text: element.name
                    }));
                });

                $('#buildingID').val(msg.building.id);
                $('#campusID').val(msg.region.id);

             });
        };

        function error(err) {
            console.warn(`ERROR(${err.code}): ${err.message}`);
        };

        navigator.geolocation.getCurrentPosition(success, error, options);


        function getSpecs() {
            let selectedCat = $('#category').val();

            $.ajax({
                method: "POST",
                url: "{{ url('/admin/asset/specifications') }}/" + selectedCat,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': selectedCat,
                }
            }).done(function( msg ) {
                let obj = JSON.parse(msg);
                clearSpecs();
                obj.forEach(function(element) {
                    createSpec(element);
                });
            });
        }

        function clearSpecs() {
            $('#specifications').empty();
        }

        function createSpec(elm) {
            let returnElm = '<div class="form-group specification" data-id="'+elm.id+'" data-slug="'+elm.slug+'">'+
                '<label for="'+elm.slug+'">'+elm.name+'</label>';
            if(elm.type === "text" || elm.type === "number") {
                returnElm += '<input type="'+elm.type+'" class="form-control" id="'+elm.slug+'" name="'+elm.slug+'" value="'+elm.default+'">';
            }
            if(elm.type === "select") {
                returnElm += '<select class="form-control" id="'+elm.slug+'" name="'+elm.slug+'">';
                let options = JSON.parse(elm.options);
                options.forEach(function(option) {
                    if(option.value === elm.default) {
                        returnElm += '<option value="'+option.value+'" selected>'+option.label+'</option>';
                    }
                    else {
                        returnElm += '<option value="'+option.value+'">'+option.label+'</option>';
                    }
                });
                returnElm += '</select>';
            }
            returnElm += '</div>';

            $('#specifications').append(returnElm);
        }
    </script>
@stop