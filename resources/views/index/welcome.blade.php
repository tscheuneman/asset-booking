@extends('layouts.default')
@section('title')
Test
@stop
@section('content')
    <div id="center" style="position:absolute; z-index:999; top:25px; right:25px;">
        <a style="padding:15px; background:#8C1D40; color:#fff;" href="#">TEST</a>
    </div>
    <div id="map" style="height:100%; width:100%; position:absolute;">

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript">
        var locations = [
            @foreach($assets as $asset)
                ['{{$asset->id}}', {{$asset->location->latitude}}, {{$asset->location->longitude}}],
            @endforeach
        ]
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: new google.maps.LatLng(33.42156600, -111.92525500),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var noPoi = [
            {
                featureType: "poi",
                stylers: [
                    { visibility: "off" }
                ]
            }
        ];

        map.setOptions({styles: noPoi});

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    $.ajax({
                        method: "GET",
                        url: "{{ url('/asset') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'id': locations[i][0]
                        }
                    }).done(function( msg ) {
                        var specs = JSON.parse(msg.specifications);
                        var returnSpecs = '';
                        for (var k in specs){
                            if (specs.hasOwnProperty(k)) {
                                returnSpecs += '<span class="specItem"><strong>' + k + ': </strong> ' + specs[k] + '</span>';
                            }
                        }

                        var returnVal = '<div>' +
                            '<h4>Sign at '+msg.location.building.name+'</h4>' +
                            '<img class="overlayImage" alt="Image '+msg.id+'" src="/storage/'+msg.latest_image+'" />' +
                            '<strong>Building: </strong>'+ msg.location.building.name +
                            '<br><strong>Campus: </strong>'+ msg.location.campus +
                            '<br><strong>Category: </strong>'+ msg.category.name +
                            '<hr><strong> Specs </strong><br>'+ returnSpecs +
                            '<br class="clear"><a href="#" class="bookLink">Book</a>' +
                            '</div>';


                        infowindow.setContent(returnVal);
                        infowindow.open(map, marker);
                    });

                }
            })(marker, i));
        }
    </script>
    <!--
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtj2Hj9Nr7fZkBnfmbf8DgKnw0-dM1afg&callback=initMap">
    </script>
    -->
@stop