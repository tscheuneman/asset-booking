@extends('layouts.admin')
@section('title')
    Settings
@stop
@section('content')
    <h1>Global Site Settings</h1>
    <hr>
    @foreach($globalSetting as $setting)
        <div class="setting" id="{{$setting->id}}" data-type="{{$setting->type}}">
            <label for="{{$setting->slug}}">{{$setting->name}}</label>
            @if($setting->type === "checkbox")
                @if($setting->adminSetting->value)
                    <input type="checkbox" name="{{$setting->slug}}" id="{{$setting->slug}}" checked="checked" />
                @else
                    <input type="checkbox" name="{{$setting->slug}}" id="{{$setting->slug}}" />
                @endif
            @elseif($setting->type === "textbox")
                <input type="text" class="form-control" name="{{$setting->slug}}" id="{{$setting->slug}}" value="{{$setting->adminSetting->value}}" />
            @elseif($setting->type === "number")
                <input type="number" class="form-control" name="{{$setting->slug}}" id="{{$setting->slug}}" value="{{$setting->adminSetting->value}}" />
            @elseif($setting->type === "email")
                <input type="email" class="form-control" name="{{$setting->slug}}" id="{{$setting->slug}}" value="{{$setting->adminSetting->value}}" />
            @endif
        </div>
    @endforeach
    <br class="clear">
    <h1>Your Settings</h1>
    <hr>
@stop