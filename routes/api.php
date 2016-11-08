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
                    $api->post('/', ['uses' => 'CountryController@store', 'as' => 'api.countries.store']);
                    $api->delete('/', ['uses' => 'CountryController@destroy', 'as' => 'api.countries.destroy']);
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
                    $api->post('/', ['uses' => 'StateController@store', 'as' => 'api.states.store']);
                    $api->delete('/', ['uses' => 'StateController@destroy', 'as' => 'api.states.destroy']);
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
                    $api->post('/', ['uses' => 'MobileCarrierController@store', 'as' => 'api.mobile-carriers.store']);
                    $api->delete('/', ['uses' => 'MobileCarrierController@destroy', 'as' => 'api.mobile-carriers.destroy']);
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
                    $api->get('/account/id/{id}', ['uses' => 'EmailController@showFromAccountId', 'as' => 'api.emails.show_from_account_id']);
                    $api->get('/account/identifier/{identifier}', ['uses' => 'EmailController@showFromAccountIdentifier', 'as' => 'api.emails.show_from_account_identifier']);
                    $api->get('/account/username/{username}', ['uses' => 'EmailController@showFromAccountUsername', 'as' => 'api.emails.show_from_account_username']);
                });
                $api->group(['middleware' => 'permission:write-email'], function ($api) {
                    $api->post('/', ['uses' => 'EmailController@store', 'as' => 'api.emails.store']);
                    $api->delete('/', ['uses' => 'EmailController@destroy', 'as' => 'api.emails.destroy']);
                });
            });

            /**
             * Mobile Phones
             */
            $api->group(['prefix' => 'mobile-phones'], function ($api) {
                $api->group(['middleware' => 'permission:read-mobile-phone'], function ($api) {
                    $api->get('/', ['uses' => 'MobilePhoneController@index', 'as' => 'api.mobile-phones.index']);
                    $api->get('/{id}', ['uses' => 'MobilePhoneController@show', 'as' => 'api.mobile-phones.show']);
                    $api->get('/account/id/{id}', ['uses' => 'MobilePhoneController@showFromAccountId', 'as' => 'api.mobile-phones.show_from_account_id']);
                    $api->get('/account/identifier/{identifier}', ['uses' => 'MobilePhoneController@showFromAccountIdentifier', 'as' => 'api.mobile-phones.show_from_account_identifier']);
                    $api->get('/account/username/{username}', ['uses' => 'MobilePhoneController@showFromAccountUsername', 'as' => 'api.mobile-phones.show_from_account_username']);
                    $api->get('/mobile-carrier/id/{id}', ['uses' => 'MobilePhoneController@showFromMobileCarrierId', 'as' => 'api.mobile-phones.show_from_mobile-carrier_id']);
                    $api->get('/mobile-carrier/code/{code}', ['uses' => 'MobilePhoneController@showFromMobileCarrierCode', 'as' => 'api.mobile-phones.show_from_mobile-carrier_code']);
                });
                $api->group(['middleware' => 'permission:write-mobile-phone'], function ($api) {
                    $api->post('/', ['uses' => 'MobilePhoneController@store', 'as' => 'api.mobile-phones.store']);
                    $api->delete('/', ['uses' => 'MobilePhoneController@destroy', 'as' => 'api.mobile-phones.destroy']);
                });
            });

            /**
             * Addresses
             */
            $api->group(['prefix' => 'addresses'], function ($api) {
                $api->group(['middleware' => 'permission:read-address'], function ($api) {
                    $api->get('/', ['uses' => 'AddressController@index', 'as' => 'api.addresses.index']);
                    $api->get('/{id}', ['uses' => 'AddressController@show', 'as' => 'api.addresses.show']);

                });
                $api->group(['middleware' => 'permission:write-address'], function ($api) {
                    $api->post('/', ['uses' => 'AddressController@store', 'as' => 'api.addresses.store']);
                    $api->delete('/', ['uses' => 'AddressController@destroy', 'as' => 'api.addresses.destroy']);
                });
            });

            /**
             * Campuses
             */
            $api->group(['prefix' => 'campuses'], function ($api) {
                $api->group(['middleware' => 'permission:read-campus'], function ($api) {
                    $api->get('/', ['uses' => 'CampusController@index', 'as' => 'api.campuses.index']);
                    $api->get('/{id}', ['uses' => 'CampusController@show', 'as' => 'api.campuses.show']);
                    $api->get('/code/{code}', ['uses' => 'CampusController@showFromCode', 'as' => 'api.campuses.show_from_code']);

                });
                $api->group(['middleware' => 'permission:write-campus'], function ($api) {
                    $api->post('/', ['uses' => 'CampusController@store', 'as' => 'api.campuses.store']);
                    $api->delete('/', ['uses' => 'CampusController@destroy', 'as' => 'api.campuses.destroy']);
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
                    $api->post('/', ['uses' => 'BuildingController@store', 'as' => 'api.buildings.store']);
                    $api->delete('/', ['uses' => 'BuildingController@destroy', 'as' => 'api.buildings.destroy']);
                });
            });

            /**
             * Rooms
             */
            $api->group(['prefix' => 'rooms'], function ($api) {
                $api->group(['middleware' => 'permission:read-room'], function ($api) {
                    $api->get('/', ['uses' => 'RoomController@index', 'as' => 'api.rooms.index']);
                    $api->get('/{id}', ['uses' => 'RoomController@show', 'as' => 'api.rooms.show']);
                    $api->get('/code/{code}', ['uses' => 'RoomController@showFromCode', 'as' => 'api.rooms.show_from_code']);

                });
                $api->group(['middleware' => 'permission:write-room'], function ($api) {
                    $api->post('/', ['uses' => 'RoomController@store', 'as' => 'api.rooms.store']);
                    $api->delete('/', ['uses' => 'RoomController@destroy', 'as' => 'api.rooms.destroy']);
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
                    $api->post('/', ['uses' => 'DepartmentController@store', 'as' => 'api.departments.store']);
                    $api->delete('/', ['uses' => 'DepartmentController@destroy', 'as' => 'api.departments.destroy']);
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
                    $api->post('/', ['uses' => 'CourseController@store', 'as' => 'api.courses.store']);
                    $api->delete('/', ['uses' => 'CourseController@destroy', 'as' => 'api.courses.destroy']);
                });
            });

        });
    });
});