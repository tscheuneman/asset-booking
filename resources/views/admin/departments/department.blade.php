@extends('layouts.admin')
@section('title')
    Departments
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/department/create') }}">Add Department</a> <h2>Departments</h2>
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
            <th scope="col" colspan="1">Name</th>
        </tr>
        </thead>
        <tbody>
            @foreach($depts as $dept)
                <tr>
                    <td>{{$dept->name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{$depts}}
@stop