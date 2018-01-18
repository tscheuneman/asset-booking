@extends('layouts.default')
@section('title')
    Test
@stop
@section('content')
    <div id="app">
        <navigation :region="{{$region}}" :username="'{{$user}}'">

        </navigation>

        <filters :categories="{{$categories}}" :region="{{$region}}">

        </filters>

        <googleMap :assets="{{$assets}}">

        </googleMap>
    </div>
    <script>

    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@stop