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


Route::get('/installer/error', 'Installers\IndexController@error');

Route::get('/register', 'RegisterController@index');
Route::post('/register', 'RegisterController@store');

Route::get('/approval', 'IndexController@approval');

Route::group(['middleware' => ['cas.user']], function ()
{
    Route::get('/', 'IndexController@index');
    Route::get('/locations', 'IndexController@show');
    Route::get('/campuses', 'IndexController@campusShow');

    Route::post('/filter', 'FilterController@show');

    Route::post('/bookings', 'Admin\BookingController@bookings');


    Route::get('/user/{username}', 'IndexController@userShow');

    Route::get('/cart', 'CartController@index');
    Route::get('/cart/count', 'CartController@count');


});



/*
 * Admin Section
 */


//Internal API's
Route::get('/asset', 'Admin/LocationController@index');


Route::group(['middleware' => ['cas.admin']], function ()
{
    //Admin User Actions
    Route::get('/admin', 'Admin\AdminController@index');
    Route::get('/admin/users/create', 'Admin\AdminController@create');
    Route::get('/admin/users', 'Admin\AdminController@show');
    Route::post('/admin/users', 'Admin\AdminController@store');

    Route::get('/admin/users/edit/{id}', 'Admin\AdminController@edit');
    Route::post('/admin/users/{id}', 'Admin\AdminController@update');
    Route::delete('/admin/users/delete/{id}', 'Admin\AdminController@destroy');


    //Admin Asset Actions
    Route::get('/admin/assets', 'Admin\AssetController@index');
    Route::get('/admin/asset/create', 'Admin\AssetController@create');
    Route::post('/admin/assets', 'Admin\AssetController@store');
    Route::get('/admin/asset/edit/{id}', 'Admin\AssetController@edit');
    Route::post('/admin/asset/{id}', 'Admin\AssetController@update');
    Route::delete('/admin/asset/delete/{id}', 'Admin\AssetController@destroy');



    //Admin Category Actions
    Route::get('/admin/categories', 'Admin\CategoryController@index');
    Route::get('/admin/category/create', 'Admin\CategoryController@create');
    Route::post('/admin/category', 'Admin\CategoryController@store');
    Route::get('/admin/category/edit/{id}', 'Admin\CategoryController@edit');
    Route::post('/admin/category/{id}', 'Admin\CategoryController@update');


    //Admin Building Actions
    Route::get('/admin/locations/buildings', 'Admin\BuildingController@index');
    Route::get('/admin/locations/building/create', 'Admin\BuildingController@create');
    Route::post('/admin/locations/building', 'Admin\BuildingController@store');
    Route::get('/admin/locations/building/edit/{id}', 'Admin\BuildingController@edit');
    Route::post('/admin/locations/building/{id}', 'Admin\BuildingController@update');
    Route::delete('/admin/locations/building/delete/{id}', 'Admin\BuildingController@destroy');

    //Admin Region Actions
    Route::get('/admin/locations/regions', 'Admin\RegionController@index');
    Route::get('/admin/locations/region/create', 'Admin\RegionController@create');
    Route::post('/admin/locations/region', 'Admin\RegionController@store');
    Route::get('/admin/locations/region/edit/{id}', 'Admin\RegionController@edit');
    Route::post('/admin/locations/region/{id}', 'Admin\RegionController@update');
    Route::delete('/admin/locations/region/delete/{id}', 'Admin\RegionController@destroy');

    //Admin Specification Actions
    Route::get('/admin/specifications', 'Admin\SpecificationController@index');
    Route::get('/admin/specifications/create', 'Admin\SpecificationController@create');
    Route::post('/admin/specification', 'Admin\SpecificationController@store');
    Route::get('/admin/specification/{id}/edit', 'Admin\SpecificationController@edit');
    Route::post('/admin/specification/{id}', 'Admin\SpecificationController@update');

    //Admin Installer Actions
    Route::get('/admin/installers', 'Admin\InstallerController@index');
    Route::get('/admin/installer/create', 'Admin\InstallerController@create');
    Route::post('/admin/installer', 'Admin\InstallerController@store');
    Route::get('/admin/installer/edit/{id}', 'Admin\InstallerController@edit');
    Route::post('/admin/installer/{id}', 'Admin\InstallerController@update');
    Route::delete('/admin/installer/delete/{id}', 'Admin\InstallerController@destroy');

    //Admin Settings Actions
    Route::get('/admin/settings', 'Admin\SettingController@index');

    //Admin "API" Actions
    Route::post('/admin/asset/specifications/{id}', 'Admin\SpecificationController@show');
    Route::get('/admin/location/verify', 'Admin\LocationController@verify');

    Route::get('/admin/settings', 'Admin\SettingController@index');

    Route::post('/admin/settings/global', 'Admin\SettingController@globalUpdate');


    //Admin User Approval
    Route::get('/admin/user/approval', 'Admin\UserApprovalController@index');

    Route::post('/admin/user/approve/{id}', 'Admin\UserApprovalController@update');
});


/*
 * Installer Section
 */
Route::group(['middleware' => ['cas.installer']], function ()
{
    Route::get('/installers', 'Installers\IndexController@index');

    Route::get('/installers/install/{id}', 'Installers\InstallController@show');
    Route::post('/installers/install/{id}', 'Installers\InstallController@store');

});


