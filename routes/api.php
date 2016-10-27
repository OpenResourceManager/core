<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    /**
     * The route group below is used to jam the version number into the URL.
     * This is not the Dingo way of doing things.
     * Eventually we will need to migrate to an accept header
     *
     * https://stackoverflow.com/questions/38664222/dingo-api-how-to-add-version-number-in-url/
     * https://github.com/dingo/api/issues/1221
     */
    $api->group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API\V1'], function ($api) {

        $api->get('/', ['uses' => 'ApiController@index', 'as' => 'api.index']);

        $api->group(['prefix' => 'auth'], function ($api) {
            $api->post('login', ['uses' => 'ApiAuthenticationController@login', 'as' => 'api.login']);
            $api->get('validate', ['uses' => 'ApiAuthenticationController@validateAuth', 'as' => 'api.validate_auth', 'middleware' => 'api.auth']);
        });

        /**
         * Protected routes go in this middleware group
         */
        $api->group(['middleware' => 'api.auth'], function ($api) {

            $api->group(['prefix' => 'accounts'], function ($api) {
                $api->group(['middleware' => 'permission:read-account'], function ($api) {
                    $api->get('/', ['uses' => 'AccountController@index', 'as' => 'api.accounts.index']);
                    $api->get('/{id}', ['uses' => 'AccountController@show', 'as' => 'api.accounts.show']);
                    $api->get('/username/{username}', ['uses' => 'AccountController@showFromUsername', 'as' => 'api.accounts.show_from_username']);
                    $api->get('/identifier/{identifier}', ['uses' => 'AccountController@showFromIdentifier', 'as' => 'api.accounts.show_from_identifier']);
                });

                $api->group(['middleware' => 'permission:write-account'], function ($api) {
                    $api->post('/', ['uses' => 'AccountController@store', 'as' => 'api.accounts.store']);
                    $api->delete('/{id}', ['uses' => 'AccountController@destroy', 'as' => 'api.accounts.destroy']);
                    $api->delete('/username/{username}', ['uses' => 'AccountController@destroyFromUsername', 'as' => 'api.accounts.destroy_from_username']);
                    $api->delete('/identifier/{identifier}', ['uses' => 'AccountController@destroyFromIdentifier', 'as' => 'api.accounts.destroy_from_identifier']);
                });
            });

            $api->group(['prefix' => 'duties'], function ($api) {
                $api->group(['middleware' => 'permission:read-duty'], function ($api) {
                    $api->get('/', ['uses' => 'DutyController@index', 'as' => 'api.duties.index']);
                    $api->get('/{id}', ['uses' => 'DutyController@show', 'as' => 'api.duties.show']);
                    $api->get('/code/{code}', ['uses' => 'DutyController@showFromCode', 'as' => 'api.duties.show_from_code']);
                });

                $api->group(['middleware' => 'permission:write-duty'], function ($api) {
                    $api->post('/', ['uses' => 'DutyController@store', 'as' => 'api.duties.store']);
                    $api->delete('/{id}', ['uses' => 'DutyController@destroy', 'as' => 'api.duties.destroy']);
                    $api->delete('/code/{code}', ['uses' => 'DutyController@destroyFromCode', 'as' => 'api.duties.destroy_from_code']);
                });
            });

        });
    });
});