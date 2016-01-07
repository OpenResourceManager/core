<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/10/15
 * Time: 1:36 PM
 */

/**
 * @api {get} /department/ Get: All
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Department
 * @apiDescription This method returns all department objects.
 *
 * @apiSampleRequest https://databridge.sage.edu/v1/department/
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/department/
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.get "https://databridge.sage.edu/v1/department/",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/department/");
 *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
 *      $result = curl_exec($ch);
 *      curl_close($ch);
 *
 * @apiExample {powershell} PowerShell
 *      # PowerShell v3 and above
 *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
 *      $headers.Add("X-Authorization", '<Your-API-Key>')
 *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/department/ -Headers $headers
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/department/")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.get("https://databridge.sage.edu/v1/department/",
 *          headers={
 *              "X-Authorization": "<Your-API-Key>",
 *              "Accept": "application/json"
 *          }
 *      )
 *
 * @apiExample {.net} .NET
 *      // This code snippet uses an open-source library http://unirest.io/net
 *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/department/")
 *       .header("X-Authorization", "<Your-API-Key>")
 *       .header("Accept", "application/json")
 *       .asString();
 *
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {Objects} result The objects that have been returned.
 * @apiSuccess {Integer} id The numeric id of the object.
 * @apiSuccess {Boolean} academic Signifies if the department is an academic department.
 * @apiSuccess {String} code The code assigned to the department by Informer.
 * @apiSuccess {String} name The common name associated with the department.
 * @apiSuccess {Timestamp} created_at The date and time that the object was created.
 * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
 *
 * @apiSuccessExample {json} Success: Objects
 *     HTTP/1.1 200 OK
 *     {
 *         "success": true,
 *         "result": [
 *           {
 *             "id": "1",
 *             "academic": "1",
 *             "code": "CEU",
 *             "name": "Continuing Education",
 *             "created_at": "2015-10-21 13:29:11",
 *             "updated_at": "2015-10-21 13:29:11"
 *           },
 *           {
 *              "id": "2",
 *              "academic": "1",
 *              "code": "HUM",
 *              "name": "Humanities",
 *              "created_at": "2015-10-21 13:29:11",
 *              "updated_at": "2015-10-21 13:29:11"
 *           },
 *           {
 *              "id": "3",
 *              "academic": "1",
 *              "code": "AMS",
 *              "name": "American Studies",
 *              "created_at": "2015-10-21 13:29:11",
 *              "updated_at": "2015-10-21 13:29:11"
 *           },
 *           {
 *              "id": "4",
 *              "academic": "1",
 *              "code": "AMS, ENG",
 *              "name": "American Studies, English",
 *              "created_at": "2015-10-21 13:29:11",
 *              "updated_at": "2015-10-21 13:29:11"
 *           }
 *         ]
 *     }
 *
 * @apiError (Error 4xx/5xx) {Boolean} success Tells the application if the request was successful.
 * @apiError (Error 4xx/5xx) {String} error An error message from the server.
 *
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Insufficient privileges."
 *      }
 *
 * @apiErrorExample {json} Error: Invalid API Key
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: API Key is not valid."
 *      }
 *
 * @apiErrorExample {json} Error: Method not found
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "Method not found."
 *      }
 *
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Header Option Not Found."
 *      }
 */

