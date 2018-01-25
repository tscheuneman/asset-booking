@extends('layouts.admin')
@section('title')
    Edit {{$user->first_name}}
@stop
@section('content')
    <h2>Edit {{$user->first_name . ' ' . $user->last_name}}</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/users') }}/{{$user->uuid}}">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$user->uuid}}">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" readonly value="{{$user->username}}">
        </div>

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{$user->first_name}}">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{$user->last_name}}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>

        @include('layouts.errors')

    </form>

@stop