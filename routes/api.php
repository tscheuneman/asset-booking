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
    Route::post('/booking/{id}', 'Admin\BookingController@store');

    Route::get('/assets', 'Admin\AssetController@getAllAssets');

    Route::get('/location/regions', 'Admin\RegionController@getAllRegions');

    Route::get('/categories', 'Admin\CategoryController@getAllCategories');

    Route::post('/cart/entry/delete', 'CartController@destroy');

    Route::post('/cart/checkout', 'CartController@checkout');

    Route::get('/user/{id}', 'IndexController@getUser');
});