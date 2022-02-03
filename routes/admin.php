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

            //********************************************* Logout  *****************************************************/
            Route::get('/logout', 'loginController@logout')->name('admin.logout');
            //********************************************* End Logout  *************************************************/

            //********************************************* Settings  ***************************************************/
            Route::group(['prefix' => 'settings'], function () {
                Route::get('/shipping-methods/{type}', 'settingController@editShippingMethods')->name('edit.shiping.methods');
                Route::post('/shipping-methods/{id}', 'settingController@updateShippingMethods')->name('update.shiping.methods');
            });
            //********************************************* End Settings  ***********************************************/

            //********************************************* Admin profile  **********************************************/
            Route::group(['prefix' => 'Profile'], function () {
                Route::get('/edit', 'ProfileController@edit')->name('edit.profile');
                Route::post('/update/{id}', 'ProfileController@update')->name('update.profile');
            });
            //********************************************* End Admin profile *******************************************/

            //********************************************* Categories **************************************************/
            Route::group(['prefix'=>'MainCategory'],function(){
                Route::get('/index','MainCategoryController@index')->name('MainCategory.index');
                Route::get('/create','MainCategoryController@create')->name('MainCategory.create');
                Route::post('/create','MainCategoryController@store')->name('MainCategory.store');
                Route::get('/edit/{id}','MainCategoryController@edit')->name('MainCategory.edit');
                Route::put('/update/{id}','MainCategoryController@update')->name('MainCategory.update');
                Route::get('/delete/{id}','MainCategoryController@destroy')->name('MainCategory.destroy');
            });
            //********************************************* End Categories **********************************************/
        });

        /*============================================================================================================= */

        Route::group(['prefix' => 'admin', 'namespace' => 'Dashboard', 'middleware' => 'guest:admin'], function () {
            //********************************************* Login  ******************************************************/
            Route::get('/login', 'loginController@login')->name('admin.login');
            Route::post('/login', 'loginController@postLogin')->name('admin.post.login');

            //********************************************* End Login  **************************************************/
        });
    }
);
