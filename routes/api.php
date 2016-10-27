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

        $api->get('/', [
            'uses' => 'ApiController@index',
            'as' => 'api.index'
        ]);

        $api->group(['prefix' => 'auth'], function ($api) {

            $api->post('login', [
                'uses' => 'ApiAuthenticationController@authenticate',
                'as' => 'api.login'
            ]);

            $api->get('validate', [
                'middleware' => 'api.auth',
                'uses' => 'ApiAuthenticationController@validateToken',
                'as' => 'api.validate_token'
            ]);

        });

        /**
         * Protected routes go in this middleware group
         */
        $api->group(['middleware' => 'api.auth'], function ($api) {

            $api->group(['prefix' => 'accounts'], function ($api) {
                $api->get('/', [
                    'uses' => 'AccountController@index',
                    'as' => 'api.accounts.index'
                ]);

                $api->get('/{id}', [
                    'uses' => 'AccountController@show',
                    'as' => 'api.accounts.show'
                ]);
            });

            $api->group(['prefix' => 'duties'], function ($api) {
                $api->get('/', [
                    'uses' => 'DutyController@index',
                    'as' => 'api.duties.index'
                ]);

                $api->get('/{id}', [
                    'uses' => 'DutyController@show',
                    'as' => 'api.duties.show'
                ]);
            });

        });
    });
});