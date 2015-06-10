<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/6/15
 * Time: 10:40 AM
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

require dirname(dirname(dirname(__FILE__))) . '/vendor/autoload.php';
include_once dirname(dirname(dirname(__FILE__))) . '/lib/api/Controller.php';
include_once dirname(dirname(dirname(__FILE__))) . '/lib/aah/MySQLHelper.php';
include_once dirname(dirname(dirname(__FILE__))) . '/Config.php';

// Init a slim object
$slim = new \Slim\Slim();
// Init a MySQLi helper class
$MySQLiHelper = new MySQLHelper();
// Get Mysql Config
$sqlConf = Config::getSQLConf();
// Create a mysqli object
$mysqli = $MySQLiHelper->getMySQLi($sqlConf['db_user'], $sqlConf['db_pass'], $sqlConf['db_name'], $sqlConf['db_host']);
// New Controller object
$Controller = new Controller();
// Check the API authorization
if ($slim->request->headers->get('X-Authorization') && $apiKey = $Controller->checkAPIKey($mysqli, $MySQLiHelper, $slim->request->headers->get('X-Authorization'), Config::getSQLConf()['db_api_key_table'])) {

    $slim->group('/user', function () use ($slim, $Controller, $apiKey, $MySQLiHelper, $sqlConf) {

        $table = $sqlConf['db_user_table'];
        $attrs = Config::getUserAttributes();

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

        $slim->post('/sageid/:sageid', function ($sageid) use ($Controller, $apiKey, $MySQLiHelper, $slim, $sqlConf, $table, $attrs) {
            echo json_encode($Controller->postToBy($Controller, $apiKey, $MySQLiHelper, $sqlConf, $table, 'sageid', $sageid, json_decode(json_encode($slim->request->post()), true), $attrs));
        });

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
         * @apiError {String} NotFound The id of the user was not found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "NotFound"
         *      }
         */

        $slim->get('/id/:id', function ($id) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getBy($apiKey, $MySQLiHelper, $sqlConf, $table, 'id', $id));
        });

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
         * @apiError {String} NotFound The id of the user was not found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "NotFound"
         *      }
         */

        $slim->get('/sageid/:sageid', function ($sageid) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getBy($apiKey, $MySQLiHelper, $sqlConf, $table, 'sageid', $sageid));
        });


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
         * @apiError {String} NotFound The id of the user was not found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "NotFound"
         *      }
         */

        $slim->get('/username/:username', function ($username) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getBy($apiKey, $MySQLiHelper, $sqlConf, $table, 'username', $username));
        });

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
         * @apiError {String} NotFound The id of the user was not found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "NotFound"
         *      }
         */

        $slim->get('/:limit', function ($limit) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getMultiple($apiKey, $MySQLiHelper, $sqlConf, $table, $limit));
        });

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
         * Start informational responses
         */
        $slim->get('/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        $slim->get('/id/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        $slim->get('/sageid/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        $slim->get('/username/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        /**
         * End informational responses
         */

    });

    $slim->group(('/role'), function () use ($slim, $Controller, $apiKey, $MySQLiHelper, $sqlConf) {

        $table = $sqlConf['db_role_table'];
        $attrs = Config::getRoleAttributes();

        /**
         * @api {post} /role/code/:code Post to Role
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Roles
         * @apiParam {String} Object's unique Datatel code.
         * @apiDescription Using a Datatel code as part of the url parameter, an application can create new role record or update existing records.
         * If the Datatel code in the URL does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry.
         * If the Datatel code in the URL does exist in the database, the data sent in the POST request will replace the data in that record.
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" \
         *      --data "name=Alumni" \
         *      --url https://databridge.sage.edu/v1/role/code/:code
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/role/code/:code",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
         *      parameters:{ :name => "Alumni"}.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/role/code/:code");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      curl_setopt($ch, CURLOPT_POST, true);
         *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("name" => "Alumni");
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $uri = https://databridge.sage.edu/v1/role/code/:code
         *      $body = @{ email2 = "Alumni" }
         *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/role/code/:code")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .body("{\"name\":\"Alumni\"}")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.post("https://databridge.sage.edu/v1/role/code/:code",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          },
         *          params={
         *              "name": "Alumni"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/role/code/:code")
         *       .header("X-Authorization", "<Your-API-Key>")
         *       .header("Accept", "application/json")
         *       .field("name", "Alumni")
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
         *              "code": true,
         *              "name": true,
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

        $slim->post('/code/:code', function ($code) use ($Controller, $apiKey, $MySQLiHelper, $slim, $sqlConf, $table, $attrs) {
            echo json_encode($Controller->postToBy($Controller, $apiKey, $MySQLiHelper, $sqlConf, $table, 'code', $code, json_decode(json_encode($slim->request->post()), true), $attrs));
        });


        /**
         * @api {get} /role/id/:id Get by ID
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Roles
         * @apiParam {Int} id Role's unique API ID.
         * @apiDescription This method allows an application to view a role record using the database index `ID` number.
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Object} result The role record object.
         * @apiSampleRequest https://databridge.sage.edu/v1/role/id/:id
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/role/id/:id
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/role/id/:id",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/role/id/:id");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/role/id/:id -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/role/id/:id")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/role/id/:id",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/role/id/:id")
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
         *              "code": "STUDENT",
         *              "name": "Student"
         *           }
         *     }
         *
         * @apiError {String} application The name of the application that is accessing the API.
         * @apiError {Boolean} success Tells the application if the request was successful.
         * @apiError {String} RoleNotFound The id of the role was not found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "RoleNotFound"
         *      }
         */

        $slim->get('/id/:id', function ($id) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getBy($apiKey, $MySQLiHelper, $sqlConf, $table, 'id', $id));
        });

        /**
         * @api {get} /role/code/:code Get by Datatel Code
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Roles
         * @apiParam {String} Datatel code that corresponds with that role.
         * @apiDescription This method allows an application to view a role record using appropriate `Datatel_Code`.
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Object} result The role record object.
         * @apiSampleRequest https://databridge.sage.edu/v1/role/code/:code
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/role/code/:code
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/role/code/:code",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/role/code/:code");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/role/code/:code -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/role/code/:code")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/role/code/:code",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/role/code/:code")
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
         *              "code": "STUDENT",
         *              "name": "Student"
         *           }
         *     }
         *
         * @apiError {String} application The name of the application that is accessing the API.
         * @apiError {Boolean} success Tells the application if the request was successful.
         * @apiError {String} RoleNotFound The Datatel code of the role was not found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "RoleNotFound"
         *      }
         */

        $slim->get('/code/:code', function ($code) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getBy($apiKey, $MySQLiHelper, $sqlConf, $table, 'code', $code));
        });

        /**
         * @api {get} /role/:limit Get X Amount of Records
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Roles
         * @apiParam {Int} limit The max amount of records to return, 0 returns all of them.
         * @apiDescription This method allows an application to view multiple records.
         * The `limit` parameter is the max amount of user records that will be returned.
         * To get all records set the limit to `0`.
         *
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Array} result An array of role record objects.
         * @apiSampleRequest https://databridge.sage.edu/v1/role/:limit
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/role/:limit
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/role/:limit",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/role/:limit");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/role/:limit -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/role/:limit")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/role/:limit",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/role/:limit")
         *       .header("X-Authorization", "<Your-API-Key>")
         *       .header("Accept", "application/json")
         *       .asString();
         * @apiSuccessExample Success Response:
         *     HTTP/1.1 200 OK
         *     {
         *          "application": "Awesome Application",
         *          "success": true,
         *          "result": [
         *             {
         *                  "id": "1",
         *                  "code": "STUDENT",
         *                  "name": "Student"
         *              },
         *              {
         *                  "id": "2",
         *                  "code": "EMPLOYEE",
         *                  "name": "Employee"
         *              }
         *          ]
         *     }
         *
         * @apiError {String} application The name of the application that is accessing the API.
         * @apiError {Boolean} success Tells the application if the request was successful.
         * @apiError {String} RolesNotFound The was no roles found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "RolesNotFound"
         *      }
         */

        $slim->get('/:limit', function ($limit) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getMultiple($apiKey, $MySQLiHelper, $sqlConf, $table, $limit));
        });

        /**
         * @api {get} /role/ Get Available Methods
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Roles
         * @apiDescription This method lists the methods available under `/role/`
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Object} result The methods that are available
         * @apiSampleRequest https://databridge.sage.edu/v1/role/
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/role/
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/role/",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/role/");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/role/ -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/role/")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/role/",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/role/")
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
         *                  "\/id\/:id",
         *                  "\/code\/:code",
         *                  "\/:limit"
         *                 ],
         *               "post": [
         *                  "\/code\/:code"
         *                 ]
         *           }
         *     }
         */

        /**
         * Start informational responses
         */
        $slim->get('/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        $slim->get('/id/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        $slim->get('/code/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        /**
         * End informational responses
         */
    });

    $slim->group(('/building'), function () use ($slim, $Controller, $apiKey, $MySQLiHelper, $sqlConf, $Controller) {

        $table = $sqlConf['db_building_table'];
        $attrs = Config::getBuildingAttributes();

        /**
         * @api {post} /building/code/:code Post to Building
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Buildings
         * @apiParam {String} Object's unique Datatel code.
         * @apiDescription Using a Datatel code as part of the url parameter, an application can create new building record or update existing records.
         * If the Datatel code in the URL does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry.
         * If the Datatel code in the URL does exist in the database, the data sent in the POST request will replace the data in that record.
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" \
         *      --data "name=Ackerman" \
         *      --url https://databridge.sage.edu/v1/building/code/:code
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/building/code/:code",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
         *      parameters:{ :name => "Ackerman"}.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/building/code/:code");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      curl_setopt($ch, CURLOPT_POST, true);
         *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("name" => "Ackerman");
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $uri = https://databridge.sage.edu/v1/building/code/:code
         *      $body = @{ email2 = "Ackerman" }
         *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/building/code/:code")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .body("{\"name\":\"Ackerman\"}")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.post("https://databridge.sage.edu/v1/building/code/:code",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          },
         *          params={
         *              "name": "Ackerman"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/building/code/:code")
         *       .header("X-Authorization", "<Your-API-Key>")
         *       .header("Accept", "application/json")
         *       .field("name", "Ackerman")
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
         *              "code": true,
         *              "campus": true,
         *              "name": true,
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

        $slim->post('/code/:code', function ($code) use ($Controller, $apiKey, $MySQLiHelper, $slim, $sqlConf, $table, $attrs) {
            echo json_encode($Controller->postToBy($Controller, $apiKey, $MySQLiHelper, $sqlConf, $table, 'code', $code, json_decode(json_encode($slim->request->post()), true), $attrs));
        });


        /**
         * @api {get} /building/id/:id Get by ID
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Buildings
         * @apiParam {Int} id Buildings's unique API ID.
         * @apiDescription This method allows an application to view a building record using the database index `ID` number.
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Object} result The building record object.
         * @apiSampleRequest https://databridge.sage.edu/v1/building/id/:id
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/building/id/:id
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/building/id/:id",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/building/id/:id");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/building/id/:id -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/building/id/:id")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/building/id/:id",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/building/id/:id")
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
         *              "campus": "1",
         *              "code": "37-1",
         *              "name": "37 First Street"
         *           }
         *     }
         *
         * @apiError {String} application The name of the application that is accessing the API.
         * @apiError {Boolean} success Tells the application if the request was successful.
         * @apiError {String} BuildingNotFound The id of the building was not found.
         * @apiErrorExample Error-Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "BuildingNotFound"
         *      }
         */

        $slim->get('/id/:id', function ($id) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getBy($apiKey, $MySQLiHelper, $sqlConf, $table, 'id', $id));
        });

        /**
         * @api {get} /building/code/:code Get by Datatel Code
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Buildings
         * @apiParam {String} Datatel code that corresponds with that building.
         * @apiDescription This method allows an application to view a building record using appropriate `Datatel_Code`.
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Object} result The building record object.
         * @apiSampleRequest https://databridge.sage.edu/v1/building/code/:code
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/building/code/:code
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/building/code/:code",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/building/code/:code");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/building/code/:code -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/building/code/:code")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/building/code/:code",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/building/code/:code")
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
         *              "campus": "1",
         *              "code": "37-1",
         *              "name": "37 First Street"
         *           }
         *     }
         *
         * @apiError {String} application The name of the application that is accessing the API.
         * @apiError {Boolean} success Tells the application if the request was successful.
         * @apiError {String} BuildingNotFound The Datatel code of the building was not found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "BuildingNotFound"
         *      }
         */

        $slim->get('/code/:code', function ($code) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getBy($apiKey, $MySQLiHelper, $sqlConf, $table, 'code', $code));
        });

        /**
         * @api {get} /building/:limit Get X Amount of Records
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Buildings
         * @apiParam {Int} limit The max amount of records to return, 0 returns all of them.
         * @apiDescription This method allows an application to view multiple records.
         * The `limit` parameter is the max amount of user records that will be returned.
         * To get all records set the limit to `0`.
         *
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Array} result An array of building record objects.
         * @apiSampleRequest https://databridge.sage.edu/v1/building/:limit
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/building/:limit
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/building/:limit",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/building/:limit");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/building/:limit -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/building/:limit")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/building/:limit",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/building/:limit")
         *       .header("X-Authorization", "<Your-API-Key>")
         *       .header("Accept", "application/json")
         *       .asString();
         * @apiSuccessExample Success Response:
         *     HTTP/1.1 200 OK
         *     {
         *          "application": "Awesome Application",
         *          "success": true,
         *          "result": [
         *             {
         *                  "id": "1",
         *                  "campus": "1",
         *                  "code": "37-1",
         *                  "name": "37 First Street"
         *              },
         *              {
         *                  "id": "2",
         *                  "campus": "1",
         *                  "code": "90-1",
         *                  "name": "90 1st Street"
         *              }
         *          ]
         *     }
         *
         * @apiError {String} application The name of the application that is accessing the API.
         * @apiError {Boolean} success Tells the application if the request was successful.
         * @apiError {String} BuildingsNotFound The was no buildings found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "BuildingsNotFound"
         *      }
         */

        $slim->get('/:limit', function ($limit) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getMultiple($apiKey, $MySQLiHelper, $sqlConf, $table, $limit));
        });

        /**
         * @api {get} /building/ Get Available Methods
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Buildings
         * @apiDescription This method lists the methods available under `/building/`
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Object} result The methods that are available
         * @apiSampleRequest https://databridge.sage.edu/v1/building/
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/building/
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/building/",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/building/");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/building/ -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/building/")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/building/",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/building/")
         *       .header("X-Authorization", "<Your-API-Key>")
         *       .header("Accept", "application/json")
         *       .asString();
         * @apiSuccessExample Success Response:
         *     HTTP/1.1 200 OK
         *     {
         *          "application": "Awesome Application",
         *          "success": true,
         *          "result": {
         *               "get": [
         *                  "\/id\/:id",
         *                  "\/code\/:code",
         *                  "\/:limit"
         *                 ],
         *               "post": [
         *                  "\/code\/:code"
         *                 ]
         *           }
         *     }
         */

        /**
         * Start informational responses
         */
        $slim->get('/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        $slim->get('/id/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        $slim->get('/code/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        /**
         * End informational responses
         */
    });

    $slim->group(('/campus'), function () use ($slim, $Controller, $apiKey, $MySQLiHelper, $sqlConf) {

        $table = $sqlConf['db_campus_table'];
        $attrs = Config::getCampusAttributes();

        /**
         * @api {post} /campus/code/:code Post to Campus
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Campuses
         * @apiParam {String} Object's unique Datatel code.
         * @apiDescription Using a Datatel code as part of the url parameter, an application can create new campus record or update existing records.
         * If the Datatel code in the URL does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry.
         * If the Datatel code in the URL does exist in the database, the data sent in the POST request will replace the data in that record.
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" \
         *      --data "name=Sage College of Albany" \
         *      --url https://databridge.sage.edu/v1/campus/code/:code
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/campus/code/:code",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
         *      parameters:{ :name => "Sage College of Albany"}.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/campus/code/:code");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      curl_setopt($ch, CURLOPT_POST, true);
         *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("name" => "Sage College of Albany");
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $uri = https://databridge.sage.edu/v1/campus/code/:code
         *      $body = @{ email2 = "Sage College of Albany" }
         *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/campus/code/:code")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .body("{\"name\":\"Sage College of Albany\"}")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.post("https://databridge.sage.edu/v1/campus/code/:code",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          },
         *          params={
         *              "name": "Sage College of Albany"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/campus/code/:code")
         *       .header("X-Authorization", "<Your-API-Key>")
         *       .header("Accept", "application/json")
         *       .field("name", "Sage College of Albany")
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
         *              "code": true,
         *              "name": true,
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

        $slim->post('/code/:code', function ($code) use ($Controller, $apiKey, $MySQLiHelper, $slim, $sqlConf, $table, $attrs) {
            echo json_encode($Controller->postToBy($Controller, $apiKey, $MySQLiHelper, $sqlConf, $table, 'code', $code, json_decode(json_encode($slim->request->post()), true), $attrs));
        });

        /**
         * @api {get} /campus/id/:id Get by ID
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Campuses
         * @apiParam {Int} id Campus' unique API ID.
         * @apiDescription This method allows an application to view a campus record using the database index `ID` number.
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Object} result The campus record object.
         * @apiSampleRequest https://databridge.sage.edu/v1/campus/id/:id
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/campus/id/:id
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/campus/id/:id",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/campus/id/:id");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/campus/id/:id -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/campus/id/:id")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/campus/id/:id",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/campus/id/:id")
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
         *              "code": "TRY",
         *              "name": "Russell Sage College"
         *           }
         *     }
         *
         * @apiError {String} application The name of the application that is accessing the API.
         * @apiError {Boolean} success Tells the application if the request was successful.
         * @apiError {String} BuildingNotFound The id of the campus was not found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "CampusNotFound"
         *      }
         */

        $slim->get('/id/:id', function ($id) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getBy($apiKey, $MySQLiHelper, $sqlConf, $table, 'id', $id));
        });

        /**
         * @api {get} /campus/code/:code Get by Datatel Code
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Campuses
         * @apiParam {String} Datatel code that corresponds with that campus.
         * @apiDescription This method allows an application to view a campus record using appropriate `Datatel_Code`.
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Object} result The campus record object.
         * @apiSampleRequest https://databridge.sage.edu/v1/campus/code/:code
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/campus/code/:code
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/campus/code/:code",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/campus/code/:code");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/campus/code/:code -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/campus/code/:code")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/campus/code/:code",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/campus/code/:code")
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
         *              "code": "TRY",
         *              "name": "Russell Sage College"
         *           }
         *     }
         *
         * @apiError {String} application The name of the application that is accessing the API.
         * @apiError {Boolean} success Tells the application if the request was successful.
         * @apiError {String} BuildingNotFound The Datatel code of the campus was not found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "CampusNotFound"
         *      }
         */

        $slim->get('/code/:code', function ($code) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getBy($apiKey, $MySQLiHelper, $sqlConf, $table, 'code', $code));
        });

        /**
         * @api {get} /campus/:limit Get X Amount of Records
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Campuses
         * @apiParam {Int} limit The max amount of records to return, 0 returns all of them.
         * @apiDescription This method allows an application to view multiple records.
         * The `limit` parameter is the max amount of user records that will be returned.
         * To get all records set the limit to `0`.
         *
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Array} result An array of campus record objects.
         * @apiSampleRequest https://databridge.sage.edu/v1/campus/:limit
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/campus/:limit
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/campus/:limit",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/campus/:limit");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/campus/:limit -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/campus/:limit")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/campus/:limit",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/campus/:limit")
         *       .header("X-Authorization", "<Your-API-Key>")
         *       .header("Accept", "application/json")
         *       .asString();
         * @apiSuccessExample Success Response:
         *     HTTP/1.1 200 OK
         *     {
         *          "application": "Awesome Application",
         *          "success": true,
         *          "result": [
         *             {
         *                  "id": "1",
         *                  "code": "TRY",
         *                  "name": "Russell Sage College"
         *              },
         *              {
         *                  "id": "2",
         *                  "code": "ALB",
         *                  "name": "Sage College of Albany"
         *              }
         *          ]
         *     }
         *
         * @apiError {String} application The name of the application that is accessing the API.
         * @apiError {Boolean} success Tells the application if the request was successful.
         * @apiError {String} CampusesNotFound The was no campuses found.
         * @apiErrorExample Error Response:
         *      HTTP/1.1 404 Not Found
         *      {
         *          "application": "Awesome Application",
         *          "success": false,
         *          "error": "CampusesNotFound"
         *      }
         */

        $slim->get('/:limit', function ($limit) use ($apiKey, $MySQLiHelper, $Controller, $sqlConf, $table) {
            echo json_encode($Controller->getMultiple($apiKey, $MySQLiHelper, $sqlConf, $table, $limit));
        });

        /**
         * @api {get} /campus/ Get Available Methods
         * @apiVersion 1.0.0
         * @apiHeader {String} X-Authorization The application's unique access-key.
         * @apiGroup Campuses
         * @apiDescription This method lists the methods available under `/campus/`
         * @apiSuccess {String} application The name of the application that is accessing the API.
         * @apiSuccess {Boolean} success Tells the application if the request was successful.
         * @apiSuccess {Object} result The methods that are available
         * @apiSampleRequest https://databridge.sage.edu/v1/campus/
         * @apiExample {curl} Curl
         *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/campus/
         * @apiExample {ruby} Ruby
         *      # This code snippet uses an open-source library. http://unirest.io/ruby
         *      response = Unirest.get "https://databridge.sage.edu/v1/campus/",
         *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
         * @apiExample {php} PHP
         *      $ch = curl_init("https://databridge.sage.edu/v1/campus/");
         *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
         *      $result = curl_exec($ch);
         *      curl_close($ch);
         * @apiExample {powershell} PowerShell
         *      # PowerShell v3 and above
         *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
         *      $headers.Add("X-Authorization", '<Your-API-Key>')
         *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/campus/ -Headers $headers
         * @apiExample {java} Java
         *      # This code snippet uses an open-source library. http://unirest.io/java
         *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/campus/")
         *      .header("X-Authorization", "<Your-API-Key>")
         *      .header("Accept", "application/json")
         *      .asString();
         * @apiExample {python} Python
         *      # This code snippet uses an open-source library http://unirest.io/python
         *      response = unirest.get("https://databridge.sage.edu/v1/campus/",
         *          headers={
         *              "X-Authorization": "<Your-API-Key>",
         *              "Accept": "application/json"
         *          }
         *      )
         * @apiExample {.net} .NET
         *      // This code snippet uses an open-source library http://unirest.io/net
         *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/campus/")
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
         *                  "\/id\/:id",
         *                  "\/code\/:code",
         *                  "\/:limit"
         *                 ],
         *               "post": [
         *                  "\/code\/:code"
         *                 ]
         *           }
         *     }
         */

        /**
         * Start informational responses
         */
        $slim->get('/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        $slim->get('/id/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        $slim->get('/code/', function () use ($apiKey, $Controller, $attrs) {
            echo json_encode($Controller->getRoot($apiKey, $attrs));
        });

        /**
         * End informational responses
         */
    });
    $slim->run();
} else {
    // Throw a 401 unauthorized, since the app is not authorized
    $Controller->unauthorized();
}