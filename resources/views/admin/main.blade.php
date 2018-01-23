@extends('layouts.admin')
@section('title')
    Admin
@stop
@section('content')
    <br>
    <Br>
    <div class="row">
        <div class="col">
            <div class="adminHeading">
                <section>
                    <div class="icon glyphicon glyphicon-user blue"></div>
                    <div class="info">
                        <span class="data">
                            {{$userCount}}
                        </span>
                        <span class="desc">
                            Users
                        </span>
                    </div>
                </section>
            </div>
        </div>
        <div class="col">
            <div class="adminHeading">
                <section>
                    <div class="icon glyphicon glyphicon-inbox green"></div>
                    <div class="info">
                        <span class="data">
                            {{$assetCount}}
                        </span>
                        <span class="desc">
                            Assets
                        </span>
                    </div>
                </section>
            </div>
        </div>
        <div class="col">
            <div class="adminHeading">
                <section>
                    <div class="icon glyphicon glyphicon-tags orange"></div>
                    <div class="info">
                        <span class="data">
                            {{$categoryCount}}
                        </span>
                        <span class="desc">
                            Categories
                        </span>
                    </div>
                </section>
            </div>
        </div>
        <div class="col">
            <div class="adminHeading">
                <section>
                    <div class="icon glyphicon glyphicon-home red"></div>
                    <div class="info">
                        <span class="data">
                            {{$buildingCount}}
                        </span>
                        <span class="desc">
                            Buildings
                        </span>
                    </div>
                </section>
            </div>
        </div>
        <div class="col">
            <div class="adminHeading">
                <section>
                    <div class="icon glyphicon glyphicon-globe purple"></div>
                    <div class="info">
                        <span class="data">
                            {{$regionCount}}
                        </span>
                        <span class="desc">
                            Regions
                        </span>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <div class="row">

    </div>
@stop