@extends('layouts.admin')
@section('title')
    Assets
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/asset/create') }}">Add Asset</a> <h2>Assets</h2>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Category</th>
            <th scope="col">Region</th>
            <th scope="col">Building</th>
            <th scope="col">Available</th>
            <th scope="col">Active</th>
        </tr>
        </thead>
        <tbody>
        @foreach($assets as $asset)
            <tr>
                <td>
                    {{$asset->id}}
                </td>
                <td>
                    {{$asset->name}}
                </td>
                <td>
                    {{$asset->category->name}}
                </td>
                <td>
                    {{$asset->location->region->name}}
                </td>
                <td>
                    {{$asset->location->building->name}}
                </td>
                <td>
                    {{$asset->is_available}}
                </td>
                <td>
                    {{$asset->is_active}}
                </td>
            <tr>
        @endforeach
        </tbody>
    </table>
@stop