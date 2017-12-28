@extends('layouts.admin')
@section('title')
    Assets
@stop
@section('content')
    <a class="actionLink" href="/admin/asset/create">Add Asset</a> <h2>Assets</h2>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">ASURite</th>
            <th scope="col">Created</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($assets as $asset)
            <tr>
            {{$asset}}
            <tr>
        @endforeach
        </tbody>
    </table>
@stop