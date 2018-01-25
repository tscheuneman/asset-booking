<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Middleware\CheckAge;

Route::group(['middleware' => ['cas.user']], function ()
{
    Route::get('/', 'IndexController@index');
    Route::get('/locations', 'IndexController@show');
    Route::get('/campuses', 'IndexController@campusShow');

    Route::post('/filter', 'FilterController@show');

    Route::post('/bookings', 'BookingController@bookings');
});



/*
 * Admin Section
 */


//Internal API's
Route::get('/asset', 'LocationController@index');


Route::group(['middleware' => ['cas.admin']], function ()
{
    //Admin User Actions
    Route::get('/admin', 'AdminController@index');
    Route::get('/admin/users/create', 'AdminController@create');
    Route::get('/admin/users', 'AdminController@show');
    Route::post('/admin/users', 'AdminController@store');
    Route::get('/admin/users/{id}/edit', 'AdminController@edit');
    Route::post('/admin/users/{id}', 'AdminController@update');
    Route::delete('/admin/users/{id}/delete', 'AdminController@destroy');

    //Admin Asset Actions
    Route::get('/admin/assets', 'AssetController@index');
    Route::get('/admin/asset/create', 'AssetController@create');
    Route::post('/admin/assets', 'AssetController@store');
    Route::get('/admin/asset/{id}/edit', 'AssetController@edit');
    Route::post('/admin/asset/{id}', 'AssetController@update');
    Route::delete('/admin/asset/{id}/delete', 'AssetController@destroy');

    //Admin Category Actions
    Route::get('/admin/categories', 'CategoryController@index');
    Route::get('/admin/category/create', 'CategoryController@create');
    Route::post('/admin/category', 'CategoryController@store');
    Route::get('/admin/category/{id}/edit', 'CategoryController@edit');
    Route::post('/admin/category/{id}', 'CategoryController@update');


    //Admin Building Actions
    Route::get('/admin/locations/buildings', 'BuildingController@index');
    Route::get('/admin/locations/building/create', 'BuildingController@create');
    Route::post('/admin/locations/building', 'BuildingController@store');
    Route::get('/admin/locations/building/{id}/edit', 'BuildingController@edit');
    Route::post('/admin/locations/building/{id}', 'BuildingController@update');
    Route::delete('/admin/locations/building/{id}/delete', 'BuildingController@destroy');

    //Admin Region Actions
    Route::get('/admin/locations/regions', 'RegionController@index');
    Route::get('/admin/locations/region/create', 'RegionController@create');
    Route::post('/admin/locations/region', 'RegionController@store');
    Route::get('/admin/locations/region/{id}/edit', 'RegionController@edit');
    Route::post('/admin/locations/region/{id}', 'RegionController@update');
    Route::delete('/admin/locations/region/{id}/delete', 'RegionController@destroy');

    //Admin Specification Actions
    Route::get('/admin/specifications', 'SpecificationController@index');
    Route::get('/admin/specifications/create', 'SpecificationController@create');
    Route::post('/admin/specification', 'SpecificationController@store');
    Route::get('/admin/specification/{id}/edit', 'SpecificationController@edit');
    Route::post('/admin/specification/{id}', 'SpecificationController@update');

    //Admin "API" Actions
    Route::post('/admin/asset/specifications/{id}', 'SpecificationController@show');
    Route::get('/admin/location/verify', 'LocationController@verify');

    Route::get('/admin/import/buildings', 'ImportController@buildings');
    Route::get('/admin/import/regions', 'ImportController@regions');
});