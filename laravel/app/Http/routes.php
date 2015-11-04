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
    return view('welcome');
});

$app->group(['prefix' => 'v1'], function () use ($app) {

    $app->get('/', function () use ($app) {
        return $app->welcome();
    });
});
