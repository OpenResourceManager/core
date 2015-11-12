<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


error_reporting(E_ALL);
ini_set('display_errors', 1);

Route::get('/', function () {
    return Redirect::away(url('docs'));
});

Route::group(['prefix' => 'api'], function () {

    Route::get('/', function () {
        return Redirect::away(url('docs'));
    });

    Route::group(['prefix' => 'v1'], function () {

        Route::get('/', function () {
            return Redirect::away(url('docs'));
        });

        Route::resource('campus', 'CampusController');

        Route::resource('building', 'BuildingController');
        Route::get('building/{id}/room', 'RoomController@buildingRooms');

        Route::resource('user', 'UserController');
        Route::get('user/{id}/room', 'RoomController@userRooms');
        Route::get('user/{id}/email', 'EmailController@userEmails');
        Route::get('user/{id}/phone', 'PhoneController@userPhones');

        Route::resource('room', 'RoomController');

        Route::resource('email', 'EmailController');

        Route::resource('phone', 'PhoneController');


    });
});