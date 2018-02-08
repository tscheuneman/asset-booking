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
@stop