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
            <th scope="col">Actions</th>
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
                <td>
                    <a class="editAction" href="/admin/locations/building/{{$building->id}}/edit">Edit</a>
                    <form action="/admin/locations/building/{{$building->id}}/delete" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE" />
                        <button class="deleteAction" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            <tr>
        @endforeach
        </tbody>
    </table>
@stop