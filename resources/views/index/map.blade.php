@extends('layouts.default')
@section('title')
    Test
@stop
@section('content')
    <div id="app">
        <navigation :campus="{{$campus}}" :username="'{{$user}}'">

        </navigation>

        <filters>

        </filters>

        <googleMap :assets="{{$assets}}">

        </googleMap>
    </div>
    <script>

    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@stop