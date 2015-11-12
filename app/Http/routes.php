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
        Route::resource('user', 'UserController');
        Route::resource('room', 'RoomController');
        Route::get('building/{id}/rooms', 'RoomController@buildingRooms');
        Route::get('user/{id}/rooms', 'RoomController@userRooms');
    });
});