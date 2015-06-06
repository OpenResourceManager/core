<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/5/15
 * Time: 12:46 PM
 */

// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include the API class
include_once dirname(__FILE__) . '/lib/api/API.php';
// Init an API object
$api = new API();
// check to make sure that the app is authorized
if (isset($_POST['X-Authorization']) && $apiKey = $api->checkAPIKey($_POST['X-Authorization'])) {
    // Determine if the application has write access
    $canWrite = ($apiKey['write'] === 1) ? true : false;
    // Unset the api key variable
    unset($apiKey);
    // Define API action sets
    if ($_POST['action'] === 'write' && $canWrite) { // If we want to write and can write

    } elseif ($_POST['action'] === 'write' && !$canWrite) { // If we want to write and can NOT write

    } elseif ($_POST['action'] === 'read') { // If we want to read

    } else { // Either action was not supplied or an invalid one was
        Die(json_encode(array('success' => false, 'message' => 'Action not defined.')));
    }
} else {
    // Throw a 401 unauthorized, since the app is not authorized
    $api->unauthorized();
}
