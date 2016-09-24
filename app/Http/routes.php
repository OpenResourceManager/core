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

        Route::group(['prefix' => 'campuses'], function () {
            Route::get('code/{code}', 'CampusController@showByCode'); // Documented
            Route::delete('code/{code}', 'CampusController@destroyByCode'); // Documented
            Route::resource('/', 'CampusController'); // Documented
        });

        Route::group(['prefix' => 'buildings'], function () {
            Route::get('code/{code}', 'BuildingController@showByCode'); // Documented
            Route::get('campus/{id}', 'BuildingController@campusBuildings'); // Documented
            Route::get('campus/code/{code}', 'BuildingController@campusBuildingsByCode'); // Documented
            Route::post('campus/code', 'BuildingController@storeBuildingByCampusCode'); // Documented
            Route::delete('code/{code}', 'BuildingController@destroyByCode'); // Documented
            Route::resource('/', 'BuildingController'); // Documented
        });

        Route::group(['prefix' => 'rooms'], function () {
            Route::get('user/{id}', 'RoomController@userRooms'); // Documented
            Route::get('identifier/{identifier}', 'RoomController@userRoomsByIdentifier'); // Documented
            Route::get('username/{username}', 'RoomController@userRoomsByUsername'); // Documented
            Route::get('campus/{id}', 'RoomController@campusRooms'); // Documented
            Route::get('campus/code/{code}', 'RoomController@campusRoomsByCode'); // Documented
            Route::get('building/{id}', 'RoomController@buildingRooms'); // Documented
            Route::get('building/code/{code}', 'RoomController@buildingRoomsByCode'); // Documented
            Route::post('user', 'RoomController@assignUserRoom'); // Documented
            Route::post('identifier', 'RoomController@assignUserRoomByIdentifier'); // Documented
            Route::post('username', 'RoomController@assignUserRoomByUsername'); // Documented
            Route::post('code/user', 'RoomController@assignUserRoomCode'); // Documented
            Route::post('code/identifier', 'RoomController@assignUserRoomCodeByIdentifier'); // Documented
            Route::post('code/username', 'RoomController@assignUserRoomCodeByUsername'); // Documented
            Route::delete('user', 'RoomController@unassignUserRoom'); // Documented
            Route::delete('identifier', 'RoomController@unassignUserRoomByIdentifier'); // Documented
            Route::delete('username', 'RoomController@unassignUserRoomByUsername'); // Documented
            Route::delete('code/user', 'RoomController@unassignUserRoomCode'); // Documented
            Route::delete('code/identifier', 'RoomController@unassignUserRoomCodeByIdentifier'); // Documented
            Route::delete('code/username', 'RoomController@unassignUserRoomCodeByUsername'); // Documented
            Route::delete('code/{code}', 'RoomController@destroyByCode'); // Documented
            Route::resource('/', 'RoomController'); // Documented
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('identifier/{identifier}', 'UserController@showByIdentifier'); // Documented
            Route::get('username/{username}', 'UserController@showByUsername'); // Documented
            Route::get('role/{id}', 'UserController@roleUsers'); // Documented
            Route::get('role/code/{code}', 'UserController@roleUsersByCode'); // Documented
            Route::get('course/{id}', 'UserController@courseUsers'); // Documented
            Route::get('course/code/{code}', 'UserController@courseUsersByCode'); // Documented
            Route::get('room/{id}', 'UserController@roomUsers'); // Documented
            Route::delete('identifier/{identifier}', 'UserController@destroyByIdentifier'); // Documented
            Route::delete('username/{username}', 'UserController@destroyByUsername'); // Documented
            Route::resource('/', 'UserController'); // Documented
        });

        Route::group(['prefix' => 'roles'], function () {
            Route::get('code/{code}', 'RoleController@showByCode'); // Documented
            Route::get('user/{id}', 'RoleController@userRoles'); // Documented
            Route::get('identifier/{identifier}', 'RoleController@userRolesByIdentifier'); // Documented
            Route::get('username/{username}', 'RoleController@userRolesByUsername'); // Documented
            Route::post('user', 'RoleController@assignUserRole'); // Documented
            Route::post('identifier', 'RoleController@assignUserRoleByIdentifier'); // Documented
            Route::post('username', 'RoleController@assignUserRoleByUsername'); // Documented
            Route::post('code/user', 'RoleController@assignUserRoleCode'); // Documented
            Route::post('code/identifier', 'RoleController@assignUserRoleCodeByIdentifier'); // Documented
            Route::post('code/username', 'RoleController@assignUserRoleCodeByUsername'); // Documented
            Route::delete('user', 'RoleController@unassignUserRole'); // Documented
            Route::delete('identifier', 'RoleController@unassignUserRoleByIdentifier'); // Documented
            Route::delete('username', 'RoleController@unassignUserRoleByUsername'); // Documented
            Route::delete('code/user', 'RoleController@unassignUserRoleCode'); // Documented
            Route::delete('code/identifier', 'RoleController@unassignUserRoleCodeByIdentifier'); // Documented
            Route::delete('code/username', 'RoleController@unassignUserRoleCodeByUsername'); // Documented
            Route::delete('code/{code}', 'RoleController@destroyByCode'); // Documented
            Route::resource('/', 'RoleController'); // Documented
        });

        Route::group(['prefix' => 'emails'], function () {
            Route::group(['prefix' => 'verified'], function () {
                Route::get('user/{id}', 'EmailController@userVerifiedEmails'); // @todo document this
                Route::get('identifier/{identifier}', 'EmailController@userVerifiedEmailsByIdentifier'); // @todo document this
                Route::get('username/{username}', 'EmailController@userVerifiedEmailsByUsername'); // @todo document this
            });
            Route::get('user/{id}', 'EmailController@userEmails'); // Documented
            Route::get('identifier/{identifier}', 'EmailController@userEmailsByIdentifier'); // Documented
            Route::get('username/{username}', 'EmailController@userEmailsByUsername'); // Documented
            Route::post('identifier', 'EmailController@storeUserEmailByIdentifier'); // Documented
            Route::post('username', 'EmailController@storeUserEmailByUsername'); // Documented
            Route::delete('address', 'EmailController@destroyByAddress'); // Documented
            Route::resource('/', 'EmailController'); // Documented
        });

        Route::group(['prefix' => 'phones'], function () {
            Route::group(['prefix' => 'verified'], function () {
                Route::get('user/{id}', 'PhoneController@userVerifiedPhones'); // @todo document this
                Route::get('identifier/{identifier}', 'PhoneController@userVerifiedPhonesByIdentifier'); // @todo document this
                Route::get('username/{username}', 'PhoneController@userVerifiedPhonesByUsername'); // @todo document this
            });
            Route::get('user/{id}', 'PhoneController@userPhones'); // Documented
            Route::get('identifier/{identifier}', 'PhoneController@userPhonesByIdentifier'); // Documented
            Route::get('username/{username}', 'PhoneController@userPhonesByUsername'); // Documented
            Route::resource('/', 'PhoneController'); // Documented
        });

        Route::group(['prefix' => 'passwords'], function () {
            Route::get('user/{id}', 'PasswordController@userPasswords'); // Documented
            Route::get('identifier/{identifier}', 'PasswordController@userPasswordsByIdentifier'); // Documented
            Route::get('username/{username}', 'PasswordController@userPasswordsByUsername'); // Documented
            Route::post('identifier', 'PasswordController@storeUserPasswordByIdentifier'); // Documented
            Route::post('username', 'PasswordController@storeUserPasswordByUsername'); // Documented
            Route::delete('user', 'PasswordController@deleteUserPassword'); // Documented
            Route::delete('identifier', 'PasswordController@deleteUserPasswordByIdentifier'); // Documented
            Route::delete('username', 'PasswordController@deleteUserPasswordByUsername'); // Documented
            Route::resource('/', 'PasswordController'); // Documented
        });

        Route::group(['prefix' => 'ssn'], function () {
            Route::get('user/{id}', 'SocialSecurityNumberController@userSocialSecurityNumbers'); // Documented
            Route::get('identifier/{identifier}', 'SocialSecurityNumberController@userSocialSecurityNumbersByIdentifier'); // Documented
            Route::get('username/{username}', 'SocialSecurityNumberController@userSocialSecurityNumbersByUsername'); // Documented
            Route::post('identifier', 'SocialSecurityNumberController@storeUserSocialSecurityNumberByIdentifier'); // Documented
            Route::post('username', 'SocialSecurityNumberController@storeUserSocialSecurityNumberByUsername'); // Documented
            Route::delete('user', 'SocialSecurityNumberController@deleteUserSocialSecurityNumber'); // Documented
            Route::delete('identifier', 'SocialSecurityNumberController@deleteUserSocialSecurityNumberByIdentifier'); // Documented
            Route::delete('username', 'SocialSecurityNumberController@deleteUserSocialSecurityNumberByUsername'); // Documented
            Route::resource('/', 'SocialSecurityNumberController'); // Documented
        });

        Route::group(['prefix' => 'birthdates'], function () {
            Route::get('user/{id}', 'BirthDateController@userBirthDates'); // Documented
            Route::get('identifier/{identifier}', 'BirthDateController@userBirthDatesByIdentifier'); // Documented
            Route::get('username/{username}', 'BirthDateController@userBirthDatesByUsername'); // Documented
            Route::post('identifier', 'BirthDateController@storeUserBirthDateByIdentifier'); // Documented
            Route::post('username', 'BirthDateController@storeUserBirthDateByUsername'); // Documented
            Route::delete('user', 'BirthDateController@deleteUserBirthDate'); // Documented
            Route::delete('identifier', 'BirthDateController@deleteUserBirthDateByIdentifier'); // Documented
            Route::delete('username', 'BirthDateController@deleteUserBirthDateByUsername'); // Documented
            Route::resource('/', 'BirthDateController'); // Documented
        });

        Route::group(['prefix' => 'mobilecarriers'], function () {
            Route::get('code/{code}', 'MobileCarrierController@showByCode'); // Documented
            Route::delete('code/{code}', 'MobileCarrierController@destroyByCode'); // Documented
            Route::resource('/', 'MobileCarrierController'); // Documented
        });

        Route::group(['prefix' => 'departments'], function () {
            Route::get('user/{id}', 'DepartmentController@userDepartments'); // Documented
            Route::get('username/{username}', 'DepartmentController@userDepartmentsByUsername'); // Documented
            Route::get('identifier/{identifier}', 'DepartmentController@userDepartmentsByIdentifier'); // Documented
            Route::get('code/{code}', 'DepartmentController@showByCode'); // Documented
            Route::get('course/{id}', 'DepartmentController@courseDepartment'); // Documented
            Route::get('course/code/{code}', 'DepartmentController@courseDepartmentByCode'); // Documented
            Route::post('user', 'DepartmentController@assignUserDepartment'); // Documented
            Route::post('identifier', 'DepartmentController@assignUserDepartmentByIdentifier'); // Documented
            Route::post('username', 'DepartmentController@assignUserDepartmentByUsername'); // Documented
            Route::post('code/user', 'DepartmentController@assignUserDepartmentCode'); // Documented
            Route::post('code/identifier', 'DepartmentController@assignUserDepartmentCodeByIdentifier'); // Documented
            Route::post('code/username', 'DepartmentController@assignUserDepartmentCodeByUsername');
            Route::delete('user', 'DepartmentController@unassignUserDepartment'); // Documented
            Route::delete('identifier', 'DepartmentController@unassignUserDepartmentByIdentifier'); // Documented
            Route::delete('username', 'DepartmentController@unassignUserDepartmentByUsername'); // Documented
            Route::delete('code/user', 'DepartmentController@unassignUserDepartmentCode'); // Documented
            Route::delete('code/identifier', 'DepartmentController@unassignUserDepartmentCodeByIdentifier'); // Documented
            Route::delete('code/username', 'DepartmentController@unassignUserDepartmentCodeByUsername'); // Documented
            Route::delete('code/{code}', 'DepartmentController@destroyByCode'); // Documented
            Route::resource('/', 'DepartmentController'); // Documented
        });

        Route::group(['prefix' => 'courses'], function () {
            Route::get('code/{code}', 'CourseController@showByCode'); // Documented
            Route::get('user/{id}', 'CourseController@userCourses'); // Documented
            Route::get('identifier/{identifier}', 'CourseController@userCoursesByIdentifier'); // Documented
            Route::get('username/{username}', 'CourseController@userCoursesUsername'); // Documented
            Route::get('department/{id}', 'CourseController@departmentCourses'); // Documented
            Route::get('department/code/{code}', 'CourseController@departmentCoursesByCode'); // Documented
            Route::post('department/code', 'CourseController@storeByDepartmentCode'); // Documented
            Route::post('user', 'CourseController@assignUserCourse'); // Documented
            Route::post('identifier', 'CourseController@assignUserCourseByIdentifier'); // Documented
            Route::post('username', 'CourseController@assignUserCourseByUsername'); // Documented
            Route::post('code/user', 'CourseController@assignUserCourseCode'); // Documented
            Route::post('code/identifier', 'CourseController@assignUserCourseCodeByIdentifier'); // Documented
            Route::post('code/username', 'CourseController@assignUserCourseCodeByUsername'); // Documented
            Route::delete('user', 'CourseController@unassignUserCourse'); // Documented
            Route::delete('identifier', 'CourseController@unassignUserCourseByIdentifier'); // Documented
            Route::delete('username', 'CourseController@unassignUserCourseByUsername'); // Documented
            Route::delete('code/user', 'CourseController@unassignUserCourseCode'); // Documented
            Route::delete('code/identifier', 'CourseController@unassignUserCourseCodeByIdentifier'); // Documented
            Route::delete('code/username', 'CourseController@unassignUserCourseCodeByUsername'); // Documented
            Route::delete('code/{code}', 'CourseController@destroyByCode'); // Documented
            Route::resource('/', 'CourseController'); // Documented
        });

        Route::group(['prefix' => 'addresses'], function () {
            Route::get('user/{id}', 'AddressController@userCourses'); // Documented
            Route::get('identifier/{identifier}', 'AddressController@userAddressesByIdentifier'); // Documented
            Route::get('username/{username}', 'AddressController@userAddressesByUsername'); // Documented
            Route::resource('/', 'AddressController'); // Documented
        });

        Route::group(['prefix' => 'states'], function () {
            Route::get('code/{code}', 'StateController@showByCode'); // Documented
            Route::delete('code/{code}', 'StateController@destroyByCode'); // Documented
            Route::resource('/', 'StateController'); // Documented
        });

        Route::group(['prefix' => 'countries'], function () {
            Route::get('code/{code}', 'CountryController@showByCode'); // Documented
            Route::delete('code/{code}', 'CountryController@destroyByCode'); // Documented
            Route::resource('/', 'CountryController'); // Documented
        });
    });
});