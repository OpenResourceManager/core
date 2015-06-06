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

    $MySQLiHelper = new MySQLHelper();
    $mysqli = $MySQLiHelper->getMySQLi(Config::getSQLConf());

    $slim->group('/user', function () use ($slim, $api, $apiKey, $mysqli, $MySQLiHelper) {

        $slim->get('/id/:id', function ($id) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'id', $id)->fetch_assoc()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });

        $slim->get('/idnum/:idnum', function ($idnum) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'id_num', $idnum)->fetch_assoc()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });

        $slim->get('/username/:username', function ($username) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'username', $username)->fetch_assoc()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });

        $slim->get('/:limit', function ($limit) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->selectAllFrom($mysqli, Config::getSQLConf()['db_user_table'], $limit)->fetch_all()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });

        $slim->get('/', function () use ($api, $apiKey) {
            echo json_encode(array(
                'application' => $apiKey['app'],
                'success' => true,
                'result' => array(
                    'get' => array(
                        '/id/:id',
                        '/id_num/:id_num',
                        '/username/:username',
                        '/:limit'
                    ),
                    'post' => array()
                ),
            ));
        });
    });

    $slim->group(('/role'), function () use ($slim, $api, $apiKey, $mysqli, $MySQLiHelper) {

        $slim->get('/id/:id', function ($id) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_role_table'], 'id', $id)->fetch_assoc()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });

        $slim->get('/code/:code', function ($code) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_role_table'], 'datatel_name', $code)->fetch_assoc()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });

        $slim->get('/:limit', function ($limit) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->selectAllFrom($mysqli, Config::getSQLConf()['db_role_table'], $limit)->fetch_all()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });
        $slim->get('/', function () use ($api, $apiKey) {
            echo json_encode(array(
                'application' => $apiKey['app'],
                'success' => true,
                'result' => array(
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

    $slim->group(('/building'), function () use ($slim, $api, $apiKey, $mysqli, $MySQLiHelper) {

        $slim->get('/id/:id', function ($id) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_building_table'], 'id', $id)->fetch_assoc()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });

        $slim->get('/code/:code', function ($code) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_building_table'], 'datatel_name', $code)->fetch_assoc()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });

        $slim->get('/:limit', function ($limit) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->selectAllFrom($mysqli, Config::getSQLConf()['db_building_table'], $limit)->fetch_all()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });
        $slim->get('/', function () use ($api, $apiKey) {
            echo json_encode(array(
                'application' => $apiKey['app'],
                'success' => true,
                'result' => array(
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

    $slim->group(('/campus'), function () use ($slim, $api, $apiKey, $mysqli, $MySQLiHelper) {

        $slim->get('/id/:id', function ($id) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_campus_table'], 'id', $id)->fetch_assoc()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });

        $slim->get('/code/:code', function ($code) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_campus_table'], 'datatel_name', $code)->fetch_assoc()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }
        });

        $slim->get('/:limit', function ($limit) use ($api, $apiKey, $mysqli, $MySQLiHelper) {
            if ($result = $MySQLiHelper->selectAllFrom($mysqli, Config::getSQLConf()['db_campus_table'], $limit)->fetch_all()) {
                echo json_encode(array(
                    'application' => $apiKey['app'],
                    'success' => true,
                    'result' => $result,
                ));
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('success' => false, 'message' => 'Not Found'));
            }

        });
        $slim->get('/', function () use ($api, $apiKey) {
            echo json_encode(array(
                'application' => $apiKey['app'],
                'success' => true,
                'result' => array(
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
    $mysqli->close();
} else {
    // Throw a 401 unauthorized, since the app is not authorized
    $api->unauthorized();
}