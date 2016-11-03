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

            /**
             * Countries
             */
            $api->group(['prefix' => 'countries'], function ($api) {
                $api->group(['middleware' => 'permission:read-country'], function ($api) {
                    $api->get('/', ['uses' => 'CountryController@index', 'as' => 'api.countries.index']);

                });
                $api->group(['middleware' => 'permission:write-country'], function ($api) {

                });
            });

            /**
             * States
             */
            $api->group(['prefix' => 'states'], function ($api) {
                $api->group(['middleware' => 'permission:read-state'], function ($api) {
                    $api->get('/', ['uses' => 'StateController@index', 'as' => 'api.states.index']);

                });
                $api->group(['middleware' => 'permission:write-state'], function ($api) {

                });
            });

            /**
             * Mobile Carriers
             */
            $api->group(['prefix' => 'mobile-carriers'], function ($api) {
                $api->group(['middleware' => 'permission:read-mobile-carrier'], function ($api) {
                    $api->get('/', ['uses' => 'MobileCarrierController@index', 'as' => 'api.mobile-carriers.index']);

                });
                $api->group(['middleware' => 'permission:write-mobile-carrier'], function ($api) {

                });
            });

            /**
             * Duties
             */
            $api->group(['prefix' => 'duties'], function ($api) {
                $api->group(['middleware' => 'permission:read-duty'], function ($api) {
                    $api->get('/', ['uses' => 'DutyController@index', 'as' => 'api.duties.index']);
                    $api->get('/{id}', ['uses' => 'DutyController@show', 'as' => 'api.duties.show']);
                    $api->get('/code/{code}', ['uses' => 'DutyController@showFromCode', 'as' => 'api.duties.show_from_code']);
                });

                $api->group(['middleware' => 'permission:write-duty'], function ($api) {
                    $api->post('/', ['uses' => 'DutyController@store', 'as' => 'api.duties.store']);
                    $api->delete('/', ['uses' => 'DutyController@destroy', 'as' => 'api.duties.destroy']);
                });
            });

            /**
             * Accounts
             */
            $api->group(['prefix' => 'accounts'], function ($api) {
                $api->group(['middleware' => 'permission:read-account'], function ($api) {
                    $api->get('/', ['uses' => 'AccountController@index', 'as' => 'api.accounts.index']);
                    $api->get('/{id}', ['uses' => 'AccountController@show', 'as' => 'api.accounts.show']);
                    $api->get('/username/{username}', ['uses' => 'AccountController@showFromUsername', 'as' => 'api.accounts.show_from_username']);
                    $api->get('/identifier/{identifier}', ['uses' => 'AccountController@showFromIdentifier', 'as' => 'api.accounts.show_from_identifier']);
                });

                $api->group(['middleware' => 'permission:write-account'], function ($api) {
                    $api->post('/', ['uses' => 'AccountController@store', 'as' => 'api.accounts.store']);
                    $api->post('/duty', ['uses' => 'AccountController@assignDuty', 'as' => 'api.account.assign.duty']);
                    $api->delete('/', ['uses' => 'AccountController@destroy', 'as' => 'api.accounts.destroy']);
                    $api->delete('/duty', ['uses' => 'AccountController@detachDuty', 'as' => 'api.account.detach.duty']);
                });
            });

            /**
             * Emails
             */
            $api->group(['prefix' => 'emails'], function ($api) {
                $api->group(['middleware' => 'permission:read-account'], function ($api) {
                    $api->get('/', ['uses' => 'EmailController@index', 'as' => 'api.emails.index']);

                });
                $api->group(['middleware' => 'permission:write-account'], function ($api) {

                });
            });

            /**
             * Mobile Phones
             */
            $api->group(['prefix' => 'mobile-phones'], function ($api) {
                $api->group(['middleware' => 'permission:read-account'], function ($api) {
                    $api->get('/', ['uses' => 'MobilePhoneController@index', 'as' => 'api.mobile-phones.index']);

                });
                $api->group(['middleware' => 'permission:write-account'], function ($api) {

                });
            });

            /**
             * Addresses
             */
            $api->group(['prefix' => 'addresses'], function ($api) {
                $api->group(['middleware' => 'permission:read-account'], function ($api) {

                });
                $api->group(['middleware' => 'permission:write-account'], function ($api) {

                });
            });

            /**
             * Campuses
             */
            $api->group(['prefix' => 'campuses'], function ($api) {
                $api->group(['middleware' => 'permission:read-campuses'], function ($api) {
                    $api->get('/', ['uses' => 'CampusController@index', 'as' => 'api.campuses.index']);

                });
                $api->group(['middleware' => 'permission:write-campuses'], function ($api) {

                });
            });

            /**
             * Buildings
             */
            $api->group(['prefix' => 'buildings'], function ($api) {
                $api->group(['middleware' => 'permission:read-building'], function ($api) {
                    $api->get('/', ['uses' => 'BuildingController@index', 'as' => 'api.buildings.index']);

                });
                $api->group(['middleware' => 'permission:write-building'], function ($api) {

                });
            });

            /**
             * Rooms
             */
            $api->group(['prefix' => 'rooms'], function ($api) {
                $api->group(['middleware' => 'permission:read-room'], function ($api) {
                    $api->get('/', ['uses' => 'RoomController@index', 'as' => 'api.rooms.index']);

                });
                $api->group(['middleware' => 'permission:write-room'], function ($api) {

                });
            });

            /**
             * Departments
             */
            $api->group(['prefix' => 'departments'], function ($api) {
                $api->group(['middleware' => 'permission:read-department'], function ($api) {
                    $api->get('/', ['uses' => 'DepartmentController@index', 'as' => 'api.departments.index']);

                });
                $api->group(['middleware' => 'permission:write-department'], function ($api) {

                });
            });

            /**
             * Courses
             */
            $api->group(['prefix' => 'courses'], function ($api) {
                $api->group(['middleware' => 'permission:read-courses'], function ($api) {
                    $api->get('/', ['uses' => 'CourseController@index', 'as' => 'api.courses.index']);

                });
                $api->group(['middleware' => 'permission:write-courses'], function ($api) {

                });
            });

        });
    });
});