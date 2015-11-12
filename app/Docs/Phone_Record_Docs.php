<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/10/15
 * Time: 1:36 PM
 */

/**
 * @api {get} /phone/ Get: All
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Phone
 * @apiDescription This method returns all phone objects.
 *
 * @apiSampleRequest https://databridge.sage.edu/v1/phone/
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/phone/
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.get "https://databridge.sage.edu/v1/phone/",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/phone/");
 *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
 *      $result = curl_exec($ch);
 *      curl_close($ch);
 *
 * @apiExample {powershell} PowerShell
 *      # PowerShell v3 and above
 *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
 *      $headers.Add("X-Authorization", '<Your-API-Key>')
 *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/phone/ -Headers $headers
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/phone/")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.get("https://databridge.sage.edu/v1/phone/",
 *          headers={
 *              "X-Authorization": "<Your-API-Key>",
 *              "Accept": "application/json"
 *          }
 *      )
 *
 * @apiExample {.net} .NET
 *      // This code snippet uses an open-source library http://unirest.io/net
 *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/phone/")
 *       .header("X-Authorization", "<Your-API-Key>")
 *       .header("Accept", "application/json")
 *       .asString();
 *
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {Objects} result The objects that have been returned.
 * @apiSuccess {Integer} id The numeric id of the object.
 * @apiSuccess {Integer} user The API ID number assigned to a user associated with this number.
 * @apiSuccess {String} number The phone number.
 * @apiSuccess {String} ext The short extension for this phone number, can be null.
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
 *             "user": "1",
 *             "number": "15182445765",
 *             "ext": "4765",
 *             "created_at": "2015-10-21 13:29:11",
 *             "updated_at": "2015-10-21 13:29:11"
 *           },
 *           {
 *              "id": "2",
 *              "user": "1",
 *              "number": "15187032319",
 *              "ext": null,
 *              "created_at": "2015-10-21 13:29:11",
 *              "updated_at": "2015-10-21 13:29:11"
 *           },
 *           {
 *              "id": "3",
 *              "user": "2",
 *              "number": "15182442355",
 *              "ext": "2355",
 *              "created_at": "2015-10-21 13:29:11",
 *              "updated_at": "2015-10-21 13:29:11"
 *           },
 *           {
 *              "id": "4",
 *              "user": "3",
 *              "number": "15182444582",
 *              "ext": "4582",
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
 * @api {get} /phone/:limit Get: X amount
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Phone
 * @apiDescription This method returns objects up to the limit specified.
 * @apiParam {Integer} limit The max number of objects returned.
 *
 * @apiSampleRequest https://databridge.sage.edu/v1/phone/
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/phone/2/
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.get "https://databridge.sage.edu/v1/phone/2/",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/phone/2/");
 *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
 *      $result = curl_exec($ch);
 *      curl_close($ch);
 *
 * @apiExample {powershell} PowerShell
 *      # PowerShell v3 and above
 *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
 *      $headers.Add("X-Authorization", '<Your-API-Key>')
 *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/phone/2/ -Headers $headers
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/phone/2/")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.get("https://databridge.sage.edu/v1/phone/2/",
 *          headers={
 *              "X-Authorization": "<Your-API-Key>",
 *              "Accept": "application/json"
 *          }
 *      )
 *
 * @apiExample {.net} .NET
 *      // This code snippet uses an open-source library http://unirest.io/net
 *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/phone/2/")
 *       .header("X-Authorization", "<Your-API-Key>")
 *       .header("Accept", "application/json")
 *       .asString();
 *
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {Objects} result The objects that have been returned.
 * @apiSuccess {Integer} id The numeric id of the object.
 * @apiSuccess {Integer} user The API ID number assigned to a user associated with this number.
 * @apiSuccess {String} number The phone number.
 * @apiSuccess {String} ext The short extension for this phone number, can be null.
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
 *             "user": "1",
 *             "number": "15182445765",
 *             "ext": "4765",
 *             "created_at": "2015-10-21 13:29:11",
 *             "updated_at": "2015-10-21 13:29:11"
 *           },
 *           {
 *              "id": "2",
 *              "user": "1",
 *              "number": "15187032319",
 *              "ext": null,
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
 * @api {get} /phone/id/:id Get: by ID
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Phone
 * @apiDescription This method returns an object with the specified ID.
 * @apiParam {Integer} id The id of a specific object.
 *
 * @apiSampleRequest https://databridge.sage.edu/v1/phone/id/:id
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/phone/id/2/
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.get "https://databridge.sage.edu/v1/phone/id/2/",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/phone/id/2/");
 *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
 *      $result = curl_exec($ch);
 *      curl_close($ch);
 *
 * @apiExample {powershell} PowerShell
 *      # PowerShell v3 and above
 *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
 *      $headers.Add("X-Authorization", '<Your-API-Key>')
 *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/phone/id/2/ -Headers $headers
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/phone/id/2/")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.get("https://databridge.sage.edu/v1/phone/id/2/",
 *          headers={
 *              "X-Authorization": "<Your-API-Key>",
 *              "Accept": "application/json"
 *          }
 *      )
 *
 * @apiExample {.net} .NET
 *      // This code snippet uses an open-source library http://unirest.io/net
 *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/phone/id/2/")
 *       .header("X-Authorization", "<Your-API-Key>")
 *       .header("Accept", "application/json")
 *       .asString();
 *
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {Object} result The object that has been returned.
 * @apiSuccess {Integer} id The numeric id of the object.
 * @apiSuccess {Integer} user The API ID number assigned to a user associated with this number.
 * @apiSuccess {String} number The phone number.
 * @apiSuccess {String} ext The short extension for this phone number, can be null.
 * @apiSuccess {Timestamp} created_at The date and time that the object was created.
 * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
 *
 * @apiSuccessExample {json} Success: Objects
 *     HTTP/1.1 200 OK
 *     {
 *         "success": true,
 *         "result":
 *          {
 *             "id": "1",
 *             "user": "1",
 *             "number": "15182445765",
 *             "ext": "4765",
 *             "created_at": "2015-10-21 13:29:11",
 *             "updated_at": "2015-10-21 13:29:11"
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
 * @api {post} /phone/ Post: Create or Update
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Phone
 * @apiDescription An application can create new phone record or update existing records.
 * If the Informer code does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry.
 * If the Informer code does exist in the database, the data sent in the POST request will replace the data in that record.
 *
 * @apiParam {Integer} user The API ID number assigned to a user associated with this number..
 * @apiParam {String} number The phone number.
 * @apiParam {String} ext The short extension for this phone number, can be null.
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user=1" \
 *      --data "number=15182445765" \
 *      --data "code=HUM" \
 *      --url https://databridge.sage.edu/v1/phone
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.post "https://databridge.sage.edu/v1/phone",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
 *      parameters:{ :user => 1, :number => "15182445765", :ext => "4765"}.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/phone");
 *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
 *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *      curl_setopt($ch, CURLOPT_POST, true);
 *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("user" => 1, "number" => "15182445765", "ext" => "4765"));
 *      $result = curl_exec($ch);
 *      curl_close($ch);
 *
 * @apiExample {powershell} PowerShell
 *      # PowerShell v3 and above
 *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
 *      $headers.Add("X-Authorization", '<Your-API-Key>')
 *      $uri = https://databridge.sage.edu/v1/phone
 *      $body = @{ user = 1, number = "15182445765", ext = "4765" }
 *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.post("https://databridge.sage.edu/v1/phone")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .body("{\"user\":1, \"number\":\"15182445765\", \"ext\":\"4765\"}")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.post("https://databridge.sage.edu/v1/phone",
 *          headers={
 *              "X-Authorization": "<Your-API-Key>",
 *              "Accept": "application/json"
 *          },
 *          params={
 *              "user" : 1,
 *              "number": "15182445765",
 *              "ext": "4765"
 *          }
 *      )
 *
 * @apiExample {.net} .NET
 *      // This code snippet uses an open-source library http://unirest.io/net
 *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/phone")
 *       .header("X-Authorization", "<Your-API-Key>")
 *       .header("Accept", "application/json")
 *       .field("user", 1)
 *       .field("number", "15182445765")
 *       .field("ext", "4765")
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
 * @api {delete} /phone/ Delete: by ID
 * @apiVersion 1.1.1
 * @apiHeader {String} X-Authorization The application's unique access-key.
 * @apiGroup Phone
 * @apiDescription Delete a phone record.
 *
 * @apiParam {Integer} id The numeric API id of the phone.
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {String} result The action that was performed, this should be `delete`.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "id=1" \
 *      --url https://databridge.sage.edu/v1/phone
 *
 * @apiExample {ruby} Ruby
 *      # This code snippet uses an open-source library. http://unirest.io/ruby
 *      response = Unirest.delete "https://databridge.sage.edu/v1/phone",
 *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
 *      parameters:{ :id => 1}.to_json
 *
 * @apiExample {php} PHP
 *      $ch = curl_init("https://databridge.sage.edu/v1/phone");
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
 *      $uri = https://databridge.sage.edu/v1/phone
 *      $body = @{ id = 1 }
 *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Delete -Body $body
 *
 * @apiExample {java} Java
 *      # This code snippet uses an open-source library. http://unirest.io/java
 *      HttpResponse <String> response = Unirest.delete("https://databridge.sage.edu/v1/phone")
 *      .header("X-Authorization", "<Your-API-Key>")
 *      .header("Accept", "application/json")
 *      .body("{\"id\":1}")
 *      .asString();
 *
 * @apiExample {python} Python
 *      # This code snippet uses an open-source library http://unirest.io/python
 *      response = unirest.delete("https://databridge.sage.edu/v1/phone",
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
 *       Task<HttpResponse<MyClass>> response = Unirest.delete("https://databridge.sage.edu/v1/phone")
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