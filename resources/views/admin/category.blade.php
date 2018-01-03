@extends('layouts.admin')
@section('title')
    Asset Categories
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/category/create') }}">Add Category</a> <h2>Categories</h2>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
            <td>
              {{$category->id}}
            </td>
            <td>
              {{$category->name}}
            </td>
            <td>
             {{$category->slug}}
            </td>
            <tr>
        @endforeach
        </tbody>
    </table>
@stop