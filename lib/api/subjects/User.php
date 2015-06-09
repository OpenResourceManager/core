<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/8/15
 * Time: 8:09 PM
 */

error_reporting(E_ALL);
ini_set("display_errors", 1);

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
     * @param \Slim\Slim $slim
     * @param string $sageid
     * @return array
     */
    public function postUser(API $api, array $apiKey, MySQLHelper $MySQLiHelper, \Slim\Slim $slim, $sageid = '')
    {
        // Create a mysqli object
        $mysqli = $MySQLiHelper->getMySQLi(Config::getSQLConf()['db_user'], Config::getSQLConf()['db_pass'], Config::getSQLConf()['db_name'], Config::getSQLConf()['db_host']);
        if ($apiKey['write'] == 1) {
            $data = json_decode(json_encode($slim->request->post()), true);
            if (!empty($data)) {
                $exists = ($MySQLiHelper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'sageid', $sageid)->fetch_assoc()) ? true : false;
                if ($exists) {
                    // Unset protected values
                    if (isset($data['sageid'])) unset($data['sageid']);
                    if (isset($data['id'])) unset($data['id']);
                    if ($MySQLiHelper->simpleUpdate($mysqli, Config::getSQLConf()['db_user_table'], $data, 'sageid', $sageid)) {
                        return array('application' => $apiKey['app'], 'success' => true, 'result' => 'update');
                    } else {
                        header('HTTP/1.1 500 Server Error');
                        return array('application' => $apiKey['app'], 'success' => false, 'error' => 'FailedToWrite');
                    }
                } else {
                    if ($api->checkPostDataValues($data, Config::getUserAttributes())) {
                        if ($MySQLiHelper->simpleInsert($mysqli, Config::getSQLConf()['db_user_table'], $data)) {
                            return array('application' => $apiKey['app'], 'success' => true, 'result' => 'create');
                        } else {
                            header('HTTP/1.1 500 Server Error');
                            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'FailedToWrite');
                        }
                    } else {
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
        $mysqli->close();
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
        // Create a mysqli object
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

}