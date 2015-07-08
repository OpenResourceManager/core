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

$app->get('/', function () use ($app) {
    return $app->welcome();
});

$app->group(['prefix' => 'v1'], function () use ($app) {

    $app->get('/', function () use ($app) {
        return $app->welcome();
    });
});

$app->group(['prefix' => 'v1/user'], function () use ($app) {

    $app->post('/', 'App\Http\Controllers\UserController@postUser');

    $app->get('id/{id}', 'App\Http\Controllers\UserController@getByID');
    $app->get('sageid/{sageid}', 'App\Http\Controllers\UserController@getBySageID');

    $app->get('/', 'App\Http\Controllers\UserController@get');
    $app->get('/{limit}', 'App\Http\Controllers\UserController@get');

});

$app->group(['prefix' => 'v1/role'], function () use ($app) {

    $app->post('/', 'App\Http\Controllers\RoleController@postRole');

    $app->get('id/{id}', 'App\Http\Controllers\RoleController@getByID');
    $app->get('code/{code}', 'App\Http\Controllers\RoleController@getByCode');

    $app->get('/', 'App\Http\Controllers\RoleController@get');
    $app->get('/{limit}', 'App\Http\Controllers\RoleController@get');

});

$app->group(['prefix' => 'v1/building'], function () use ($app) {

    $app->post('/', 'App\Http\Controllers\BuildingController@postBuilding');

    $app->get('id/{id}', 'App\Http\Controllers\BuildingController@getByID');
    $app->get('code/{code}', 'App\Http\Controllers\BuildingController@getByCode');
    $app->get('campus/{campusId}', 'App\Http\Controllers\BuildingController@getByCampus');

    $app->get('/', 'App\Http\Controllers\BuildingController@get');
    $app->get('/{limit}', 'App\Http\Controllers\BuildingController@get');

});

$app->group(['prefix' => 'v1/campus'], function () use ($app) {

    $app->post('/', 'App\Http\Controllers\CampusController@postCampus');

    $app->get('id/{id}', 'App\Http\Controllers\CampusController@getByID');
    $app->get('code/{code}', 'App\Http\Controllers\CampusController@getByCode');

    $app->get('/', 'App\Http\Controllers\CampusController@get');
    $app->get('/{limit}', 'App\Http\Controllers\CampusController@get');

});

$app->group(['prefix' => 'v1/program'], function () use ($app) {

    $app->post('/', 'App\Http\Controllers\ProgramController@postProgram');

    $app->get('id/{id}', 'App\Http\Controllers\ProgramController@getByID');
    $app->get('code/{code}', 'App\Http\Controllers\ProgramController@getByCode');
    $app->get('department/{departmentId}', 'App\Http\Controllers\ProgramController@getByDepartment');

    $app->get('/', 'App\Http\Controllers\ProgramController@get');
    $app->get('/{limit}', 'App\Http\Controllers\ProgramController@get');

});

$app->group(['prefix' => 'v1/department'], function () use ($app) {

    $app->post('/', 'App\Http\Controllers\DepartmentController@postDepartment');

    $app->get('id/{id}', 'App\Http\Controllers\DepartmentController@getByID');
    $app->get('code/{code}', 'App\Http\Controllers\DepartmentController@getByCode');

    $app->get('/', 'App\Http\Controllers\DepartmentController@get');
    $app->get('/{limit}', 'App\Http\Controllers\DepartmentController@get');

});

$app->group(['prefix' => 'v1/email'], function () use ($app) {

    $app->post('/', 'App\Http\Controllers\EmailController@postDepartment');

    $app->get('id/{id}', 'App\Http\Controllers\EmailController@getByID');
    $app->get('user/{id}', 'App\Http\Controllers\EmailController@getByUser');

    $app->get('/', 'App\Http\Controller\EmailController@get');
    $app->get('/{limit}', 'App\Http\Controllers\EmailController@get');

});

$app->group(['prefix' => 'v1/phone'], function () use ($app) {

    $app->post('/', 'App\Http\Controllers\PhoneController@postDepartment');

    $app->get('id/{id}', 'App\Http\Controllers\PhoneController@getByID');

    $app->get('/', 'App\Http\Controllers\PhoneController@get');
    $app->get('/{limit}', 'App\Http\Controllers\PhoneController@get');

});

$app->group(['prefix' => 'v1/room'], function () use ($app) {

    $app->post('/', 'App\Http\Controllers\RoomController@postDepartment');

    $app->get('id/{id}', 'App\Http\Controllers\RoomController@getByID');

    $app->get('/', 'App\Http\Controllers\RoomController@get');
    $app->get('/{limit}', 'App\Http\Controllers\RoomController@get');

});
