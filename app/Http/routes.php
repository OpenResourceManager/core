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

        Route::resource('campuses', 'CampusController'); // Documented
        Route::get('campuses/code/{code}', 'CampusController@showByCode'); // Documented
        Route::delete('campuses/code/{code}', 'CampusController@destroyByCode'); // Documented


        Route::resource('buildings', 'BuildingController'); // Documented
        Route::get('buildings/code/{code}', 'BuildingController@showByCode'); // Documented
        Route::get('buildings/campus/{id}', 'BuildingController@campusBuildings'); // Documented
        Route::get('buildings/campus/code/{code}', 'BuildingController@campusBuildingsByCode'); // Documented
        Route::delete('buildings/code/{code}', 'BuildingController@destroyByCode'); // Documented


        Route::resource('rooms', 'RoomController');
        Route::get('rooms/user/{id}', 'RoomController@userRooms');
        Route::get('rooms/user/user_id/{user_id}', 'RoomController@userRoomsByUserId');
        Route::get('rooms/user/username/{username}', 'RoomController@userRoomsByUsername');
        Route::get('rooms/campus/{id}', 'RoomController@campusRooms');
        Route::get('rooms/buildings/{id}', 'RoomController@buildingRooms');


        Route::resource('users', 'UserController'); // Documented
        Route::get('users/user_id/{user_id}', 'UserController@showByUserId'); // Documented
        Route::get('users/username/{username}', 'UserController@showByUsername'); // Documented
        Route::get('users/building/{id}', 'UserController@buildingUsers'); // Documented
        Route::get('users/building/code/{code}', 'UserController@buildingUsersByCode'); // Documented
        Route::get('users/role/{id}', 'UserController@roleUsers'); // Documented
        Route::get('users/role/code/{code}', 'UserController@roleUsersByCode'); // Documented
        Route::get('users/course/{id}', 'UserController@courseUsers'); // Documented
        Route::get('users/course/code/{code}', 'UserController@courseUsersByCode'); // Documented
        Route::get('users/campus/{id}', 'UserController@campusUsers'); // Documented
        Route::get('users/campus/code/{code}', 'UserController@campusUsersByCode'); // Documented
        Route::get('users/room/{id}', 'UserController@roomsUsers'); // Documented
        Route::delete('users/user_id/{user_id}', 'UserController@destroyByUserId'); // Documented
        Route::delete('users/username/{username}', 'UserController@destroyByUsername'); // Documented


        Route::resource('roles', 'RoleController');
        Route::get('roles/code/{code}', 'RoleController@showByCode');
        Route::get('roles/user/{id}', 'RoleController@userRoles');
        Route::get('roles/user/user_id/{user_id}', 'RoleController@userRolesByUserId');
        Route::get('roles/user/username/{username}', 'RoleController@userRolesByUsername');
        Route::delete('roles/code/{code}', 'RoleController@destroyByCode');


        Route::resource('emails', 'EmailController'); // Documented
        Route::get('emails/user/{id}', 'EmailController@userEmails'); // Documented
        Route::get('emails/user/user_id/{user_id}', 'EmailController@userEmailsByUserId'); // Documented
        Route::get('emails/user/username/{username}', 'EmailController@userEmailsByUsername'); // Documented


        Route::resource('phones', 'PhoneController');
        Route::get('phones/user/{id}', 'PhoneController@userPhones'); // Documented
        Route::get('phones/user/user_id/{user_id}', 'PhoneController@userPhonesByUserId'); // Documented
        Route::get('phones/user/username/{username}', 'PhoneController@userPhonesByUsername'); // Documented


        Route::resource('departments', 'DepartmentController');
        Route::get('departments/code/{code}', 'DepartmentController@showByCode');
        Route::get('departments/course/{id}', 'DepartmentController@courseDepartment');
        Route::get('departments/course/code/{code}', 'DepartmentController@courseDepartmentByCode');
        Route::delete('departments/code/{code}', 'DepartmentController@destroyByCode');


        Route::resource('courses', 'CourseController');
        Route::get('courses/code/{code}', 'CourseController@showByCode');
        Route::get('courses/user/{id}', 'CourseController@userCourses');
        Route::get('courses/user/user_id/{user_id}', 'CourseController@userCoursesByUserId');
        Route::get('courses/user/username/{username}', 'CourseController@userCoursesUsername');
        Route::get('courses/department/{id}', 'CourseController@departmentCourses');
        Route::get('courses/department/code/{code}', 'CourseController@departmentCoursesByCode');
        Route::delete('courses/code/{code}', 'CourseController@destroyByCode');


        /* Route::resource('communities', 'CommunityController');
         Route::get('communities/{id}/user', 'CommunityController@communityUsers');
         Route::get('communities/code/{code}', 'CommunityController@showByCode');
         Route::delete('communities/code/{code}', 'CommunityController@destroyByCode');*/


    });
});