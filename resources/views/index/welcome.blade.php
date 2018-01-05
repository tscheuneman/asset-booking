@extends('layouts.default')
@section('title')
Test
@stop
@section('content')
    <sidebar id="sidebar">
        <div id="close">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
        <div id="sideContent">

        </div>
    </sidebar>
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
            center: new google.maps.LatLng(33.30516512, -111.67997360),
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

                        var returnVal = '<div class="overlayInfo">' +
                            '<img class="overlayImage" alt="Image '+msg.id+'" src="/storage/'+msg.latest_image+'" />' +
                            '<h4>'+msg.name+'</h4>' +
                            '<div class="sideInfo"><strong><i class="fa fa-building-o" aria-hidden="true"></i> Building: </strong>'+ msg.location.building.name + '</div>' +
                            '<div class="sideInfo"><strong><i class="fa fa-hospital-o" aria-hidden="true"></i> Campus: </strong>'+ msg.location.campus + '</div>' +
                            '<div class="sideInfo"><strong><i class="fa fa-folder-o" aria-hidden="true"></i> Category: </strong>'+ msg.category.name + '</div>' +
                            '<div class="sideInfo"><strong><i class="fa fa-tags" aria-hidden="true"></i> Specs </strong><br>'+ returnSpecs + '<span class="clearfix"></span></div>' +
                            '<br class="clear"><a href="#" class="bookLink">Book</a>' +
                            '</div>';

                        var sidebarWidth = $(window).width();
                        var modifier = .25;
                        if(sidebarWidth < 600) {
                            modifier = .80;
                        }
                        sidebarWidth = sidebarWidth * modifier;

                        $('sidebar#sidebar').addClass('clicked').animate({
                            width: sidebarWidth + 'px'
                        }, 500, function() {
                            $('sidebar#sidebar #sideContent').empty().append(returnVal).fadeIn(500);
                        });


                        /*
                        infowindow.setContent(returnVal);
                        infowindow.open(map, marker);
                        */
                    });

                }
            })(marker, i));
        }
    </script>
    <script>
        $(document).ready(function() {
            $('sidebar').on('click', '#close', function() {
                hideSidebar();
            });
        });

        var myElement = document.getElementById('sidebar');
        var swipeHide = new Hammer(myElement);
        swipeHide.on("panright", function(ev) {
            hideSidebar();
        });

        function hideSidebar() {
            $('#sideContent').fadeOut(500, function() {
                $('#sideContent').empty();
                $('sidebar#sidebar').removeClass('clicked').animate({
                    width: 0
                }, 500, function() {
                    //
                });

            });
        }
    </script>
    <!--
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtj2Hj9Nr7fZkBnfmbf8DgKnw0-dM1afg&callback=initMap">
    </script>
    -->
@stop