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
        Route::post('/', 'RoleController@post');

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

    Route::group(['prefix' => 'program'], function () {
        Route::post('/', 'ProgramController@post');

        Route::get('id/{id}', 'ProgramController@getByID');
        Route::get('code/{code}', 'ProgramController@getByCode');
        Route::get('department/{departmentId}', 'ProgramController@getByDepartment');

        Route::get('/', 'ProgramController@get');
        Route::get('/{limit}', 'ProgramController@get');
    });

    Route::group(['prefix' => 'department'], function () {
        Route::post('/', 'DepartmentController@post');

        Route::delete('/', 'DepartmentController@del');

        Route::get('id/{id}', 'DepartmentController@getByID');
        Route::get('code/{code}', 'DepartmentController@getByCode');

        Route::get('/', 'DepartmentController@get');
        Route::get('/{limit}', 'DepartmentController@get');
    });

    Route::group(['prefix' => 'email'], function () {
        Route::post('/', 'EmailController@post');

        Route::delete('/', 'EmailController@del');

        Route::get('id/{id}', 'EmailController@getByID');
        Route::get('user/{id}', 'EmailController@getByUser');

        Route::get('/', 'EmailController@get');
        Route::get('/{limit}', 'EmailController@get');
    });

    Route::group(['prefix' => 'phone'], function () {
        Route::post('/', 'PhoneController@post');

        Route::get('id/{id}', 'PhoneController@getByID');

        Route::get('/', 'PhoneController@get');
        Route::get('/{limit}', 'PhoneController@get');
    });

    Route::group(['prefix' => 'room'], function () {
        Route::post('/', 'RoomController@post');

        Route::get('id/{id}', 'RoomController@getByID');

        Route::get('/', 'RoomController@get');
        Route::get('/{limit}', 'RoomController@get');
    });

    Route::group(['prefix' => 'course'], function () {

    });

});