/**
 * @api {get} /department/:limit Get: X amount
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Department
 * @apiDescription This method returns objects up to the limit specified.
 * @apiParam {Integer} limit The max number of objects returned.
 *
 * @apiSampleRequest https://databridge.sage.edu/v1/department/
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/department/2/
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.get "https://databridge.sage.edu/v1/department/2/",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/department/2/");
 *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
 *      $result = curl_exec($ch);
 *      curl_close($ch);
 *
 * @apiExample {powershell} PowerShell
 *      # PowerShell v3 and above
 *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
 *      $headers.Add("X-Authorization", '<Your-API-Key>')
 *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/department/2/ -Headers $headers
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/department/2/")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.get("https://databridge.sage.edu/v1/department/2/",
 *          headers={
 *              "X-Authorization": "<Your-API-Key>",
 *              "Accept": "application/json"
 *          }
 *      )
 *
 * @apiExample {.net} .NET
 *      // This code snippet uses an open-source library http://unirest.io/net
 *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/department/2/")
 *       .header("X-Authorization", "<Your-API-Key>")
 *       .header("Accept", "application/json")
 *       .asString();
 *
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {Objects} result The objects that have been returned.
 * @apiSuccess {Integer} id The numeric id of the object.
 * @apiSuccess {Boolean} academic Signifies if the department is an academic department.
 * @apiSuccess {String} code The code assigned to the department by Informer.
 * @apiSuccess {String} name The common name associated with the department.
 * @apiSuccess {Timestamp} created_at The date and time that the object was created.
 * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
 *
 * @apiSuccessExample {json} Success: Objects
 *     HTTP/1.1 200 OK
 *     {
 *         "success": true,
 *         "result": [
 *           {
 *             "id": "1",
 *             "academic": "1",
 *             "code": "CEU",
 *             "name": "Continuing Education",
 *             "created_at": "2015-10-21 13:29:11",
 *             "updated_at": "2015-10-21 13:29:11"
 *           },
 *           {
 *              "id": "2",
 *              "academic": "1",
 *              "code": "HUM",
 *              "name": "Humanities",
 *              "created_at": "2015-10-21 13:29:11",
 *              "updated_at": "2015-10-21 13:29:11"
 *           }
 *         ]
 *     }
 *
 * @apiError (Error 4xx/5xx) {Boolean} success Tells the application if the request was successful.
 * @apiError (Error 4xx/5xx) {String} error An error message from the server.
 *
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Insufficient privileges."
 *      }
 *
 * @apiErrorExample {json} Error: Invalid API Key
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: API Key is not valid."
 *      }
 *
 * @apiErrorExample {json} Error: Method not found
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "Method not found."
 *      }
 *
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Header Option Not Found."
 *      }
 */

/**
 * @api {get} /department/id/:id Get: by ID
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Department
 * @apiDescription This method returns an object with the specified ID.
 * @apiParam {Integer} id The id of a specific object.
 *
 * @apiSampleRequest https://databridge.sage.edu/v1/department/id/:id
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/department/id/2/
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.get "https://databridge.sage.edu/v1/department/id/2/",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/department/id/2/");
 *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
 *      $result = curl_exec($ch);
 *      curl_close($ch);
 *
 * @apiExample {powershell} PowerShell
 *      # PowerShell v3 and above
 *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
 *      $headers.Add("X-Authorization", '<Your-API-Key>')
 *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/department/id/2/ -Headers $headers
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/department/id/2/")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.get("https://databridge.sage.edu/v1/department/id/2/",
 *          headers={
 *              "X-Authorization": "<Your-API-Key>",
 *              "Accept": "application/json"
 *          }
 *      )
 *
 * @apiExample {.net} .NET
 *      // This code snippet uses an open-source library http://unirest.io/net
 *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/department/id/2/")
 *       .header("X-Authorization", "<Your-API-Key>")
 *       .header("Accept", "application/json")
 *       .asString();
 *
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {Object} result The object that has been returned.
 * @apiSuccess {Integer} id The numeric id of the object.
 * @apiSuccess {Boolean} academic Signifies if the department is an academic department.
 * @apiSuccess {String} code The code assigned to the department by Informer.
 * @apiSuccess {String} name The common name associated with the department.
 * @apiSuccess {Timestamp} created_at The date and time that the object was created.
 * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
 *
 * @apiSuccessExample {json} Success: Objects
 *     HTTP/1.1 200 OK
 *     {
 *         "success": true,
 *         "result":
 *         {
 *              "id": "2",
 *              "academic": "1",
 *              "code": "HUM",
 *              "name": "Humanities",
 *              "created_at": "2015-10-21 13:29:11",
 *              "updated_at": "2015-10-21 13:29:11"
 *           }
 *     }
 *
 * @apiError (Error 4xx/5xx) {Boolean} success Tells the application if the request was successful.
 * @apiError (Error 4xx/5xx) {String} error An error message from the server.
 *
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Insufficient privileges."
 *      }
 *
 * @apiErrorExample {json} Error: Invalid API Key
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: API Key is not valid."
 *      }
 *
 * @apiErrorExample {json} Error: Method not found
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "Method not found."
 *      }
 *
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Header Option Not Found."
 *      }
 */

