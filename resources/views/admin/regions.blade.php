@extends('layouts.admin')
@section('title')
    Campuses
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/locations/campus/create') }}">Add Region</a> <h2>Region</h2>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($campuses as $campus)
            <tr>
                <td>
                    {{$campus->id}}
                </td>
                <td>
                    {{$campus->name}}
                </td>
            <tr>
        @endforeach
        </tbody>
    </table>
@stop