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
    <script src="https://unpkg.com/interact.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
@stop