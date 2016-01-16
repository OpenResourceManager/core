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


        Route::resource('rooms', 'RoomController'); // Documented
        Route::get('rooms/user/{id}', 'RoomController@userRooms'); // Documented
        Route::get('rooms/user/user_id/{user_id}', 'RoomController@userRoomsByUserId'); // Documented
        Route::get('rooms/user/username/{username}', 'RoomController@userRoomsByUsername'); // Documented
        Route::get('rooms/campus/{id}', 'RoomController@campusRooms'); // Documented
        Route::get('rooms/campus/code/{code}', 'RoomController@campusRoomsByCode'); // Documented
        Route::get('rooms/building/{id}', 'RoomController@buildingRooms'); // Documented
        Route::get('rooms/building/code/{code}', 'RoomController@buildingRoomsByCode'); // Documented
        Route::post('rooms/user', 'RoomController@assignUserRoom'); // Documented
        Route::post('rooms/user_id', 'RoomController@assignUserRoomByUserId'); // Documented
        Route::post('rooms/username', 'RoomController@assignUserRoomByUsername'); // Documented
        Route::post('rooms/code/user', 'RoomController@assignUserRoomCode'); // Documented
        Route::post('rooms/code/user_id', 'RoomController@assignUserRoomCodeByUserId'); // Documented
        Route::post('rooms/code/username', 'RoomController@assignUserRoomCodeByUsername'); // Documented
        Route::delete('rooms/user', 'RoomController@unassignUserRoom'); // Documented
        Route::delete('rooms/user_id', 'RoomController@unassignUserRoomByUserId'); // Documented
        Route::delete('rooms/username', 'RoomController@unassignUserRoomByUsername'); // Documented
        Route::delete('rooms/code/user', 'RoomController@unassignUserRoomCode'); // Documented
        Route::delete('rooms/code/user_id', 'RoomController@unassignUserRoomCodeByUserId'); // Documented
        Route::delete('rooms/code/username', 'RoomController@unassignUserRoomCodeByUsername'); // Documented
        Route::delete('rooms/code/{code}', 'RoomController@destroyByCode'); // Documented


        Route::resource('users', 'UserController'); // Documented
        Route::get('users/user_id/{user_id}', 'UserController@showByUserId'); // Documented
        Route::get('users/username/{username}', 'UserController@showByUsername'); // Documented
        Route::get('users/role/{id}', 'UserController@roleUsers'); // Documented
        Route::get('users/role/code/{code}', 'UserController@roleUsersByCode'); // Documented
        Route::get('users/course/{id}', 'UserController@courseUsers'); // Documented
        Route::get('users/course/code/{code}', 'UserController@courseUsersByCode'); // Documented
        Route::get('users/room/{id}', 'UserController@roomUsers'); // Documented
        Route::delete('users/user_id/{user_id}', 'UserController@destroyByUserId'); // Documented
        Route::delete('users/username/{username}', 'UserController@destroyByUsername'); // Documented


        Route::resource('roles', 'RoleController'); // Documented
        Route::get('roles/code/{code}', 'RoleController@showByCode'); // Documented
        Route::get('roles/user/{id}', 'RoleController@userRoles'); // Documented
        Route::get('roles/user/user_id/{user_id}', 'RoleController@userRolesByUserId'); // Documented
        Route::get('roles/user/username/{username}', 'RoleController@userRolesByUsername'); // Documented
        Route::post('roles/user', 'RoleController@assignUserRole'); // Documented
        Route::post('roles/user_id', 'RoleController@assignUserRoleByUserId'); // Documented
        Route::post('roles/username', 'RoleController@assignUserRoleByUsername'); // Documented
        Route::post('roles/code/user', 'RoleController@assignUserRoleCode'); // Documented
        Route::post('roles/code/user_id', 'RoleController@assignUserRoleCodeByUserId'); // Documented
        Route::post('roles/code/username', 'RoleController@assignUserRoleCodeByUsername'); // Documented
        Route::delete('roles/user', 'RoleController@unassignUserRole'); // Documented
        Route::delete('roles/user_id', 'RoleController@unassignUserRoleByUserId'); // Documented
        Route::delete('roles/username', 'RoleController@unassignUserRoleByUsername'); // Documented
        Route::delete('roles/code/user', 'RoleController@unassignUserRoleCode'); // Documented
        Route::delete('roles/code/user_id', 'RoleController@unassignUserRoleCodeByUserId'); // Documented
        Route::delete('roles/code/username', 'RoleController@unassignUserRoleCodeByUsername'); // Documented
        Route::delete('roles/code/{code}', 'RoleController@destroyByCode'); // Documented


        Route::resource('emails', 'EmailController'); // Documented
        Route::get('emails/user/{id}', 'EmailController@userEmails'); // Documented
        Route::get('emails/user/user_id/{user_id}', 'EmailController@userEmailsByUserId'); // Documented
        Route::get('emails/user/username/{username}', 'EmailController@userEmailsByUsername'); // Documented


        Route::resource('passwords', 'PasswordController'); // Documented
        Route::get('passwords/user/{id}', 'PasswordController@userPasswords'); // Documented
        Route::get('passwords/user/user_id/{user_id}', 'PasswordController@userPasswordsByUserId'); // Documented
        Route::get('passwords/user/username/{username}', 'PasswordController@userPasswordsByUsername'); // Documented
        Route::post('passwords/user_id', 'PasswordController@storeUserPasswordByUserId'); // Documented
        Route::post('passwords/username', 'PasswordController@storeUserPasswordByUsername'); // Documented
        Route::delete('passwords/user', 'PasswordController@deleteUserPassword'); // Documented
        Route::delete('passwords/user_id', 'PasswordController@deleteUserPasswordByUserId'); // Documented
        Route::delete('passwords/username', 'PasswordController@deleteUserPasswordByUsername'); // Documented


        Route::resource('phones', 'PhoneController'); // Documented
        Route::get('phones/user/{id}', 'PhoneController@userPhones'); // Documented
        Route::get('phones/user/user_id/{user_id}', 'PhoneController@userPhonesByUserId'); // Documented
        Route::get('phones/user/username/{username}', 'PhoneController@userPhonesByUsername'); // Documented


        Route::resource('departments', 'DepartmentController'); // Documented
        Route::get('departments/code/{code}', 'DepartmentController@showByCode'); // Documented
        Route::get('departments/course/{id}', 'DepartmentController@courseDepartment'); // Documented
        Route::get('departments/course/code/{code}', 'DepartmentController@courseDepartmentByCode'); // Documented
        Route::delete('departments/code/{code}', 'DepartmentController@destroyByCode'); // Documented


        Route::resource('courses', 'CourseController'); // Documented
        Route::get('courses/code/{code}', 'CourseController@showByCode'); // Documented
        Route::get('courses/user/{id}', 'CourseController@userCourses'); // Documented
        Route::get('courses/user/user_id/{user_id}', 'CourseController@userCoursesByUserId'); // Documented
        Route::get('courses/user/username/{username}', 'CourseController@userCoursesUsername'); // Documented
        Route::get('courses/department/{id}', 'CourseController@departmentCourses'); // Documented
        Route::get('courses/department/code/{code}', 'CourseController@departmentCoursesByCode'); // Documented
        Route::delete('courses/code/{code}', 'CourseController@destroyByCode'); // Documented


        Route::resource('addresses', 'AddressController');
        Route::get('addresses/user/{id}', 'AddressController@userCourses');
        Route::get('addresses/user/user_id/{user_id}', 'AddressController@userAddressesByUserId');
        Route::get('addresses/user/username/{username}', 'AddressController@userAddressesByUsername');


        Route::resource('states', 'StateController');
        Route::get('states/code/{code}', 'StateController@showByCode');
        Route::delete('states/code/{code}', 'StateController@destroyByCode');


        Route::resource('countries', 'CountryController');
        Route::get('countries/code/{code}', 'CountryController@showByCode');
        Route::delete('countries/code/{code}', 'CountryController@destroyByCode');

    });
});