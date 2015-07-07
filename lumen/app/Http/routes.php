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


    $app->group(['prefix' => 'user'], function () use ($app) {

        $app->get('id/{id}', 'App\Http\Controllers\UserController@getByID');
        $app->get('sageid/{sageid}', 'App\Http\Controllers\UserController@getBySageID');

        $app->get('/', 'App\Http\Controllers\UserController@getUsers');
        $app->get('/{limit}', 'App\Http\Controllers\UserController@getUsers');

        $app->post('/', 'App\Http\Controllers\UserController@postUser');

    });

    $app->group(['prefix' => 'role'], function () use ($app) {

        $app->get('/', function () use ($app) {
            return $app->welcome();
        });
        $app->post('/', 'App\Http\Controllers\RoleController@postRole');

        $app->get('id/{id}', 'App\Http\Controllers\RoleController@getByID');
        $app->get('code/{code}', 'App\Http\Controllers\RoleController@getByCode');

    });

    $app->group(['prefix' => 'building'], function () use ($app) {

        $app->get('/', function () use ($app) {
            return $app->welcome();
        });
        $app->post('/', 'App\Http\Controllers\BuildingController@postBuilding');

        $app->get('id/{id}', 'App\Http\Controllers\BuildingController@getByID');
        $app->get('code/{code}', 'App\Http\Controllers\BuildingController@getByCode');

    });

    $app->group(['prefix' => 'campus'], function () use ($app) {

        $app->get('/', function () use ($app) {
            return $app->welcome();
        });
        $app->post('/', 'App\Http\Controllers\CampusController@postCampus');

        $app->get('id/{id}', 'App\Http\Controllers\CampusController@getByID');
        $app->get('code/{code}', 'App\Http\Controllers\CampusController@getByCode');

    });

    $app->group(['prefix' => 'program'], function () use ($app) {

        $app->get('/', function () use ($app) {
            return $app->welcome();
        });
        $app->post('/', 'App\Http\Controllers\ProgramController@postProgram');

        $app->get('id/{id}', 'App\Http\Controllers\ProgramController@getByID');
        $app->get('code/{code}', 'App\Http\Controllers\ProgramController@getByCode');

    });

    $app->group(['prefix' => 'department'], function () use ($app) {

        $app->get('/', function () use ($app) {
            return $app->welcome();
        });
        $app->post('/', 'App\Http\Controllers\DepartmentController@postDepartment');

        $app->get('id/{id}', 'App\Http\Controllers\DepartmentController@getByID');
        $app->get('code/{code}', 'App\Http\Controllers\DepartmentController@getByCode');

    });

});