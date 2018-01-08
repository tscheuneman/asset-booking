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
        </sidebar>
        <gmap-map
                :center="center"
                :zoom="12"
                style="width: 100%; height: 100%; position:absolute;"
        >

            <gmap-marker
                    :key="i"
                    v-for="(m,i) in markers"
                    :position="m.position"
                    :clickable="true" @click="toggleInfoWindow(m,i)
        "></gmap-marker>
        </gmap-map>
    </div>
</template>

<script>
    /////////////////////////////////////////
    // New in 0.4.0
    import * as VueGoogleMaps from 'vue2-google-maps';
    import Vue from 'vue';
    import axios from 'axios';

    Vue.use(VueGoogleMaps, {
        load: {
            key: 'AIzaSyDUQZsAMgprVk1i-buRKqZ2PDM8GRKr9W0',
            // libraries: 'places', //// If you need to use place input
        }
    });

    export default {
        props: ['sidebar'],
        data () {
            return {
                center: {lat: 10.0, lng: 10.0},
                infoContent: '',
                infoWindowPos: {
                    lat: 0,
                    lng: 0
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
        },
        created() {
            axios.get(`/locations`)
                .then(response => {
                    let arrayVal = [];
                    for(let i = 0; i < response.data.length; i++) {
                        let item = {
                            id: response.data[i].id,
                            position: {
                                lat: response.data[i].location.latitude,
                                lng: response.data[i].location.longitude
                            }
                        };
                        arrayVal.push(item);
                    }

                    // JSON responses are automatically parsed.
                    this.markers = arrayVal;

                })
                .catch(e => {
                    this.errors.push(e)
                })

        },
        methods: {
            toggleInfoWindow: function(marker, idx) {
                toggleSidebar();
                axios.get(`/asset?id=` + marker.id)
                    .then(response => {
                        fillData(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                        this.errors.push(e)
                    })
            },
            closeSidebar: function() {
                toggleSidebar();
            }
        }
    }
    function toggleSidebar() {
        if($('sidebar').hasClass('clicked') === true) {
            $('sidebar').removeClass('clicked').animate({
                width: 0
            }, 500);
        }
        else {
            $('sidebar').addClass('clicked').animate({
                width: '25%'
            }, 500);
        }
    }
    function fillData(msg) {
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

        $('sidebar #sideContent').empty().append(returnVal).fadeIn(500);
    }
</script>
