@extends('layouts.admin')
@section('title')
    Specifications
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/specs/create') }}">Add Specification</a> <h2>Specificatios</h2>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Default</th>
            <th scope="col">Options</th>
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
                    {{$spec->default}}
                </td>
                <td>
                    @foreach ( json_decode($spec->options) as $tag)
                        <span class="optionData">{{$tag->label}}</span>
                    @endforeach
                </td>
            <tr>
        @endforeach
        </tbody>
    </table>
@stop