@extends('layouts.admin')
@section('title')
    Buildings
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/locations/building/create') }}">Add Building</a> <h2>Buildings</h2>
    <hr>
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