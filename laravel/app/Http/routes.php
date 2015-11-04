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

Route::group(['prefix' => 'v1'], function () {

    Route::get('/', function () {
        return Redirect::away(url('docs'));
    });

    Route::group(['prefix' => 'user'], function () {

        Route::post('/', 'UserController@post');

        Route::get('id/{id}', 'UserController@getByID');
        Route::get('sageid/{sageid}', 'UserController@getBySageID');

        Route::get('/', 'UserController@get');
        Route::get('/{limit}', 'UserController@get');

    });

    Route::group(['prefix' => 'role'], function () {

    });

    Route::group(['prefix' => 'building'], function () {

    });

    Route::group(['prefix' => 'campus'], function () {

    });

    Route::group(['prefix' => 'program'], function () {

    });

    Route::group(['prefix' => 'department'], function () {

    });

    Route::group(['prefix' => 'email'], function () {

    });

    Route::group(['prefix' => 'phone'], function () {

    });

    Route::group(['prefix' => 'room'], function () {

    });

    Route::group(['prefix' => 'course'], function () {

    });

});

