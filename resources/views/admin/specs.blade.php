@extends('layouts.admin')
@section('title')
    Specifications
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/specifications/create') }}">Add Specification</a> <h2>Specifications</h2>
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
            <th scope="col">Type</th>
            <th scope="col">Options</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($specs as $spec)
            <tr>
                <td>
                    {{$spec->id}}
                </td>
                <td>
                    {{$spec->name}}
                </td>
                <td>
                    {{$spec->type}}
                </td>
                <td>
                    @foreach ( json_decode($spec->options) as $tag)
                        <span class="optionData">{{$tag->label}}</span>
                    @endforeach
                </td>
                <td>
                    <a class="editAction" href="/admin/specification/{{$spec->id}}/edit">Edit</a>
                </td>
            <tr>
        @endforeach
        </tbody>
    </table>
    {{$specs}}
@stop