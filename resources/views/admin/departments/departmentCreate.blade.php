@extends('layouts.admin')
@section('title')
    Create Department
@stop
@section('content')
    <h2>Create Department</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/department') }}" id="submit" enctype="multipart/form-data" id="submit">
        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Department Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        @include('layouts.errors')
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script>
        $(document).ready(function() {


        });
    </script>
@stop