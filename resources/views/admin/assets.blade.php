@extends('layouts.admin')
@section('title')
    Assets
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/asset/create') }}">Add Asset</a> <h2>Assets</h2>
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
            <th scope="col">Category</th>
            <th scope="col">Region</th>
            <th scope="col">Building</th>
            <th scope="col">Actions</th>
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
                    <a class="editAction" href="/admin/asset/{{$asset->id}}/edit">Edit</a>
                    <form action="/admin/asset/{{$asset->id}}/delete" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE" />
                        <button class="deleteAction" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            <tr>
        @endforeach
        </tbody>
    </table>

    {{$assets}}
@stop