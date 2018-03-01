@extends('layouts.default')
@section('title')
    Register
@stop
@section('content')
    <div class="container">
        @if(Session::has('flash_deleted'))
            <div class="alert alert-warning"><span class="glyphicon glyphicon-remove-circle"></span><em> {!! session('flash_deleted') !!}</em></div>
        @endif
        @if(Session::has('flash_created'))
            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_created') !!}</em></div>
        @endif

        <div class="row">
            <div class="col">
                <h1>Register</h1>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <form method="POST" action="{{ url('/register') }}" id="submit">
                        {{csrf_field()}}
                    <input type="hidden" class="form-control" id="username" name="username" value="{{$user}}">

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{$first_name}}" required>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{$last_name}}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{$email}}" required>
                    </div>

                    <div class="form-group">
                        <label for="department">Department</label>
                        <input type="text" class="form-control" id="department" name="department" value="{{$department}}" required>
                    </div>

                    <div class="form-group">
                        <label for="agency_org">Agency Org #</label>
                        <input type="text" class="form-control" id="agency_org" name="agency_org" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                @include('layouts.errors')

            </div>
        </div>
    </div>

@stop