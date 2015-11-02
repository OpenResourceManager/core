<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 1:42 PM
 */

use App\Campus;
use App\APIKey;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class CampusController extends BaseController
{
    /**
     * @api {get} /campus/ Get all Campuses
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Campus
     * @apiDescription This method returns all campus objects.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/campus/
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/campus/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/campus/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/campus/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/campus/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/campus/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/campus/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/campus/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Objects} result The objects that have been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {String} code The code assigned to the campus by Informer.
     * @apiSuccess {String} name The common name associated with the campus.
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
     *             "code": "TRY",
     *             "name": "Russell Sage College",
     *             "created_at": "2015-10-21 13:29:11",
     *             "updated_at": "2015-10-21 13:29:11"
     *           },
     *           {
     *              "id": "2",
     *              "code": "ALB",
     *               "name": "Sage College of Albany",
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
     * @api {get} /campus/:limit Get X amount of Campuses
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Campus
     * @apiDescription This method returns objects up to the limit specified.
     * @apiParam {Integer} limit The max number of objects returned.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/campus/
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/campus/1/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/campus/1/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/campus/1/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/campus/1/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/campus/1/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/campus/1/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/campus/1/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Objects} result The objects that have been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {String} code The code assigned to the campus by Informer.
     * @apiSuccess {String} name The common name associated with the campus.
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
     *             "code": "TRY",
     *             "name": "Russell Sage College",
     *             "created_at": "2015-10-21 13:29:11",
     *             "updated_at": "2015-10-21 13:29:11"
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
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(array("success" => true, 'result' => Campus::all()->take($limit))) : json_encode(array("success" => true, 'result' => Campus::all()));
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @api {get} /campus/id/:id Get Campus by ID
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Campus
     * @apiDescription This method returns an object with the specified ID.
     * @apiParam {Integer} id The id of a specific object.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/campus/id/:id
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/campus/id/2/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/campus/id/2/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/campus/id/2/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/campus/id/2/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/campus/id/2/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/campus/id/2/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/campus/id/2/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The object that has been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {Integer} campus The numeric id of the corresponding campus.
     * @apiSuccess {String} code The code assigned to the campus by Informer.
     * @apiSuccess {String} name The common name associated with the campus.
     * @apiSuccess {Timestamp} created_at The date and time that the object was created.
     * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
     *
     * @apiSuccessExample {json} Success: Objects
     *     HTTP/1.1 200 OK
     *     {
     *         "success": true,
     *         "result":
     *           {
     *              "id": "2",
     *              "code": "ALB",
     *              "name": "Sage College of Albany",
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
     * @param $id
     * @return string
     */
    public function getById(Request $request, $id)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Campus::where('id', $id)->get();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                return json_encode($obj);
            } else {
                return json_encode(array("success" => false, "error" => "NotFound"));
            }
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @api {get} /campus/code/:code Get Campus by Informer Code
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Campus
     * @apiDescription This method returns an object with the specified Informer Code.
     * @apiParam {String} code The Informer code of a specific object.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/campus/code/:code
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/campus/code/TRY/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/campus/code/TRY/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/campus/code/TRY/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/campus/code/TRY/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/campus/code/TRY/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/campus/code/TRY/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/campus/code/TRY/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The object that has been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {Integer} campus The numeric id of the corresponding campus.
     * @apiSuccess {String} code The code assigned to the campus by Informer.
     * @apiSuccess {String} name The common name associated with the campus.
     * @apiSuccess {Timestamp} created_at The date and time that the object was created.
     * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
     *
     * @apiSuccessExample {json} Success: Objects
     *     HTTP/1.1 200 OK
     *     {
     *         "success": true,
     *         "result":
     *           {
     *              "id": "1",
     *              "code": "TRY",
     *              "name": "Russell Sage College",
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
     * @param $code
     * @return string
     */
    public function getByCode(Request $request, $code)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Campus::where('code', $code)->get();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                return json_encode($obj);
            } else {
                return json_encode(array("success" => false, "error" => "NotFound"));
            }
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @api {post} /campus/ Post to Campus
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Campus
     * @apiDescription An application can create new campus record or update existing records.
     * If the Informer code does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry.
     * If the Informer code does exist in the database, the data sent in the POST request will replace the data in that record.
     *
     * @apiParam {String} name The name of the campus.
     * @apiParam {String} code The code assigned by Informer.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
     *
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "POST" \
     *      --data "name=Neff Center" \
     *      --data "code=NFF" \
     *      --url https://databridge.sage.edu/v1/campus
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.post "https://databridge.sage.edu/v1/campus",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
     *      parameters:{ :name => "Neff Center", :code => "NFF"}.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/campus");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_POST, true);
     *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("name" => "Neff Center", "code" => "NFF"));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $uri = https://databridge.sage.edu/v1/campus
     *      $body = @{ campus = 1, name = "Neff Center", code = "NFF" }
     *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.post("https://databridge.sage.edu/v1/campus")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .body("{\"campus\":1, \"name\":\"Neff Center\", \"code\":\"NFF\"}")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.post("https://databridge.sage.edu/v1/campus",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          },
     *          params={
     *              "name": "Neff Center",
     *              "code": "NFF"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/campus")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .field("name", "Neff Center")
     *       .field("code", "NFF")
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
     * @param Request $request
     * @return string
     */
    public function post(Request $request)
    {
        $result = APIKey::testAPIKey($request, 'post');
        if ($result[0]) {
            $validator = Validator::make($request->all(), [
                'code' => 'string|required|max:10|min:3|unique:campuses',
                'name' => 'string|required|max:30|min:3'
            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'message' => $validator->errors()->all()));
            }
            if (Campus::where('code', $request->input('code'))->get()->first()) {
                if (Campus::where('code', $request->input('code'))->update($request->input())) {
                    return json_encode(array('success' => true, 'message' => 'update'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not update'));
                }
            } else {
                $model = new Campus();
                foreach ($request->input() as $key => $value) {
                    $model->$key = $value;
                }
                $save = $model->save() ? true : false;
                return json_encode(array('success' => $save, 'message' => $save ? 'create' : $model->errors()->all()));
            }
        } else {
            return json_encode($result[1]);
        }
    }
}