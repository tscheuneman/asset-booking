@extends('layouts.default')
@section('title')
    Test
@stop
@section('content')
    <div id="app">
        <navigation :username="'{{$user}}'">

        </navigation>
        <googleMap>

        </googleMap>
    </div>
    <script>

    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@stop