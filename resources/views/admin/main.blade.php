@extends('layouts.admin')
@section('title')
    Home
@stop
@section('content')
    <br>
    <div id="adminMain" class="row">
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
    <hr>

    <!--
    <div class="row">
        <div id="quick-actions">
            <a href="{{ url('/admin/asset/create') }}">
                <div class="button success">
                    <span class="glyphicon glyphicon glyphicon-plus-sign"></span> Create Asset
                </div>
            </a>

            <a href="{{ url('/admin/category/create') }}">
                <div class="button success">
                    <span class="glyphicon glyphicon-tags"></span> Create Category
                </div>
            </a>

            <a href="{{ url('/admin/specifications/create') }}">
                <div class="button success">
                    <span class="glyphicon glyphicon-grain"></span> Create Specification
                </div>
            </a>
        </div>
    </div>
    -->
@stop