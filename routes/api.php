<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cas.user']], function () {
    Route::get('/assets', 'Admin\AssetController@getAllAssets');

    Route::get('/location/regions', 'Admin\RegionController@getAllRegions');
});