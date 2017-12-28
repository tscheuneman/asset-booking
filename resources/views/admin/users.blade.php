@extends('layouts.admin')
@section('title')
    Users
@stop
@section('content')
    <a class="actionLink" href="/admin/users/create">Add User</a> <h2>Users</h2>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">ASURite</th>
            <th scope="col">Created</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->first_name}}</td>
                <td>{{$user->last_name}}</td>
                <td>{{$user->asurite}}</td>
                <td>{{$user->created_at->format('Y-m-d')}}</td>
                <td><a class="editAction" href="/admin/users/{{$user->id}}/edit">Edit</a></td>
            <tr>
        @endforeach
        </tbody>
    </table>
@stop