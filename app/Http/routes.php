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

        Route::resource('campuses', 'CampusController');
        Route::get('campuses/code/{code}', 'CampusController@showByCode');
        Route::get('campuses/{id}/building', 'BuildingController@campusBuildings');
        Route::get('campuses/{id}/room', 'RoomController@campusRooms');
        Route::get('campuses/{id}/user', 'UserController@campusUsers');

        Route::resource('buildings', 'BuildingController');
        Route::get('buildings/code/{code}', 'BuildingController@showByCode');
        Route::get('buildings/{id}/room', 'RoomController@buildingRooms');
        Route::get('buildings/{id}/user', 'UserController@buildingUsers');

        Route::resource('users', 'UserController');
        Route::get('users/{id}/room', 'RoomController@userRooms');
        Route::get('users/{id}/email', 'EmailController@userEmails');
        Route::get('users/{id}/phone', 'PhoneController@userPhones');
        Route::get('users/{id}/course', 'CourseController@userCourses');
        Route::get('users/user_id/{user_id}', 'UserController@showByUserId');
        Route::get('users/user_id/{user_id}/room', 'RoomController@userRoomsByUserId');

        Route::resource('rooms', 'RoomController');

        Route::resource('emails', 'EmailController');

        Route::resource('phones', 'PhoneController');

        Route::resource('departments', 'DepartmentController');
        Route::get('departments/code/{code}', 'DepartmentController@showByCode');
        Route::get('departments/{id}/course', 'CourseController@departmentCourses');

        Route::resource('courses', 'CourseController');
        Route::get('courses/code/{code}', 'CourseController@showByCode');
        Route::get('courses/{id}/user', 'UserController@courseUsers');
        Route::get('courses/{id}/department', 'DepartmentController@courseDepartment');

    });
});