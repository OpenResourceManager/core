<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/8/15
 * Time: 8:09 PM
 */

require dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/Config.php';


class User
{

    /**
     * @api {post} /user/sageid/:sageid Post to User
     * @apiVersion 1.0.0
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Users
     * @apiParam {Int} sageid Users's unique Sage ID number.
     * @apiDescription Using a Sage ID number as part of the url parameter, an application can create new user records or update existing records.
     * If the Sage ID in the URL does not exist in the database, the rest of the data sent in the POST request will be treated as a new user entry.
     * If the Sage ID in the URL does exist in the database, the data sent in the POST request will replace the data in that users record.
     * @apiSuccess {String} application The name of the application that is accessing the API.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      --data "email2=lukeskywalker@gmail.com&username=skywal" \
     *      --url https://databridge.sage.edu/v1/user/sageid/:sageid
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/user/sageid/:sageid",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
     *      parameters:{ :email2 => "lukeskywalker@gmail.com", :username => "skywal" }.to_json
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user/sageid/:sageid");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      curl_setopt($ch, CURLOPT_POST, true);
     *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("email2" => "lukeskywalker@gmail.com", "username" => "skywal");
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $uri = https://databridge.sage.edu/v1/user/sageid/:sageid
     *      $body = @{ email2 = "lukeskywalker@gmail.com", username = "skywal" }
     *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/user/sageid/:sageid")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .body("{\"email2\":\"lukeskywalker@gmail.com\", \"username\":\"skywal\"}")
     *      .asString();
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.post("https://databridge.sage.edu/v1/user/sageid/:sageid",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          },
     *          params={
     *              "email2": "lukeskywalker@gmail.com",
     *              "username": "skywal"
     *          }
     *      )
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/user/sageid/:sageid")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .field("email2", "lukeskywalker@gmail.com")
     *       .field("username", "skywal")
     *       .asString();
     * @apiSuccessExample Success Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "application": "Awesome Application",
     *          "success": true,
     *          "result": "update"
     *     }
     *
     * @apiError {String} application The name of the application that is accessing the API.
     * @apiError {Boolean} success Tells the application if the request was successful.
     * @apiError {String} ForbiddenToWrite The application does not have write access to the API.
     * @apiErrorExample Error Response:
     *      HTTP/1.1 403 Forbidden
     *      {
     *          "application": "Awesome Application",
     *          "success": false,
     *          "error": "ForbiddenToWrite"
     *      }
     *
     * @apiError {String} application The name of the application that is accessing the API.
     * @apiError {Boolean} success Tells the application if the request was successful.
     * @apiError {String} InsufficientPostData The application did not provide the required data.
     * @apiError {Array} required User attributes and a boolean value that signifies if they are required or not.
     * @apiErrorExample Error Response:
     *      HTTP/1.1 400 Bad Request
     *      {
     *          "application": "Awesome Application",
     *          "success": false,
     *          "error": "InsufficientPostData",
     *          "required": {
     *              "sageid": true,
     *              "username": true,
     *              "name_first": true,
     *              "name_middle": false,
     *              "name_last": true,
     *              "email": true,
     *              "email2": false,
     *              "building": false,
     *              "role": true,
     *              "active": true,
     *              "phone": false,
     *              "room": false
     *          }
     *      }
     *
     * @apiError {String} application The name of the application that is accessing the API.
     * @apiError {Boolean} success Tells the application if the request was successful.
     * @apiError {String} FailedToWrite The application does have write access, but the commit failed. This is due to an error on the server.
     * @apiErrorExample Error Response:
     *      HTTP/1.1 500 Server Error
     *      {
     *          "application": "Awesome Application",
     *          "success": false,
     *          "error": "FailedToWrite"
     *      }
     */