/**
 * @api {get} /department/code/:code Get: by Code
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Department
 * @apiDescription This method returns an object with the specified Code.
 * @apiParam {Integer} id The id of a specific object.
 *
 * @apiSampleRequest https://databridge.sage.edu/v1/department/code/:code
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/department/code/HUM/
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.get "https://databridge.sage.edu/v1/department/code/HUM/",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/department/code/HUM/");
 *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
 *      $result = curl_exec($ch);
 *      curl_close($ch);
 *
 * @apiExample {powershell} PowerShell
 *      # PowerShell v3 and above
 *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
 *      $headers.Add("X-Authorization", '<Your-API-Key>')
 *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/department/code/HUM/ -Headers $headers
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/department/code/HUM/")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.get("https://databridge.sage.edu/v1/department/code/HUM/",
 *          headers={
 *              "X-Authorization": "<Your-API-Key>",
 *              "Accept": "application/json"
 *          }
 *      )
 *
 * @apiExample {.net} .NET
 *      // This code snippet uses an open-source library http://unirest.io/net
 *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/department/code/HUM/")
 *       .header("X-Authorization", "<Your-API-Key>")
 *       .header("Accept", "application/json")
 *       .asString();
 *
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {Object} result The object that has been returned.
 * @apiSuccess {Integer} id The numeric id of the object.
 * @apiSuccess {Boolean} academic Signifies if the department is an academic department.
 * @apiSuccess {String} code The code assigned to the department by Informer.
 * @apiSuccess {String} name The common name associated with the department.
 * @apiSuccess {Timestamp} created_at The date and time that the object was created.
 * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
 *
 * @apiSuccessExample {json} Success: Objects
 *     HTTP/1.1 200 OK
 *     {
 *         "success": true,
 *         "result":
 *         {
 *              "id": "2",
 *              "academic": "1",
 *              "code": "HUM",
 *              "name": "Humanities",
 *              "created_at": "2015-10-21 13:29:11",
 *              "updated_at": "2015-10-21 13:29:11"
 *           }
 *     }
 *
 * @apiError (Error 4xx/5xx) {Boolean} success Tells the application if the request was successful.
 * @apiError (Error 4xx/5xx) {String} error An error message from the server.
 *
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Insufficient privileges."
 *      }
 *
 * @apiErrorExample {json} Error: Invalid API Key
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: API Key is not valid."
 *      }
 *
 * @apiErrorExample {json} Error: Method not found
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "Method not found."
 *      }
 *
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Header Option Not Found."
 *      }
 */

