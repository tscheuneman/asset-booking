@extends('layouts.default')
@section('title')
    Home
@stop
@section('content')
    <div id="app" style="height: 100%">
        <navigation :user="'{{$user->id}}'">

        </navigation>

        <div id="showFilters">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </div>
        <cart>

        </cart>
        <filters>

        </filters>

        <googleMap>

        </googleMap>
    </div>
    <script>

    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/hammer.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script>
        let options = {
            preventDefault: true
        };

        let showFilters = document.getElementById("filters");
        let filterSection = document.getElementById("showFilters");
        let showFiltersAction = new Hammer(filterSection, options);
        let mainFilterAction = new Hammer(showFilters, options);

        showFiltersAction.on('swipeup panup', function(ev) {
            onSwipe();
        });
        mainFilterAction.on('swipedown pandown', function(ev) {
            onSwipe();
        });
        function onSwipe() {
            $('#filters').stop().slideToggle(500);
            $('#showFilters').stop().slideToggle(500);
        }
    </script>
@stop