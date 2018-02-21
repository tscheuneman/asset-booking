@extends('layouts.installers')
@section('title')
    Installers
@stop
@section('content')
    <br>
    @if(Session::has('flash_deleted'))
        <div class="alert alert-warning"><span class="glyphicon glyphicon-remove-circle"></span><em> {!! session('flash_deleted') !!}</em></div>
    @endif
    @if(Session::has('flash_created'))
        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_created') !!}</em></div>
    @endif
    <br>
    <div id="installerMain"  class="row">
        <div class="col">
            <div class="adminHeading">
                <section>
                    <div class="icon glyphicon glyphicon-hourglass blue"></div>
                    <div class="info">
                        <span class="data">
                            {{$pendingBookings}}
                        </span>
                        <span class="desc">
                            Pending
                        </span>
                    </div>
                </section>
            </div>

            <div class="col">
                <div class="adminHeading">
                    <section>
                        <div class="icon glyphicon glyphicon-ban-circle red"></div>
                        <div class="info">
                            <span class="data">
                                {{$lateBookings}}
                            </span>
                            <span class="desc">
                              Late
                            </span>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <br class="clear" />
        <hr>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Asset Name</th>
                <th scope="col">Region</th>
                <th scope="col">Building</th>
                <th scope="col">Customer</th>
                <th scope="col">Date Range</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($bookingInfo as $book)
                    @if(date('Y-m-d', strtotime($book->time_from)) < date('Y-m-d'))
                        <tr class="past_due">
                    @elseif(date('Y-m-d', strtotime($book->time_from)) === date('Y-m-d'))
                        <tr class="due_today">
                    @else
                        <tr>
                    @endif
                        <td>
                            {{$book->asset->name}}
                        </td>
                        <td>
                            {{$book->asset->location->region->name}}
                        </td>
                        <td>
                            {{$book->asset->location->building->name}}
                        </td>
                        <td>
                            {{$book->customer->email}}
                        </td>
                        <td>
                            {{date('Y-m-d', strtotime($book->time_from))}} - {{date('Y-m-d', strtotime($book->time_to))}}
                        </td>
                        <td>
                            <a class="editAction" href="/installers/install/{{$book->id}}"><span class="glyphicon glyphicon-wrench"> </span> Install</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@stop