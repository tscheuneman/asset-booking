@extends('layouts.admin')
@section('title')
    Create Admin User
@stop
@section('content')
<h2>Create User</h2>
<hr>
<form method="POST" action="{{ url('/admin/users') }}" id="submit" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
    </div>

    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
    </div>

    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
    </div>

    <div class="form-group">
        <label for="image">Picture</label>
        <input type="file" class="form-control-file" name="image" id="image" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

    @include('layouts.errors')

</form>

@stop