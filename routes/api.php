<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {

    Route::post('login', 'LoginController@login')->name('login');

    Route::get('spots', 'SpotController@index')->name('getSpots');
    Route::get('users', 'UserController@index')->name('getUsers');
    Route::get('products', 'ProductController@index')->name('getProducts');
    Route::get('customer', 'CustomerController@index')->name('getProductsCustomer');
    Route::get('orders', 'CustomerController@getOrders')->name('getOrders');
    Route::get('commandes', 'BlackroomController@getAllOrders')->name('getAllOrders');
    Route::get('status', 'BlackroomController@getAllStatus')->name('getAllStatus');
    Route::get('ordersproducts/{id}', 'BlackroomController@getOrdersProducts')->name('getOrdersProducts');
    Route::get('ordersproducts/{id}', 'CustomerController@getOrdersProducts')->name('getOrdersProducts');

    Route::post('spots', 'SpotController@store')->name('addSpot');
    Route::post('users', 'UserController@store')->name('addUser');
    Route::post('products', 'ProductController@store')->name('addProduct');
    Route::post('orders', 'CustomerController@store')->name('addOrder');

    Route::delete('users/{id}', 'UserController@destroy')->name('deleteUser');
    Route::put('users/{id}', 'UserController@update')->name('editUserConfirm');
    Route::patch('users/{id}', 'UserController@updatePassword')->name('changePassword');

    Route::delete('spots/{id}', 'SpotController@destroy')->name('deleteSpot');
    Route::put('spots/{id}', 'SpotController@update')->name('editSpotConfirm');

    Route::delete('products/{id}', 'ProductController@destroy')->name('deleteProducts');
    Route::put('products/{id}', 'ProductController@update')->name('editProductAction');
    Route::post('products/{id}/openscoring', 'ProductController@openscoring')->name('changeStatusScoring');
    Route::post('products/{id}/closescoring', 'ProductController@closescoring')->name('changeStatusClosed');

    Route::post('register', 'RegisterController@register')->name('register');

// To Do => redirect register page to login or other page :)
    Route::post('register', 'RegisterController@register')->name('register');

    Route::group(['middleware' => ['auth:api','user']], function () {

        Route::get('email/verify/{hash}', 'VerificationController@verify')->name('verification.verify');

        Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');

        Route::get('user', 'AuthenticationController@user')->name('user');

        Route::post('logout', 'LoginController@logout')->name('logout');

    });

});
