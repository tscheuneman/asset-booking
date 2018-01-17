@extends('layouts.admin')
@section('title')
    Asset Categories
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/category/create') }}">Add Category</a> <h2>Categories</h2>
    <hr>

    @if(Session::has('flash_deleted'))
        <div class="alert alert-warning"><span class="glyphicon glyphicon-remove-circle"></span><em> {!! session('flash_deleted') !!}</em></div>
    @endif
    @if(Session::has('flash_created'))
        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_created') !!}</em></div>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Updated</th>
            <th scope="col">Actions</th>
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
            <td>
                {{$category->updated_at->format('Y-m-d')}}
            </td>
            <td>
                <a class="editAction" href="/admin/category/{{$category->id}}/edit">Edit</a>
            </td>
            <tr>
        @endforeach
        </tbody>
    </table>

    {{$categories}}
@stop