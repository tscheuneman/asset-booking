@extends('layouts.admin')
@section('title')
    Users
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/users/create') }}">Add User</a> <h2>Users</h2>
    <hr>
    @if(Session::has('flash_deleted'))
        <div class="alert alert-warning"><span class="glyphicon glyphicon-remove-circle"></span><em> {!! session('flash_deleted') !!}</em></div>
    @endif
    @if(Session::has('flash_created'))
        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_created') !!}</em></div>
    @endif
    {{$users}}
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Username</th>
            <th scope="col">Updated</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->first_name}}</td>
                <td>{{$user->last_name}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->updated_at->format('Y-m-d')}}</td>
                <td>
                    <a class="editAction" href="/admin/users/edit/{{$user->id}}"><span class="glyphicon glyphicon-pencil"> </span> Edit</a>
                    <form action="/admin/users/delete/{{$user->id}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE" />
                        <button class="deleteAction" onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-erase"> </span> Delete</button>
                    </form>
            <tr>
        @endforeach
        </tbody>
    </table>
@stop