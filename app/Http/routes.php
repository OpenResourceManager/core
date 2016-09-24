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


        Route::get('verify/{token}', 'TokenVerificationController@verify'); // @todo document this route

        Route::get('campuses/code/{code}', 'CampusController@showByCode'); // Documented
        Route::delete('campuses/code/{code}', 'CampusController@destroyByCode'); // Documented
        Route::resource('campuses', 'CampusController'); // Documented


        Route::get('buildings/code/{code}', 'BuildingController@showByCode'); // Documented
        Route::get('buildings/campus/{id}', 'BuildingController@campusBuildings'); // Documented
        Route::get('buildings/campus/code/{code}', 'BuildingController@campusBuildingsByCode'); // Documented
        Route::post('buildings/campus/code', 'BuildingController@storeBuildingByCampusCode'); // Documented
        Route::delete('buildings/code/{code}', 'BuildingController@destroyByCode'); // Documented
        Route::resource('buildings', 'BuildingController'); // Documented


        Route::get('rooms/user/{id}', 'RoomController@userRooms'); // Documented
        Route::get('rooms/identifier/{identifier}', 'RoomController@userRoomsByIdentifier'); // Documented
        Route::get('rooms/username/{username}', 'RoomController@userRoomsByUsername'); // Documented
        Route::get('rooms/campus/{id}', 'RoomController@campusRooms'); // Documented
        Route::get('rooms/campus/code/{code}', 'RoomController@campusRoomsByCode'); // Documented
        Route::get('rooms/building/{id}', 'RoomController@buildingRooms'); // Documented
        Route::get('rooms/building/code/{code}', 'RoomController@buildingRoomsByCode'); // Documented
        Route::post('rooms/user', 'RoomController@assignUserRoom'); // Documented
        Route::post('rooms/identifier', 'RoomController@assignUserRoomByIdentifier'); // Documented
        Route::post('rooms/username', 'RoomController@assignUserRoomByUsername'); // Documented
        Route::post('rooms/code/user', 'RoomController@assignUserRoomCode'); // Documented
        Route::post('rooms/code/identifier', 'RoomController@assignUserRoomCodeByIdentifier'); // Documented
        Route::post('rooms/code/username', 'RoomController@assignUserRoomCodeByUsername'); // Documented
        Route::delete('rooms/user', 'RoomController@unassignUserRoom'); // Documented
        Route::delete('rooms/identifier', 'RoomController@unassignUserRoomByIdentifier'); // Documented
        Route::delete('rooms/username', 'RoomController@unassignUserRoomByUsername'); // Documented
        Route::delete('rooms/code/user', 'RoomController@unassignUserRoomCode'); // Documented
        Route::delete('rooms/code/identifier', 'RoomController@unassignUserRoomCodeByIdentifier'); // Documented
        Route::delete('rooms/code/username', 'RoomController@unassignUserRoomCodeByUsername'); // Documented
        Route::delete('rooms/code/{code}', 'RoomController@destroyByCode'); // Documented
        Route::resource('rooms', 'RoomController'); // Documented


        Route::get('users/identifier/{identifier}', 'UserController@showByIdentifier'); // Documented
        Route::get('users/username/{username}', 'UserController@showByUsername'); // Documented
        Route::get('users/role/{id}', 'UserController@roleUsers'); // Documented
        Route::get('users/role/code/{code}', 'UserController@roleUsersByCode'); // Documented
        Route::get('users/course/{id}', 'UserController@courseUsers'); // Documented
        Route::get('users/course/code/{code}', 'UserController@courseUsersByCode'); // Documented
        Route::get('users/room/{id}', 'UserController@roomUsers'); // Documented
        Route::delete('users/identifier/{identifier}', 'UserController@destroyByIdentifier'); // Documented
        Route::delete('users/username/{username}', 'UserController@destroyByUsername'); // Documented
        Route::resource('users', 'UserController'); // Documented


        Route::get('roles/code/{code}', 'RoleController@showByCode'); // Documented
        Route::get('roles/user/{id}', 'RoleController@userRoles'); // Documented
        Route::get('roles/identifier/{identifier}', 'RoleController@userRolesByIdentifier'); // Documented
        Route::get('roles/username/{username}', 'RoleController@userRolesByUsername'); // Documented
        Route::post('roles/user', 'RoleController@assignUserRole'); // Documented
        Route::post('roles/identifier', 'RoleController@assignUserRoleByIdentifier'); // Documented
        Route::post('roles/username', 'RoleController@assignUserRoleByUsername'); // Documented
        Route::post('roles/code/user', 'RoleController@assignUserRoleCode'); // Documented
        Route::post('roles/code/identifier', 'RoleController@assignUserRoleCodeByIdentifier'); // Documented
        Route::post('roles/code/username', 'RoleController@assignUserRoleCodeByUsername'); // Documented
        Route::delete('roles/user', 'RoleController@unassignUserRole'); // Documented
        Route::delete('roles/identifier', 'RoleController@unassignUserRoleByIdentifier'); // Documented
        Route::delete('roles/username', 'RoleController@unassignUserRoleByUsername'); // Documented
        Route::delete('roles/code/user', 'RoleController@unassignUserRoleCode'); // Documented
        Route::delete('roles/code/identifier', 'RoleController@unassignUserRoleCodeByIdentifier'); // Documented
        Route::delete('roles/code/username', 'RoleController@unassignUserRoleCodeByUsername'); // Documented
        Route::delete('roles/code/{code}', 'RoleController@destroyByCode'); // Documented
        Route::resource('roles', 'RoleController'); // Documented


        Route::get('emails/user/{id}', 'EmailController@userEmails'); // Documented
        Route::get('emails/identifier/{identifier}', 'EmailController@userEmailsByIdentifier'); // Documented
        Route::get('emails/username/{username}', 'EmailController@userEmailsByUsername'); // Documented
        Route::post('emails/identifier', 'EmailController@storeUserEmailByIdentifier'); // Documented
        Route::post('emails/username', 'EmailController@storeUserEmailByUsername'); // Documented
        Route::delete('emails/address', 'EmailController@destroyByAddress'); // Documented
        Route::resource('emails', 'EmailController'); // Documented


        Route::get('passwords/user/{id}', 'PasswordController@userPasswords'); // Documented
        Route::get('passwords/identifier/{identifier}', 'PasswordController@userPasswordsByIdentifier'); // Documented
        Route::get('passwords/username/{username}', 'PasswordController@userPasswordsByUsername'); // Documented
        Route::post('passwords/identifier', 'PasswordController@storeUserPasswordByIdentifier'); // Documented
        Route::post('passwords/username', 'PasswordController@storeUserPasswordByUsername'); // Documented
        Route::delete('passwords/user', 'PasswordController@deleteUserPassword'); // Documented
        Route::delete('passwords/identifier', 'PasswordController@deleteUserPasswordByIdentifier'); // Documented
        Route::delete('passwords/username', 'PasswordController@deleteUserPasswordByUsername'); // Documented
        Route::resource('passwords', 'PasswordController'); // Documented



        Route::get('ssn/user/{id}', 'SocialSecurityNumberController@userSocialSecurityNumbers'); // Documented
        Route::get('ssn/identifier/{identifier}', 'SocialSecurityNumberController@userSocialSecurityNumbersByIdentifier'); // Documented
        Route::get('ssn/username/{username}', 'SocialSecurityNumberController@userSocialSecurityNumbersByUsername'); // Documented
        Route::post('ssn/identifier', 'SocialSecurityNumberController@storeUserSocialSecurityNumberByIdentifier'); // Documented
        Route::post('ssn/username', 'SocialSecurityNumberController@storeUserSocialSecurityNumberByUsername'); // Documented
        Route::delete('ssn/user', 'SocialSecurityNumberController@deleteUserSocialSecurityNumber'); // Documented
        Route::delete('ssn/identifier', 'SocialSecurityNumberController@deleteUserSocialSecurityNumberByIdentifier'); // Documented
        Route::delete('ssn/username', 'SocialSecurityNumberController@deleteUserSocialSecurityNumberByUsername'); // Documented
        Route::resource('ssn', 'SocialSecurityNumberController'); // Documented


        Route::get('birthdates/user/{id}', 'BirthDateController@userBirthDates'); // Documented
        Route::get('birthdates/identifier/{identifier}', 'BirthDateController@userBirthDatesByIdentifier'); // Documented
        Route::get('birthdates/username/{username}', 'BirthDateController@userBirthDatesByUsername'); // Documented
        Route::post('birthdates/identifier', 'BirthDateController@storeUserBirthDateByIdentifier'); // Documented
        Route::post('birthdates/username', 'BirthDateController@storeUserBirthDateByUsername'); // Documented
        Route::delete('birthdates/user', 'BirthDateController@deleteUserBirthDate'); // Documented
        Route::delete('birthdates/identifier', 'BirthDateController@deleteUserBirthDateByIdentifier'); // Documented
        Route::delete('birthdates/username', 'BirthDateController@deleteUserBirthDateByUsername'); // Documented
        Route::resource('birthdates', 'BirthDateController'); // Documented


        Route::get('mobilecarriers/code/{code}', 'MobileCarrierController@showByCode'); // Documented
        Route::delete('mobilecarriers/code/{code}', 'MobileCarrierController@destroyByCode'); // Documented
        Route::resource('mobilecarriers', 'MobileCarrierController'); // Documented


        Route::get('phones/user/{id}', 'PhoneController@userPhones'); // Documented
        Route::get('phones/identifier/{identifier}', 'PhoneController@userPhonesByIdentifier'); // Documented
        Route::get('phones/username/{username}', 'PhoneController@userPhonesByUsername'); // Documented
        Route::resource('phones', 'PhoneController'); // Documented


        Route::get('departments/user/{id}', 'DepartmentController@userDepartments'); // Documented
        Route::get('departments/username/{username}', 'DepartmentController@userDepartmentsByUsername'); // Documented
        Route::get('departments/identifier/{identifier}', 'DepartmentController@userDepartmentsByIdentifier'); // Documented
        Route::get('departments/code/{code}', 'DepartmentController@showByCode'); // Documented
        Route::get('departments/course/{id}', 'DepartmentController@courseDepartment'); // Documented
        Route::get('departments/course/code/{code}', 'DepartmentController@courseDepartmentByCode'); // Documented
        Route::post('departments/user', 'DepartmentController@assignUserDepartment'); // Documented
        Route::post('departments/identifier', 'DepartmentController@assignUserDepartmentByIdentifier'); // Documented
        Route::post('departments/username', 'DepartmentController@assignUserDepartmentByUsername'); // Documented
        Route::post('departments/code/user', 'DepartmentController@assignUserDepartmentCode'); // Documented
        Route::post('departments/code/identifier', 'DepartmentController@assignUserDepartmentCodeByIdentifier'); // Documented
        Route::post('departments/code/username', 'DepartmentController@assignUserDepartmentCodeByUsername');
        Route::delete('departments/user', 'DepartmentController@unassignUserDepartment'); // Documented
        Route::delete('departments/identifier', 'DepartmentController@unassignUserDepartmentByIdentifier'); // Documented
        Route::delete('departments/username', 'DepartmentController@unassignUserDepartmentByUsername'); // Documented
        Route::delete('departments/code/user', 'DepartmentController@unassignUserDepartmentCode'); // Documented
        Route::delete('departments/code/identifier', 'DepartmentController@unassignUserDepartmentCodeByIdentifier'); // Documented
        Route::delete('departments/code/username', 'DepartmentController@unassignUserDepartmentCodeByUsername'); // Documented
        Route::delete('departments/code/{code}', 'DepartmentController@destroyByCode'); // Documented
        Route::resource('departments', 'DepartmentController'); // Documented


        Route::get('courses/code/{code}', 'CourseController@showByCode'); // Documented
        Route::get('courses/user/{id}', 'CourseController@userCourses'); // Documented
        Route::get('courses/identifier/{identifier}', 'CourseController@userCoursesByIdentifier'); // Documented
        Route::get('courses/username/{username}', 'CourseController@userCoursesUsername'); // Documented
        Route::get('courses/department/{id}', 'CourseController@departmentCourses'); // Documented
        Route::get('courses/department/code/{code}', 'CourseController@departmentCoursesByCode'); // Documented
        Route::post('courses/department/code', 'CourseController@storeByDepartmentCode'); // Documented
        Route::post('courses/user', 'CourseController@assignUserCourse'); // Documented
        Route::post('courses/identifier', 'CourseController@assignUserCourseByIdentifier'); // Documented
        Route::post('courses/username', 'CourseController@assignUserCourseByUsername'); // Documented
        Route::post('courses/code/user', 'CourseController@assignUserCourseCode'); // Documented
        Route::post('courses/code/identifier', 'CourseController@assignUserCourseCodeByIdentifier'); // Documented
        Route::post('courses/code/username', 'CourseController@assignUserCourseCodeByUsername'); // Documented
        Route::delete('courses/user', 'CourseController@unassignUserCourse'); // Documented
        Route::delete('courses/identifier', 'CourseController@unassignUserCourseByIdentifier'); // Documented
        Route::delete('courses/username', 'CourseController@unassignUserCourseByUsername'); // Documented
        Route::delete('courses/code/user', 'CourseController@unassignUserCourseCode'); // Documented
        Route::delete('courses/code/identifier', 'CourseController@unassignUserCourseCodeByIdentifier'); // Documented
        Route::delete('courses/code/username', 'CourseController@unassignUserCourseCodeByUsername'); // Documented
        Route::delete('courses/code/{code}', 'CourseController@destroyByCode'); // Documented
        Route::resource('courses', 'CourseController'); // Documented


        Route::get('addresses/user/{id}', 'AddressController@userCourses'); // Documented
        Route::get('addresses/identifier/{identifier}', 'AddressController@userAddressesByIdentifier'); // Documented
        Route::get('addresses/username/{username}', 'AddressController@userAddressesByUsername'); // Documented
        Route::resource('addresses', 'AddressController'); // Documented


        Route::get('states/code/{code}', 'StateController@showByCode'); // Documented
        Route::delete('states/code/{code}', 'StateController@destroyByCode'); // Documented
        Route::resource('states', 'StateController'); // Documented


        Route::get('countries/code/{code}', 'CountryController@showByCode'); // Documented
        Route::delete('countries/code/{code}', 'CountryController@destroyByCode'); // Documented
        Route::resource('countries', 'CountryController'); // Documented

    });
});