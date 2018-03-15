@extends('layouts.admin')
@section('title')
    Create Asset
@stop
@section('content')
    <h2>Create Asset</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/assets') }}" enctype="multipart/form-data" id="submit">
        {{csrf_field()}}


        <div id="map" style="height:300px; width:100%; position:relative; margin:0 auto 15px auto;">
         </div>

        <div class="form-group" style="display:none">
            <label for="longitude">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude" readonly required>
        </div>

        <div class="form-group" style="display:none">
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
            <label for="image">Image</label>
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

        <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API')}}"></script>
    <script>

    </script>
    <script>
        $(document).ready(function() {
            //Load Specs
            getSpecs();
            //On category change, load specs again
            $('select#category').on('change', function() {
                getSpecs();
            });

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

        let options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };

        function success(pos) {
            let crd = pos.coords;
            $('#latitude').val(crd.latitude);
            $('#longitude').val(crd.longitude);

            getBuildingRegion(crd.latitude, crd.longitude);

            createMap(crd.latitude, crd.longitude);
        }

        function error() {
            alert("Could not find location");
        }

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

        function createMap(lat, lng) {
            let map = new google.maps.Map(document.getElementById('map'), {
                zoom: 18,
                center: new google.maps.LatLng(lat, lng),
                mapTypeId: 'satellite',
                mapTypeControlOptions: {
                    mapTypeIds: ['ASUCampus', 'satellite']
                }
            });

            var asuCampusMappings = new google.maps.ImageMapType({
                getTileUrl: function(coord, zoom) {
                    var normalizedCoord = getNormalizedCoord(coord, zoom);
                    if (!normalizedCoord) {
                        return null;
                    }
                    var bound = Math.pow(2, zoom);
                    var url = 'https://d1gntqhqj0rbcs.cloudfront.net/assets/120/mrg_labels227/' +
                        '/' + zoom + '/' + normalizedCoord.x + '/' +
                        (bound - normalizedCoord.y - 1) + '.png';
                    return url;
                },
                tileSize: new google.maps.Size(256, 256),
                maxZoom: 25,
                minZoom: 14,
                radius: 1738000,
                name: 'ASUCampus'
            });

            map.overlayMapTypes.insertAt(0, asuCampusMappings);


            $('<div/>').addClass('centerMarker').appendTo(map.getDiv());

            let noPoi = [
                {
                    featureType: "poi.business",
                    stylers: [
                        {
                            visibility: "off"
                        }
                    ]
                }
            ];

            map.setOptions({styles: noPoi});

            google.maps.event.addListener(map, 'dragend', function() {
                let currentLatitude = map.getCenter().lat();
                let currentLongitude = map.getCenter().lng();

                $('#latitude').val(currentLatitude);
                $('#longitude').val(currentLongitude);

                getBuildingRegion(currentLatitude, currentLongitude);
            });

        }

        function getNormalizedCoord(coord, zoom) {
            var y = coord.y;
            var x = coord.x;

            // tile range in one direction range is dependent on zoom level
            // 0 = 1 tile, 1 = 2 tiles, 2 = 4 tiles, 3 = 8 tiles, etc
            var tileRange = 1 << zoom;

            // don't repeat across y-axis (vertically)
            if (y < 0 || y >= tileRange) {
                return null;
            }

            // repeat across x-axis
            if (x < 0 || x >= tileRange) {
                x = (x % tileRange + tileRange) % tileRange;
            }

            return {x: x, y: y};
        }

        function getBuildingRegion(lat, lng) {
            $.ajax({
                method: "GET",
                url: "{{ url('/admin/location/verify') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'lat': lat,
                    'lng': lng
                }
            }).done(function( msg ) {
                $('#building').empty();
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
        }
    </script>
@stop