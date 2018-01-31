@extends('layouts.admin')
@section('title')
    Installers
@stop
@section('content')
    <a class="actionLink" href="{{ url('/admin/installer/create') }}">Add Installer</a> <h2>Installers</h2>
    <hr>

    @if(Session::has('flash_deleted'))
        <div class="alert alert-warning"><span class="glyphicon glyphicon-remove-circle"></span><em> {!! session('flash_deleted') !!}</em></div>
    @endif
    @if(Session::has('flash_created'))
        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_created') !!}</em></div>
    @endif
    {{$installers}}
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Company</th>
            <th scope="col">Updated</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($installers as $installer)
            <tr>
                <td>{{$installer->username}}</td>
                <td>{{$installer->email}}</td>
                <td>{{$installer->company}}</td>
                <td>{{$installer->updated_at->format('Y-m-d')}}</td>
                <td>
                    <a class="editAction" href="/admin/installer/edit/{{$installer->id}}"><span class="glyphicon glyphicon-pencil"> </span> Edit</a>
                    <form action="/admin/installer/delete/{{$installer->id}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE" />
                        <button class="deleteAction" onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-erase"> </span> Delete</button>
                    </form>
            <tr>
        @endforeach
        </tbody>
    </table>

@stop