/**
 * @api {post} /department/ Post: Create or Update
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Department
 * @apiDescription An application can create new department record or update existing records.
 * If the Informer code does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry.
 * If the Informer code does exist in the database, the data sent in the POST request will replace the data in that record.
 *
 * @apiParam {Boolean} academic Signifies if the department is an academic department.
 * @apiParam {String} name The name of the department.
 * @apiParam {String} code The code assigned by Informer.
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "academic=true" \
 *      --data "name=Humanities" \
 *      --data "code=HUM" \
 *      --url https://databridge.sage.edu/v1/department
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.post "https://databridge.sage.edu/v1/department",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
 *      parameters:{ :academic => true, :name => "Humanities", :code => "HUM"}.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/department");
 *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
 *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *      curl_setopt($ch, CURLOPT_POST, true);
 *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("academic" => true, "name" => "Humanities", "code" => "HUM"));
 *      $result = curl_exec($ch);
 *      curl_close($ch);
 *
 * @apiExample {powershell} PowerShell
 *      # PowerShell v3 and above
 *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
 *      $headers.Add("X-Authorization", '<Your-API-Key>')
 *      $uri = https://databridge.sage.edu/v1/department
 *      $body = @{ academic = $true, name = "Humanities", code = "HUM" }
 *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.post("https://databridge.sage.edu/v1/department")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .body("{\"academic\":true, \"name\":\"Humanities\", \"code\":\"HUM\"}")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.post("https://databridge.sage.edu/v1/department",
 *          headers={
 *              "X-Authorization": "<Your-API-Key>",
 *              "Accept": "application/json"
 *          },
 *          params={
 *              "academic" : true,
 *              "name": "Humanities",
 *              "code": "HUM"
 *          }
 *      )
 *
 * @apiExample {.net} .NET
 *      // This code snippet uses an open-source library http://unirest.io/net
 *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/department")
 *       .header("X-Authorization", "<Your-API-Key>")
 *       .header("Accept", "application/json")
 *       .field("academic", true)
 *       .field("name", "Humanities")
 *       .field("code", "HUM")
 *       .asString();
 *
 * @apiSuccessExample {json} Success: Create
 *     HTTP/1.1 200 OK
 *     {
 *          "success": true,
 *          "result": "create"
 *     }
 *
 * @apiSuccessExample {json} Success: Update
 *     HTTP/1.1 200 OK
 *     {
 *          "success": true,
 *          "result": "update"
 *     }
 *
 * @apiError (Error 4xx/5xx) {Boolean} success Tells the application if the request was successful.
 * @apiError (Error 4xx/5xx) {String} error An error message from the server.
 *
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Insufficient privileges."
 *      }
 *
 * @apiErrorExample {json} Error: Invalid API Key
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: API Key is not valid."
 *      }
 *
 * @apiErrorExample {json} Error: Method not found
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "Method not found."
 *      }
 *
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Header Option Not Found."
 *      }
 *
 * @apiErrorExample {json} Error: Server Error
 *      HTTP/1.1 500 Server Error
 *      {
 *          "success": false,
 *          "error": "Could not update."
 *      }
 */

/**
 * @api {delete} /department/ Delete: by ID
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Department
 * @apiDescription Delete a department record. This also deletes any program records that may be a child of the department.
 *
 * @apiParam {Integer} id The numeric API id of the department.
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {String} result The action that was performed, this should be `delete`.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "id=1" \
 *      --url https://databridge.sage.edu/v1/department
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.delete "https://databridge.sage.edu/v1/department",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
 *      parameters:{ :id => 1}.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/department");
 *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
 *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
 *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("id" => 1));
 *      $result = curl_exec($ch);
 *      curl_close($ch);
 *
 * @apiExample {powershell} PowerShell
 *      # PowerShell v3 and above
 *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
 *      $headers.Add("X-Authorization", '<Your-API-Key>')
 *      $uri = https://databridge.sage.edu/v1/department
 *      $body = @{ id = 1 }
 *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Delete -Body $body
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.delete("https://databridge.sage.edu/v1/department")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .body("{\"id\":1}")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.delete("https://databridge.sage.edu/v1/department",
 *          headers={
 *              "X-Authorization": "<Your-API-Key>",
 *              "Accept": "application/json"
 *          },
 *          params={
 *              "id" : 1
 *          }
 *      )
 *
 * @apiExample {.net} .NET
 *      // This code snippet uses an open-source library http://unirest.io/net
 *       Task<HttpResponse<MyClass>> response = Unirest.delete("https://databridge.sage.edu/v1/department")
 *       .header("X-Authorization", "<Your-API-Key>")
 *       .header("Accept", "application/json")
 *       .field("id", 1)
 *       .asString();
 *
 * @apiSuccessExample {json} Success: Delete
 *     HTTP/1.1 200 OK
 *     {
 *      "success": true,
 *      "message": "delete"
 *     }
 *
 * @apiError (Error 4xx/5xx) {Boolean} success Tells the application if the request was successful.
 * @apiError (Error 4xx/5xx) {String} error An error message from the server.
 *
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Insufficient privileges."
 *      }
 *
 * @apiErrorExample {json} Error: Invalid API Key
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: API Key is not valid."
 *      }
 *
 * @apiErrorExample {json} Error: Object not found
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "Object not found."
 *      }
 *
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Header Option Not Found."
 *      }
 *
 * @apiErrorExample {json} Error: Server Error
 *      HTTP/1.1 500 Server Error
 *      {
 *          "success": false,
 *          "error": "Could not delete."
 *      }
 */