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
                    $api->get('/{id}', ['uses' => 'CountryController@show', 'as' => 'api.countries.show']);
                    $api->get('/code/{code}', ['uses' => 'CountryController@showFromCode', 'as' => 'api.countries.show_from_code']);

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
                    $api->get('/{id}', ['uses' => 'StateController@show', 'as' => 'api.states.show']);
                    $api->get('/code/{code}', ['uses' => 'StateController@showFromCode', 'as' => 'api.states.show_from_code']);

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
                    $api->get('/{id}', ['uses' => 'MobileCarrierController@show', 'as' => 'api.mobile-carriers.show']);
                    $api->get('/code/{code}', ['uses' => 'MobileCarrierController@showFromCode', 'as' => 'api.mobile-carriers.show_from_code']);

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
                $api->group(['middleware' => 'permission:read-email'], function ($api) {
                    $api->get('/', ['uses' => 'EmailController@index', 'as' => 'api.emails.index']);
                    $api->get('/{id}', ['uses' => 'EmailController@show', 'as' => 'api.emails.show']);
                    $api->get('/address/{address}', ['uses' => 'EmailController@showFromAddress', 'as' => 'api.emails.show_from_address']);

                });
                $api->group(['middleware' => 'permission:write-email'], function ($api) {

                });
            });

            /**
             * Mobile Phones
             */
            $api->group(['prefix' => 'mobile-phones'], function ($api) {
                $api->group(['middleware' => 'permission:read-mobile-phone'], function ($api) {
                    $api->get('/', ['uses' => 'MobilePhoneController@index', 'as' => 'api.mobile-phones.index']);
                    $api->get('/{id}', ['uses' => 'MobilePhoneController@show', 'as' => 'api.mobile-phones.show']);
                    $api->get('/code/{code}', ['uses' => 'MobilePhoneController@showFromCode', 'as' => 'api.mobile-phones.show_from_code']);

                });
                $api->group(['middleware' => 'permission:write-mobile-phone'], function ($api) {

                });
            });

            /**
             * Addresses
             */
            $api->group(['prefix' => 'addresses'], function ($api) {
                $api->group(['middleware' => 'permission:read-addresses'], function ($api) {
                    $api->get('/', ['uses' => 'AddressController@index', 'as' => 'api.addresses.index']);
                    $api->get('/{id}', ['uses' => 'AddressController@show', 'as' => 'api.addresses.show']);

                });
                $api->group(['middleware' => 'permission:write-addresses'], function ($api) {

                });
            });

            /**
             * Campuses
             */
            $api->group(['prefix' => 'campuses'], function ($api) {
                $api->group(['middleware' => 'permission:read-campuses'], function ($api) {
                    $api->get('/', ['uses' => 'CampusController@index', 'as' => 'api.campuses.index']);
                    $api->get('/{id}', ['uses' => 'CampusController@show', 'as' => 'api.campuses.show']);
                    $api->get('/code/{code}', ['uses' => 'CampusController@showFromCode', 'as' => 'api.campuses.show_from_code']);

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
                    $api->get('/{id}', ['uses' => 'BuildingController@show', 'as' => 'api.buildings.show']);
                    $api->get('/code/{code}', ['uses' => 'BuildingController@showFromCode', 'as' => 'api.buildings.show_from_code']);

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
                    $api->get('/{id}', ['uses' => 'RoomController@show', 'as' => 'api.room.show']);
                    $api->get('/code/{code}', ['uses' => 'RoomController@showFromCode', 'as' => 'api.room.show_from_code']);

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
                    $api->get('/{id}', ['uses' => 'DepartmentController@show', 'as' => 'api.departments.show']);
                    $api->get('/code/{code}', ['uses' => 'DepartmentController@showFromCode', 'as' => 'api.departments.show_from_code']);

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
                    $api->get('/{id}', ['uses' => 'CourseController@show', 'as' => 'api.courses.show']);
                    $api->get('/code/{code}', ['uses' => 'CourseController@showFromCode', 'as' => 'api.courses.show_from_code']);

                });
                $api->group(['middleware' => 'permission:write-courses'], function ($api) {

                });
            });

        });
    });
});