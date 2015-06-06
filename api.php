<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/5/15
 * Time: 12:46 PM
 */

/**
 * APIDOC stuff here
 */

// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include the API class
include_once dirname(__FILE__) . '/lib/api/API.php';
include_once dirname(__FILE__) . '/lib/ud2sql/helpers/MySQLHelper.php';
include_once dirname(__FILE__) . '/lib/ud2sql/app/Config.php';
// Init an API object
$api = new API();
// check to make sure that the app is authorized
if (isset($_POST['X-Authorization']) && $apiKey = $api->checkAPIKey($_POST['X-Authorization'])) {
    // Determine if the application has write access
    $canWrite = ($apiKey['write'] === 1) ? true : false;
    // Unset the api key variable
    unset($apiKey);
    // Define API action sets
    if (isset($_POST['action'])) { // If we have the action key in our post array

        $MySQLiHelper = new MySQLHelper();
        $mysqli = $MySQLiHelper->getMySQLi(Config::getSQLConf());

        if ($_POST['action'] === 'write' && $canWrite) { // If we want to write and can write

        } elseif ($_POST['action'] === 'read') { // If we want to read
            switch ($_POST['subject']) {
                case 'user' :
                    switch ($_POST['filter']) {
                        case 'id' :
                            if (isset($_POST['filter_value'])) {
                                $result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'id', $_POST['filter_value'])->fetch_assoc();
                                if ($result) {
                                    echo json_encode(array('success' => true, 'result' => $result));
                                } else {
                                    header('HTTP/1.1 404 Not Found');
                                    echo json_encode(array('success' => false, 'message' => 'Subject not found.'));
                                }
                            } else {
                                header('HTTP/1.1 404 Not Found');
                                echo json_encode(array('success' => false, 'message' => 'Filter Value not supplied.'));
                            }
                            break;
                        case 'id_num' :
                            if (isset($_POST['filter_value'])) {
                                $result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'id_num', $_POST['filter_value'])->fetch_assoc();
                                if ($result) {
                                    echo json_encode(array('success' => true, 'result' => $result));
                                } else {
                                    header('HTTP/1.1 404 Not Found');
                                    echo json_encode(array('success' => false, 'message' => 'Subject not found.'));
                                }
                            } else {
                                header('HTTP/1.1 404 Not Found');
                                echo json_encode(array('success' => false, 'message' => 'Filter Value not supplied.'));
                            }
                            break;
                        case 'username' :
                            if (isset($_POST['filter_value'])) {
                                $result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'username', $_POST['filter_value'])->fetch_assoc();
                                if ($result) {
                                    echo json_encode(array('success' => true, 'result' => $result));
                                } else {
                                    header('HTTP/1.1 404 Not Found');
                                    echo json_encode(array('success' => false, 'message' => 'Subject not found.'));
                                }
                            } else {
                                header('HTTP/1.1 404 Not Found');
                                echo json_encode(array('success' => false, 'message' => 'Filter Value not supplied.'));
                            }
                            break;
                        default: // The filter is invalid or none was supplied
                            header('HTTP/1.1 404 Not Found');
                            echo json_encode(array('success' => false, 'message' => 'Subject not defined.'));
                    }
                    break;
                case 'building' :
                    switch ($_POST['filter']) {
                        case 'id' :
                            if (isset($_POST['filter_value'])) {
                                $result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_building_table'], 'id', $_POST['filter_value'])->fetch_assoc();
                                if ($result) {
                                    echo json_encode(array('success' => true, 'result' => $result));
                                } else {
                                    header('HTTP/1.1 404 Not Found');
                                    echo json_encode(array('success' => false, 'message' => 'Subject not found.'));
                                }
                            } else {
                                header('HTTP/1.1 404 Not Found');
                                echo json_encode(array('success' => false, 'message' => 'Filter Value not supplied.'));
                            }
                            break;
                        case 'datatel_code' :
                            if (isset($_POST['filter_value'])) {
                                $result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_building_table'], 'datatel_name', $_POST['filter_value'])->fetch_assoc();
                                if ($result) {
                                    echo json_encode(array('success' => true, 'result' => $result));
                                } else {
                                    header('HTTP/1.1 404 Not Found');
                                    echo json_encode(array('success' => false, 'message' => 'Subject not found.'));
                                }
                            } else {
                                header('HTTP/1.1 404 Not Found');
                                echo json_encode(array('success' => false, 'message' => 'Filter Value not supplied.'));
                            }
                            break;
                        default: // The filter is invalid or none was supplied
                            header('HTTP/1.1 404 Not Found');
                            echo json_encode(array('success' => false, 'message' => 'Subject not defined.'));
                    }
                    break;
                case 'role' :
                    switch ($_POST['filter']) {
                        case 'id' :
                            if (isset($_POST['filter_value'])) {
                                $result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_role_table'], 'id', $_POST['filter_value'])->fetch_assoc();
                                if ($result) {
                                    echo json_encode(array('success' => true, 'result' => $result));
                                } else {
                                    header('HTTP/1.1 404 Not Found');
                                    echo json_encode(array('success' => false, 'message' => 'Subject not found.'));
                                }
                            } else {
                                header('HTTP/1.1 404 Not Found');
                                echo json_encode(array('success' => false, 'message' => 'Filter Value not supplied.'));
                            }
                            break;
                        case 'datatel_code' :
                            if (isset($_POST['filter_value'])) {
                                $result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_role_table'], 'datatel_name', $_POST['filter_value'])->fetch_assoc();
                                if ($result) {
                                    echo json_encode(array('success' => true, 'result' => $result));
                                } else {
                                    header('HTTP/1.1 404 Not Found');
                                    echo json_encode(array('success' => false, 'message' => 'Subject not found.'));
                                }
                            } else {
                                header('HTTP/1.1 404 Not Found');
                                echo json_encode(array('success' => false, 'message' => 'Filter Value not supplied.'));
                            }
                            break;
                        default: // The filter is invalid or none was supplied
                            header('HTTP/1.1 404 Not Found');
                            echo json_encode(array('success' => false, 'message' => 'Subject not defined.'));
                    }
                    break;
                case 'campus' :
                    switch ($_POST['filter']) {
                        case 'id' :
                            if (isset($_POST['filter_value'])) {
                                $result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_campus_table'], 'id', $_POST['filter_value'])->fetch_assoc();
                                if ($result) {
                                    echo json_encode(array('success' => true, 'result' => $result));
                                } else {
                                    header('HTTP/1.1 404 Not Found');
                                    echo json_encode(array('success' => false, 'message' => 'Subject not found.'));
                                }
                            } else {
                                header('HTTP/1.1 404 Not Found');
                                echo json_encode(array('success' => false, 'message' => 'Filter Value not supplied.'));
                            }
                            break;
                        case 'datatel_code' :
                            if (isset($_POST['filter_value'])) {
                                $result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_campus_table'], 'datatel_name', $_POST['filter_value'])->fetch_assoc();
                                if ($result) {
                                    echo json_encode(array('success' => true, 'result' => $result));
                                } else {
                                    header('HTTP/1.1 404 Not Found');
                                    echo json_encode(array('success' => false, 'message' => 'Subject not found.'));
                                }
                            } else {
                                header('HTTP/1.1 404 Not Found');
                                echo json_encode(array('success' => false, 'message' => 'Filter Value not supplied.'));
                            }
                            break;
                        default: // The filter is invalid or none was supplied
                            header('HTTP/1.1 404 Not Found');
                            echo json_encode(array('success' => false, 'message' => 'Subject not defined.'));
                    }
                    break;
                default: // The subject is invalid or none was supplied
                    header('HTTP/1.1 404 Not Found');
                    echo json_encode(array('success' => false, 'message' => 'Subject not defined.'));
            }
        } elseif ($_POST['action'] === 'write' && !$canWrite) { // If we want to write and can NOT write
            header('HTTP/1.1 401 Forbidden');
            echo json_encode(array('success' => false, 'message' => 'Insufficient privileges.'));
        } elseif ($_POST['action'] !== ('read' || 'write')) { // Invalid action was supplied
            header('HTTP/1.1 404 Not Found');
            echo json_encode(array('success' => false, 'message' => 'Action not defined.'));
        }
    } else { // There is no action key value pair
        header('HTTP/1.1 404 Not Found');
        echo json_encode(array('success' => false, 'message' => 'Action not supplied.'));
    }
    // Close the script
    exit();
} else {
    // Throw a 401 unauthorized, since the app is not authorized
    $api->unauthorized();
}
