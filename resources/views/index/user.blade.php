@extends('layouts.default')
@section('title')
    User Panel - {{$user}}
@stop
@section('content')
    <div id="app">
        <userbookings>

        </userbookings>
    </div>

    {{$booking}}
    <script src="{{ asset('js/app.js') }}"></script>
@stop