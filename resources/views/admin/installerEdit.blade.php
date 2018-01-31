@extends('layouts.admin')
@section('title')
    Edit {{$installer->username}}
@stop
@section('content')
    <h2>Edit {{$installer->username}}</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/installer') }}/{{$installer->id}}">
        {{csrf_field()}}

        <input type="hidden" name="id" value="{{$installer->id}}">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{$installer->username}}" placeholder="Enter Username">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$installer->email}}" placeholder="Email">
        </div>

        <div class="form-group">
            <label for="company">Company</label>
            <input type="text" class="form-control" id="company" name="company" value="{{$installer->company}}" placeholder="Company">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>

        @include('layouts.errors')

    </form>

@stop