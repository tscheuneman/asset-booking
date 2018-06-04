@extends('layouts.admin')
@section('title')
    Users
@stop
@section('content')
    <h2>Users</h2>
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
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Department</th>
            <th scope="col">Email</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->first_name . ' ' . $user->last_name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->department}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <a class="editAction" href="/admin/user/users/edit/{{$user->id}}"><span class="glyphicon glyphicon-pencil"> </span> Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{$users}}
@stop