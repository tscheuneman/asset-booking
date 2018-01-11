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
});



/*
 * Admin Section
 */


//Internal API's
Route::get('/asset', 'LocationController@index');


Route::group(['middleware' => ['cas.admin']], function ()
{
    Route::get('/admin', 'AdminController@index');
    Route::get('/admin/users', 'AdminController@show');
    Route::post('/admin/users', 'AdminController@store');

    Route::get('/admin/users/create', 'AdminController@create');


    Route::get('/admin/assets', 'AssetController@index');
    Route::get('/admin/asset/create', 'AssetController@create');
    Route::post('/admin/assets', 'AssetController@store');


    Route::get('/admin/categories', 'CategoryController@index');
    Route::get('/admin/category/create', 'CategoryController@create');
    Route::post('/admin/category', 'CategoryController@store');

    Route::get('/admin/location/verify', 'LocationController@verify');

    Route::get('/admin/locations/buildings', 'BuildingController@index');
    Route::get('/admin/locations/building/create', 'BuildingController@create');
    Route::post('/admin/locations/building', 'BuildingController@store');

    Route::get('/admin/locations/regions', 'RegionController@index');
    Route::get('/admin/locations/region/create', 'RegionController@create');
    Route::post('/admin/locations/region', 'RegionController@store');
});