@extends('layouts.admin')
@section('title')
    Create Installer
@stop
@section('content')
    <h2>Create Installer</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/installer') }}">
        {{csrf_field()}}
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>

        <div class="form-group">
            <label for="company">Company</label>
            <input type="text" class="form-control" id="company" name="company" placeholder="Company">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>

        @include('layouts.errors')

    </form>

@stop