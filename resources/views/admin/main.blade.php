@extends('layouts.admin')
@section('title')
    Admin
@stop
@section('content')
    <h1>{{env('APP_NAME', 'Asset Booking')}} :: Admin</h1>
    <hr>

    <div class="row">
        <div class="col">
            <div class="adminHeading">
                <header>
                    Assets
                </header>
                <section>
                    {{$assetCount}}
                </section>
            </div>
        </div>
        <div class="col">
            <div class="adminHeading">
                <header>
                    Categories
                </header>
                <section>
                    {{$categoryCount}}
                </section>
            </div>
        </div>
        <div class="col">
            <div class="adminHeading">
                <header>
                    Buildings
                </header>
                <section>
                    {{$buildingCount}}
                </section>
            </div>
        </div>
        <div class="col">
            <div class="adminHeading">
                <header>
                    Regions
                </header>
                <section>
                    {{$regionCount}}
                </section>
            </div>
        </div>
    </div>

@stop