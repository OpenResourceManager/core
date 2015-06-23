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

use App\Http\Controllers\Controller;

$app->get('/', function () use ($app) {
    return $app->welcome();
});

$app->group(['prefix' => 'api'], function () use ($app) {

    $app->get('/', function () use ($app) {
        return $app->welcome();
    });

    $app->group(['prefix' => 'api/v1'], function () use ($app) {

        return Controller::hello();

    });

});