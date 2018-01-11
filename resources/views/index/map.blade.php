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
@stop