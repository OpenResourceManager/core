<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/6/15
 * Time: 10:40 AM
 */
require dirname(dirname(__FILE__)) . '/vendor/autoload.php';
include_once dirname(__FILE__) . '/lib/api/API.php';
include_once dirname(__FILE__) . '/lib/ud2sql/helpers/MySQLHelper.php';
include_once dirname(__FILE__) . '/lib/ud2sql/app/Config.php';

/**
 * @apiVersion 1.0.0
 */

// Init a slim object
$slim = new \Slim\Slim();
// Init an API object
$api = new API();
// Check the API authorization
if ($slim->request->headers->get('X-Authorization') && $apiKey = $api->checkAPIKey($slim->request->headers->get('X-Authorization'))) {

    $slim->group('/user', function () use ($slim, $api, $apiKey) {

        $slim->get('/id/:id', function ($id) use ($api, $apiKey) {

        });

        $slim->get('/id_num/:id_num', function ($id_num) use ($api, $apiKey) {

        });

        $slim->get('/username/:username', function ($username) use ($api, $apiKey) {

        });

        $slim->get('/:limit', function ($limit) use ($api, $apiKey) {

        });

        $slim->get('/', function () use ($api, $apiKey) {
            echo json_encode(array(
                'application' => $apiKey['app'],
                'success' => true,
                'result' => array(),
                'methods' => array(
                    'get' => array(
                        '/id/:id',
                        '/id_num/:id_num',
                        '/username/:username',
                        '/:limit'
                    ),
                    'post' => array()
                )
            ));
        });
    });

    $slim->group(('/role'), function () use ($slim, $api, $apiKey) {

        $slim->get('/id/:id', function ($id) use ($api) {

        });

        $slim->get('/datatel_code/:datatel_code', function ($datatel_code) use ($api) {

        });

        $slim->get('/:limit', function ($limit) use ($api) {

        });
        $slim->get('/', function () use ($api, $apiKey) {
            return json_encode(array(
                'application' => $apiKey['app'],
                'success' => true,
                'result' => array(),
                'methods' => array(
                    'get' => array(
                        '/id/:id',
                        '/datatel_code/:datatel_code',
                        '/:limit'
                    ),
                    'post' => array()
                )
            ));
        });
    });

    $slim->group(('/building'), function () use ($slim, $api, $apiKey) {

        $slim->get('/id/:id', function ($id) use ($api) {

        });

        $slim->get('/datatel_code/:datatel_code', function ($datatel_code) use ($api) {

        });

        $slim->get('/:limit', function ($limit) use ($api) {

        });
        $slim->get('/', function () use ($api, $apiKey) {
            return json_encode(array(
                'application' => $apiKey['app'],
                'success' => true,
                'result' => array(),
                'methods' => array(
                    'get' => array(
                        '/id/:id',
                        '/datatel_code/:datatel_code',
                        '/:limit'
                    ),
                    'post' => array()
                )
            ));
        });
    });

    $slim->group(('/campus'), function () use ($slim, $api, $apiKey) {

        $slim->get('/id/:id', function ($id) use ($api) {

        });

        $slim->get('/datatel_code/:datatel_code', function ($datatel_code) use ($api) {

        });

        $slim->get('/:limit', function ($limit) use ($api) {

        });
        $slim->get('/', function () use ($api, $apiKey) {
            return json_encode(array(
                'application' => $apiKey['app'],
                'success' => true,
                'result' => array(),
                'methods' => array(
                    'get' => array(
                        '/id/:id',
                        '/datatel_code/:datatel_code',
                        '/:limit'
                    ),
                    'post' => array()
                )
            ));
        });
    });
    $slim->run();
} else {
    // Throw a 401 unauthorized, since the app is not authorized
    $api->unauthorized();
}