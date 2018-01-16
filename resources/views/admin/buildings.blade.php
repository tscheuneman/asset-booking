@extends('layouts.admin')
@section('title')
    Buildings
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/locations/building/create') }}">Add Building</a> <h2>Buildings</h2>
    <hr>

    @if(Session::has('flash_deleted'))
        <div class="alert alert-warning"><span class="glyphicon glyphicon-remove-circle"></span><em> {!! session('flash_deleted') !!}</em></div>
    @endif
    @if(Session::has('flash_created'))
        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_created') !!}</em></div>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($buildings as $building)
            <tr>
                <td>
                    {{$building->id}}
                </td>
                <td>
                    {{$building->name}}
                </td>
            <tr>
        @endforeach
        </tbody>
    </table>
@stop