    /**
     * @param API $api
     * @param array $apiKey
     * @param MySQLHelper $MySQLiHelper
     * @param array $data
     * @param string $sageid
     * @return array
     */
    public function postUser(API $api, array $apiKey, MySQLHelper $MySQLiHelper, array $data, $sageid = '')
    {
        if ($apiKey['write'] == 1) {
            if (!empty($data)) {
                $mysqli = $MySQLiHelper->getMySQLi(Config::getSQLConf()['db_user'], Config::getSQLConf()['db_pass'], Config::getSQLConf()['db_name'], Config::getSQLConf()['db_host']);
                $exists = ($MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'sageid', $sageid)->fetch_assoc()) ? true : false;
                if ($exists) {
                    // Unset protected values
                    if (isset($data['sageid'])) unset($data['sageid']);
                    if (isset($data['id'])) unset($data['id']);
                    if ($MySQLiHelper->simpleUpdate($mysqli, Config::getSQLConf()['db_user_table'], $data, 'sageid', $sageid)) {
                        $mysqli->close();
                        return array('application' => $apiKey['app'], 'success' => true, 'result' => 'update');
                    } else {
                        $mysqli->close();
                        header('HTTP/1.1 500 Server Error');
                        return array('application' => $apiKey['app'], 'success' => false, 'error' => 'FailedToWrite');
                    }
                } else {
                    if ($api->checkPostDataValues($data, Config::getUserAttributes())) {
                        if ($MySQLiHelper->simpleInsert($mysqli, Config::getSQLConf()['db_user_table'], $data)) {
                            $mysqli->close();
                            return array('application' => $apiKey['app'], 'success' => true, 'result' => 'create');
                        } else {
                            $mysqli->close();
                            header('HTTP/1.1 500 Server Error');
                            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'FailedToWrite');
                        }
                    } else {
                        $mysqli->close();
                        header('HTTP/1.1 400 Bad Request');
                        return array('application' => $apiKey['app'], 'success' => false, 'error' => 'InsufficientPostData', 'required' => Config::getUserAttributes());
                    }
                }
            } else {
                header('HTTP/1.1 400 Bad Request');
                return array('application' => $apiKey['app'], 'success' => false, 'error' => 'InsufficientPostData', 'required' => Config::getUserAttributes());
            }
        } else {
            header('HTTP/1.1 403 Forbidden');
            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'ForbiddenToWrite');
        }
    }

    /**
     * @api {get} /user/id/:id Get by ID
     * @apiVersion 1.0.0
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Users
     * @apiParam {Int} id Users's unique API ID.
     * @apiDescription This method allows an application to view a user's record using the database index `ID` number.
     * @apiSuccess {String} application The name of the application that is accessing the API.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The user record object.
     * @apiSampleRequest https://databridge.sage.edu/v1/user/id/:id
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/user/id/:id
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/user/id/:id",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user/id/:id");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/user/id/:id -Headers $headers
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/user/id/:id")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/user/id/:id",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/user/id/:id")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     * @apiSuccessExample Success Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "application": "Awesome Application",
     *          "success": true,
     *          "result": {
     *              "id": "1",
     *              "sageid": "999998",
     *              "username": "buildb3",
     *              "name_first": "Bob",
     *              "name_middle": "T.",
     *              "name_last": "Builder",
     *              "email": "buildb3@sage.edu",
     *              "email2": "bob@gmail.com",
     *              "building": "5",
     *              "role": "1",
     *              "active": "1",
     *              "phone": "5182444777",
     *              "room": "302",
     *              "has_photo_id": "1",
     *              "photo_id_url": "http://idmanager.sage.edu/pics/accepted/0999998.jpg",
     *              "photo_id_filename": "999998.jpg"
     *           }
     *     }
     *
     * @apiError {String} application The name of the application that is accessing the API.
     * @apiError {Boolean} success Tells the application if the request was successful.
     * @apiError {String} UserNotFound The id of the user was not found.
     * @apiErrorExample Error Response:
     *      HTTP/1.1 404 Not Found
     *      {
     *          "application": "Awesome Application",
     *          "success": false,
     *          "error": "UserNotFound"
     *      }
     */

    /**
     * @param array $apiKey
     * @param MySQLHelper $MySQLiHelper
     * @param int $id
     * @return array
     */
    public function getByID(array $apiKey, MySQLHelper $MySQLiHelper, $id = 0)
    {
        $mysqli = $MySQLiHelper->getMySQLi(Config::getSQLConf()['db_user'], Config::getSQLConf()['db_pass'], Config::getSQLConf()['db_name'], Config::getSQLConf()['db_host']);
        if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'id', $id)->fetch_assoc()) {
            $mysqli->close();
            return array('application' => $apiKey['app'], 'success' => true, 'result' => $result);
        } else {
            $mysqli->close();
            header('HTTP/1.1 404 Not Found');
            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'UserNotFound');
        }
    }

    /**
     * @api {get} /user/sageid/:sageid Get by Sage ID
     * @apiVersion 1.0.0
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Users
     * @apiParam {Int} sageid Users's unique Sage ID.
     * @apiDescription This method allows an application to view a user's record using the user's Sage ID.
     * @apiSuccess {String} application The name of the application that is accessing the API.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The user record object.
     * @apiSampleRequest https://databridge.sage.edu/v1/user/sageid/:sageid
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/user/sageid/:sageid
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/user/sageid/:sageid",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user/sageid/:sageid");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/user/sageid/:sageid -Headers $headers
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/user/sageid/:sageid")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/user/sageid/:sageid",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/user/sageid/:sageid")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     * @apiSuccessExample Success Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "application": "Awesome Application",
     *          "success": true,
     *          "result": {
     *              "id": "1",
     *              "sageid": "999998",
     *              "username": "buildb3",
     *              "name_first": "Bob",
     *              "name_middle": "T.",
     *              "name_last": "Builder",
     *              "email": "buildb3@sage.edu",
     *              "email2": "bob@gmail.com",
     *              "building": "5",
     *              "role": "1",
     *              "active": "1",
     *              "phone": "5182444777",
     *              "room": "302",
     *              "has_photo_id": "1",
     *              "photo_id_url": "http://idmanager.sage.edu/pics/accepted/0999998.jpg",
     *              "photo_id_filename": "999998.jpg"
     *           }
     *     }
     *
     * @apiError {String} application The name of the application that is accessing the API.
     * @apiError {Boolean} success Tells the application if the request was successful.
     * @apiError {String} UserNotFound The id of the user was not found.
     * @apiErrorExample Error Response:
     *      HTTP/1.1 404 Not Found
     *      {
     *          "application": "Awesome Application",
     *          "success": false,
     *          "error": "UserNotFound"
     *      }
     */

    /**
     * @param array $apiKey
     * @param MySQLHelper $MySQLiHelper
     * @param string $sageid
     * @return array
     */
    public function getBySageID(array $apiKey, MySQLHelper $MySQLiHelper, $sageid = '')
    {
        $mysqli = $MySQLiHelper->getMySQLi(Config::getSQLConf()['db_user'], Config::getSQLConf()['db_pass'], Config::getSQLConf()['db_name'], Config::getSQLConf()['db_host']);
        if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'sageid', $sageid)->fetch_assoc()) {
            $mysqli->close();
            return array('application' => $apiKey['app'], 'success' => true, 'result' => $result);
        } else {
            $mysqli->close();
            header('HTTP/1.1 404 Not Found');
            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'UserNotFound');
        }
    }

    /**
     * @api {get} /user/username/:username Get by Sage Username
     * @apiVersion 1.0.0
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Users
     * @apiParam {String} username Users's unique Sage username.
     * @apiDescription This method allows an application to view a user's record using the user's username.
     * @apiSuccess {String} application The name of the application that is accessing the API.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The user record object.
     * @apiSampleRequest https://databridge.sage.edu/v1/user/username/:username
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/user/username/:username
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/user/username/:username",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user/username/:username");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/user/username/:username -Headers $headers
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/user/username/:username")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/user/username/:username",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/user/username/:username")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     * @apiSuccessExample Success Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "application": "Awesome Application",
     *          "success": true,
     *          "result": {
     *              "id": "1",
     *              "sageid": "999998",
     *              "username": "buildb3",
     *              "name_first": "Bob",
     *              "name_middle": "T.",
     *              "name_last": "Builder",
     *              "email": "buildb3@sage.edu",
     *              "email2": "bob@gmail.com",
     *              "building": "5",
     *              "role": "1",
     *              "active": "1",
     *              "phone": "5182444777",
     *              "room": "302",
     *              "has_photo_id": "1",
     *              "photo_id_url": "http://idmanager.sage.edu/pics/accepted/0999998.jpg",
     *              "photo_id_filename": "999998.jpg"
     *           }
     *     }
     *
     * @apiError {String} application The name of the application that is accessing the API.
     * @apiError {Boolean} success Tells the application if the request was successful.
     * @apiError {String} UserNotFound The id of the user was not found.
     * @apiErrorExample Error Response:
     *      HTTP/1.1 404 Not Found
     *      {
     *          "application": "Awesome Application",
     *          "success": false,
     *          "error": "UserNotFound"
     *      }
     */

    /**
     * @param array $apiKey
     * @param MySQLHelper $MySQLiHelper
     * @param string $username
     * @return array
     */
    public function getByUsername(array $apiKey, MySQLHelper $MySQLiHelper, $username = '')
    {
        $mysqli = $MySQLiHelper->getMySQLi(Config::getSQLConf()['db_user'], Config::getSQLConf()['db_pass'], Config::getSQLConf()['db_name'], Config::getSQLConf()['db_host']);
        if ($result = $MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'username', $username)->fetch_assoc()) {
            $mysqli->close();
            return array('application' => $apiKey['app'], 'success' => true, 'result' => $result);
        } else {
            $mysqli->close();
            header('HTTP/1.1 404 Not Found');
            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'UserNotFound');
        }
    }


    /**
     * @api {get} /user/:limit Get X Amount of Records
     * @apiVersion 1.0.0
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Users
     * @apiParam {Int} limit The max amount of users to return, 0 form all users.
     * @apiDescription This method allows an application to view multiple records.
     * The `limit` parameter is the max amount of user records that will be returned.
     * To get all records set the limit to `0`.
     *
     * @apiSuccess {String} application The name of the application that is accessing the API.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Array} result An array of user record objects.
     * @apiSampleRequest https://databridge.sage.edu/v1/user/:limit
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/user/:limit
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/user/:limit",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user/:limit");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/user/:limit -Headers $headers
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/user/:limit")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/user/:limit",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/user/:limit")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     * @apiSuccessExample Success Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "application": "Awesome Application",
     *          "success": true,
     *          "result": [
     *            {
     *              "id": "1",
     *              "sageid": "999998",
     *              "username": "buildb3",
     *              "name_first": "Bob",
     *              "name_middle": "T.",
     *              "name_last": "Builder",
     *              "email": "buildb3@sage.edu",
     *              "email2": "bob@gmail.com",
     *              "building": "5",
     *              "role": "1",
     *              "active": "1",
     *              "phone": "5182444777",
     *              "room": "302",
     *              "has_photo_id": "1",
     *              "photo_id_url": "http://idmanager.sage.edu/pics/accepted/0999998.jpg",
     *              "photo_id_filename": "999998.jpg"
     *           },
     *           {
     *              "id": "2",
     *              "sageid": "999997",
     *              "username": "dorae",
     *              "name_first": "Dora",
     *              "name_middle": "T.",
     *              "name_last": "Explorer",
     *              "email": "dorae@sage.edu",
     *              "email2": "dora@gmail.com",
     *              "building": "5",
     *              "role": "1",
     *              "active": "1",
     *              "phone": "5182444779",
     *              "room": "301",
     *              "has_photo_id": "1",
     *              "photo_id_url": "http://idmanager.sage.edu/pics/accepted/0999997.jpg",
     *              "photo_id_filename": "999997.jpg"
     *           }
     *         ]
     *     }
     *
     * @apiError {String} application The name of the application that is accessing the API.
     * @apiError {Boolean} success Tells the application if the request was successful.
     * @apiError {String} UsersNotFound The id of the user was not found.
     * @apiErrorExample Error Response:
     *      HTTP/1.1 404 Not Found
     *      {
     *          "application": "Awesome Application",
     *          "success": false,
     *          "error": "UsersNotFound"
     *      }
     */

    /**
     * @param array $apiKey
     * @param MySQLHelper $MySQLiHelper
     * @param int $limit
     * @return array
     */
    public function getMultiple(array $apiKey, MySQLHelper $MySQLiHelper, $limit = 0)
    {
        $mysqli = $MySQLiHelper->getMySQLi(Config::getSQLConf()['db_user'], Config::getSQLConf()['db_pass'], Config::getSQLConf()['db_name'], Config::getSQLConf()['db_host']);
        if ($result = $MySQLiHelper->selectAllFrom($mysqli, Config::getSQLConf()['db_user_table'], $limit)->fetch_all(MYSQLI_ASSOC)) {
            $mysqli->close();
            return array('application' => $apiKey['app'], 'success' => true, 'result' => $result);
        } else {
            $mysqli->close();
            header('HTTP/1.1 404 Not Found');
            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'UsersNotFound');
        }
    }

    /**
     * @api {get} /user/ Get Available Methods
     * @apiVersion 1.0.0
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Users
     * @apiDescription This method lists the methods available under `/user/`
     * @apiSuccess {String} application The name of the application that is accessing the API.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The methods that are available
     * @apiSampleRequest https://databridge.sage.edu/v1/user/
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/user/
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/user/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user/");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/user/ -Headers $headers
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/user/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/user/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/user/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     * @apiSuccessExample Success Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "application": "Awesome Application",
     *          "success": true,
     *          "result": {
     *                "get": [
     *                   "\/id\/:id",
     *                   "\/sageid\/:sageid",
     *                   "\/username\/:username",
     *                   "\/:limit"
     *                 ],
     *                 "post": [
     *                      "\/sageid\/:sageid"
     *                 ]
     *           }
     *     }
     */

    /**
     * @param array $apiKey
     * @return array
     */
    public function getRoot(array $apiKey)
    {
        return array(
            'application' => $apiKey['app'],
            'success' => true,
            'result' => array(
                'get' => array(
                    '/id/:id',
                    '/sageid/:sageid',
                    '/username/:username',
                    '/:limit'
                ),
                'post' => array(
                    '/sageid/:sageid'
                )
            ));
    }

}