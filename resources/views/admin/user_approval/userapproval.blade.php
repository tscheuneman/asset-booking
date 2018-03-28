@extends('layouts.admin')
@section('title')
    User Approval
@stop
@section('content')
    <h2>User Approval</h2>
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
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Username</th>
            <th scope="col">Department</th>
            <th scope="col">Agency Org</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->first_name}}</td>
                <td>{{$user->last_name}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->department}}</td>
                <td>{{$user->agency_org}}</td>
            <td>
                <form action="/admin/user/approve/{{$user->id}}" method="POST">
                    {{csrf_field()}}
                    <button class="editAction" onclick="return confirm('Approve Account')"><span class="glyphicon glyphicon-ok"> </span> Approve</button>
                </form>
            </td>
            <tr>
        @endforeach
        </tbody>
    </table>
@stop