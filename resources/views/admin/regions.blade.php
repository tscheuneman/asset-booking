@extends('layouts.admin')
@section('title')
    Campuses
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/locations/region/create') }}">Add Region</a> <h2>Region</h2>
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
            <th scope="col">Updated</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($regions as $region)
            <tr>
                <td>
                    {{$region->id}}
                </td>
                <td>
                    {{$region->name}}
                </td>
                <td>
                    {{$region->updated_at->format('Y-m-d')}}
                </td>
                <td>
                    <a class="editAction" href="/admin/locations/region/{{$region->id}}/edit"><span class="glyphicon glyphicon-pencil"> </span> Edit</a>
                    <form action="/admin/locations/region/{{$region->id}}/delete" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE" />
                        <button class="deleteAction" onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-erase"> </span> Delete</button>
                    </form>
                </td>
            <tr>
        @endforeach
        </tbody>
    </table>

    {{$regions}}
@stop