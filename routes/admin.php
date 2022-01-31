<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::group(['namespace' => 'Dashboard', 'prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
            //********************************************* Index  ******************************************************/
            Route::get('/', 'dashboardController@index')->name('dashboard.index');
            //********************************************* End Index  **************************************************/

            //********************************************* Settings  ***************************************************/
            Route::group(['prefix' => 'settings'], function () {
                Route::get('/shipping-methods/{type}', 'settingController@editShippingMethods')->name('edit.shiping.methods');
                Route::post('/shipping-methods/{id}', 'settingController@updateShippingMethods')->name('update.shiping.methods');
            });
            //********************************************* End Settings  ***********************************************/
        });


        /*================================================================================================================ */


        Route::group(['prefix' => 'admin', 'namespace' => 'Dashboard', 'middleware' => 'guest:admin'], function () {
            //********************************************* Login  ******************************************************/
            Route::get('/login', 'loginController@login')->name('admin.login');
            Route::post('/login', 'loginController@postLogin')->name('admin.post.login');
            //********************************************* End Login  **************************************************/
        });
    }
);
