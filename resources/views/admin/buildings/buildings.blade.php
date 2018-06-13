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
    <div class="sort">
        <form action="" method="GET">
            <input type="text" name="keyword" class="form-control" placeholder="Search..." />
        </form>
    </div>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Updated</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($buildings as $building)
            <tr>
                <td>
                    {{$building->name}}
                </td>
                <td>
                    {{$building->updated_at->format('Y-m-d')}}
                </td>
                <td>
                    <a class="editAction" href="/admin/locations/building/edit/{{$building->id}}"><span class="glyphicon glyphicon-pencil"> </span> Edit</a>
                    <form action="/admin/locations/building/delete/{{$building->id}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE" />
                        <button class="deleteAction" onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-erase"> </span> Delete</button>
                    </form>
                </td>
            <tr>
        @endforeach
        </tbody>
    </table>
    {{ $buildings->appends(Request::except('page'))->links() }}
@stop