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

    Route::group(['prefix' => 'type'], function () {

        Route::get('/', 'TypeController@get');

        Route::group(['prefix' => 'role'], function () {
            Route::post('/', 'RoleController@post');

            Route::delete('/', 'RoleController@del');

            Route::get('id/{id}', 'RoleController@getByID');
            Route::get('code/{code}', 'RoleController@getByCode');

            Route::get('/', 'RoleController@get');
            Route::get('/{limit}', 'RoleController@get');
        });

        Route::group(['prefix' => 'building'], function () {
            Route::post('/', 'BuildingController@post');

            Route::delete('/', 'BuildingController@del');

            Route::get('id/{id}', 'BuildingController@getByID');
            Route::get('code/{code}', 'BuildingController@getByCode');
            Route::get('campus/{campusId}', 'BuildingController@getByCampus');

            Route::get('/', 'BuildingController@get');
            Route::get('/{limit}', 'BuildingController@get');
        });

        Route::group(['prefix' => 'campus'], function () {
            Route::post('/', 'CampusController@post');

            Route::delete('/', 'CampusController@del');

            Route::get('id/{id}', 'CampusController@getByID');
            Route::get('code/{code}', 'CampusController@getByCode');

            Route::get('/', 'CampusController@get');
            Route::get('/{limit}', 'CampusController@get');
        });

        Route::group(['prefix' => 'department'], function () {
            Route::post('/', 'DepartmentController@post');

            Route::delete('/', 'DepartmentController@del');

            Route::get('id/{id}', 'DepartmentController@getByID');
            Route::get('code/{code}', 'DepartmentController@getByCode');

            Route::get('/', 'DepartmentController@get');
            Route::get('/{limit}', 'DepartmentController@get');
        });

        Route::group(['prefix' => 'course'], function () {
            Route::post('/', 'CourseController@post');

            Route::delete('/', 'CourseController@del');

            Route::get('id/{id}', 'CourseController@getByID');
            Route::get('code/{code}', 'CourseController@getByCode');

            Route::get('/', 'CourseController@get');
            Route::get('/{limit}', 'CourseController@get');
        });

        Route::group(['prefix' => 'community'], function () {
            Route::post('/', 'CommunityController@post');

            Route::delete('/', 'CommunityController@del');

            Route::get('id/{id}', 'CommunityController@getByID');
            Route::get('code/{code}', 'CommunityController@getByCode');

            Route::get('/', 'CommunityController@get');
            Route::get('/{limit}', 'CommunityController@get');
        });

    });

    Route::group(['prefix' => 'record'], function () {

        Route::get('/', 'RecordController@get');

        Route::group(['prefix' => 'room'], function () {
            Route::post('/', 'RoomRecordController@post');

            Route::delete('/', 'RoomRecordController@del');

            Route::get('id/{id}', 'RoomRecordController@getByID');

            Route::get('/', 'RoomRecordController@get');
            Route::get('/{limit}', 'RoomRecordController@get');
        });

        Route::group(['prefix' => 'email'], function () {
            Route::post('/', 'EmailRecordController@post');

            Route::delete('/', 'EmailRecordController@del');

            Route::get('id/{id}', 'EmailRecordController@getByID');
            Route::get('user/{id}', 'EmailRecordController@getByUser');

            Route::get('/', 'EmailRecordController@get');
            Route::get('/{limit}', 'EmailRecordController@get');
        });

        Route::group(['prefix' => 'phone'], function () {
            Route::post('/', 'PhoneRecordController@post');

            Route::delete('/', 'PhoneRecordController@del');

            Route::get('id/{id}', 'PhoneRecordController@getByID');

            Route::get('/', 'PhoneRecordController@get');
            Route::get('/{limit}', 'PhoneRecordController@get');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::post('/', 'UserRecordController@post');

            Route::delete('/', 'UserRecordController@del');

            Route::delete('/', 'UserRecordController@del');

            Route::get('id/{id}', 'UserRecordController@getByID');
            Route::get('sageid/{sageid}', 'UserRecordController@getBySageID');

            Route::get('/', 'UserRecordController@get');
            Route::get('/{limit}', 'UserRecordController@get');
        });

        Route::group(['prefix' => 'department'], function () {

        });

        Route::group(['prefix' => 'community'], function () {

        });

        Route::group(['prefix' => 'course'], function () {

        });

        Route::group(['prefix' => 'role'], function () {

        });

    });

});

