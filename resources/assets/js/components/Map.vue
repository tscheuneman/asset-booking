<template>
    <div id="container">
        <sidebar>
            <div id="close"
                :clickable="true" @click="closeSidebar()"
            >
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
            <div id="sideContent">

            </div>
            <input type="text" id="book" class="form-control book" readonly />
            <a href="#" class="bookLink">Book</a>
        </sidebar>
        <gmap-map
                :center="center"
                :zoom="15"
                style="width: 100%; height: 100%; position:absolute;"
                :options="options"
        >
            <gmap-cluster :maxZoom="17">
                <gmap-marker
                        :key="i"
                        v-for="(m,i) in markers"
                        :position="m.position"
                        :icon="m.icon"
                        :clickable="true" @click="toggleInfoWindow(m,i)
        "></gmap-marker>
            </gmap-cluster>

        </gmap-map>
    </div>
</template>

<script>
    import * as moment from 'moment';
    let bookingData = [];
    let selectedElement = null;
    $(document).ready(function() {
        $('sidebar').on('click', 'a.bookLink', function() {
            let drp = $('#book').data('daterangepicker');
            let startDate = drp.startDate.format("YYYY-MM-DD")
            let endDate = drp.endDate.format("YYYY-MM-DD");

            $.ajax({
                method: "POST",
                url: "/booking/" + selectedElement,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'start_date': startDate,
                    'end_date': endDate
                }
            }).done(function( msg ) {
                let returnData = JSON.parse(msg);
                if(returnData.status === "Error") {
                    alert(returnData.message);
                }
                else {
                    alert(returnData.message);
                    toggleSidebar();
                }
            });
        });
        let d = new Date();
        let strDate = (d.getMonth()+1) + "/" + d.getDate() + "/" + d.getFullYear();
        let strDateFuture = (d.getMonth()+4) + "/" + d.getDate() + "/" + d.getFullYear();
        $('#book').daterangepicker({
            "minDate": strDate,
            "maxDate": strDateFuture,
            "autoUpdateInput": false,
            "opens": "left",
            "dateLimit": {
                "days": 14
            },
            "isInvalidDate": function (date) {
                let returnVal = false;
                bookingData.forEach(function(element) {

                    let disabled_start = moment(element.time_from);
                    let disabled_end = moment(element.time_to);
                    if(date.isSameOrAfter(disabled_start) && date.isSameOrBefore(disabled_end)) {
                        returnVal = true;
                        return;
                    }
                });
                return returnVal;
            }
        });

        $('#book').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('#book').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });

    let theData = '';
    /////////////////////////////////////////
    // New in 0.4.0
    import * as VueGoogleMaps from 'vue2-google-maps';

    import axios from 'axios';

    Vue.use(VueGoogleMaps, {
        load: {
            key: 'AIzaSyDUQZsAMgprVk1i-buRKqZ2PDM8GRKr9W0',
            // libraries: 'places', //// If you need to use place input
        }
    });

    export default {
        props: {
            assets: Array
        },
        data () {
            return {
                center: {lat: 10.0, lng: 10.0},
                infoContent: '',
                infoWindowPos: {
                    lat: 0,
                    lng: 0
                },
                options: {
                    disableDefaultUI: false,
                    styles: [{"elementType":"labels.icon","stylers":[{"visibility":"off"}]}]
                },
                infoWinOpen: false,
                currentMidx: null,
                //optional: offset infowindow so it visually sits nicely on top of our marker
                markers: []
            }
        },
        mounted(){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    this.center.lat = pos.lat;
                    this.center.lng = pos.lng;

                }.bind(this));
            }
            theData = this.assets;
            let arrayVal = [];
            for(let i = 0; i < theData.length; i++) {
                let item = {
                    id: theData[i].id,
                    position: {
                        lat: theData[i].location.latitude,
                        lng: theData[i].location.longitude,
                    },
                    icon: '/storage/' + theData[i].category.marker_img
                };
                arrayVal.push(item);
            }
            this.markers = arrayVal;
        },
        created() {
            let self = this;
            theData = self.assets;
                Vue.bus.on('changeCenter', function(element) {
                    self.center.lat = element.latitude;
                    self.center.lng = element.longitude;
                });
                Vue.bus.on('filterMarkers', function(element) {
                    let arrayVal = [];
                    for(let x = 0; x < element.length; x++) {
                        for(let i = 0; i < theData.length; i++) {
                            if(theData[i].id === element[x]) {
                                let item = {
                                    id: theData[i].id,
                                    position: {
                                        lat: theData[i].location.latitude,
                                        lng: theData[i].location.longitude
                                    },
                                    icon: '/storage/' + theData[i].category.marker_img
                                };
                                arrayVal.push(item);
                            }

                        }
                    }
                    self.markers = arrayVal;
                });
        },
        methods: {
            toggleInfoWindow: function(marker, idx) {
                let returnData = theData.find(x => x.id === marker.id);
                toggleSidebar(returnData);
            },
            closeSidebar: function() {
                toggleSidebar();
            }
        }
    }
    function toggleSidebar(returnData) {
        let widthPerc = 25;
        if($(window).width() < 750) {
            widthPerc = 85;
        }

        if($('sidebar').hasClass('clicked') === true) {
            $('sidebar').removeClass('clicked').animate({
                right: '-' + widthPerc + '%',
            }, 300, function() {
                $('sidebar').css({
                    width: '0',
                    right: '0'
                });
            });
        }
        else {
            $.ajax({
                method: "POST",
                url: "/bookings",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'asset_id': returnData.id,
                }
            }).done(function( msg ) {
                bookingData = msg;
                selectedElement = returnData.id;
                fillData(returnData);
                $('sidebar').addClass('clicked').css({width: widthPerc + '%', right: '-' + widthPerc + '%'}).animate({
                    right: '0'
                }, 300);
            }).error(function(item) {
                alert("Error, try again");
            });

        }
    }
    function fillData(msg) {
            let returnVal = '<div class="overlayInfo">' +
                '<div class="overlayImage" style="background: url(/storage/'+msg.latest_image+') center center no-repeat;"> </div>' +
                '<h4>'+msg.name+'</h4>' +
                '<div class="sideInfo"><strong><i class="fa fa-building-o" aria-hidden="true"></i> Building: </strong>'+ msg.location.building.name + '</div>' +
                '<div class="sideInfo"><strong><i class="fa fa-hospital-o" aria-hidden="true"></i> Region: </strong>'+ msg.location.region.name + '</div>' +
                '<div class="sideInfo"><strong><i class="fa fa-folder-o" aria-hidden="true"></i> Category: </strong>'+ msg.category.name + '</div>' +
                '<div class="sideInfo"><strong><i class="fa fa-tags" aria-hidden="true"></i> Description </strong><br>'+ msg.category.description + '<span class="clearfix"></span></div>' +
                '<br class="clear">' +
                '</div>';

            $('sidebar #sideContent').empty().append(returnVal).fadeIn(500);

    }
</script>
