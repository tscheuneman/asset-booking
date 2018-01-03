@extends('layouts.admin')
@section('title')
    Create Category
@stop
@section('content')
    <h2>Create Category</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/category') }}">
        {{csrf_field()}}


        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="slug">Category Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="6"></textarea>
        </div>

        <hr>

        <button type="submit" class="btn btn-primary">Submit</button>

        @include('layouts.errors')

    </form>

@stop