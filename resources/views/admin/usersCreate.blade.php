@extends('layouts.admin')
@section('title')
    Create Admin User
@stop
@section('content')
<h2>Create User</h2>
<hr>
<form method="POST" action="{{ url('/admin/users') }}">
    {{csrf_field()}}
    <div class="form-group">
        <label for="asurite">ASURITE</label>
        <input type="text" class="form-control" id="asurite" name="asurite" placeholder="Enter ASURITE">
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

    <button type="submit" class="btn btn-primary">Submit</button>

    @include('layouts.errors')

</form>

@stop