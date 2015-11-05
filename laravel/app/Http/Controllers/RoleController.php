<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 1:41 PM
 */

use App\Role;
use App\APIKey;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class RoleController extends BaseController
{

    /**
     * @api {get} /role/ Get: All
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Role
     * @apiDescription This method returns all role objects.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/role/
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/role/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/role/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/role/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/role/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/role/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/role/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/role/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Objects} result The objects have been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {String} code The code assigned to the role by Informer.
     * @apiSuccess {String} name The common name associated with the role.
     * @apiSuccess {Timestamp} created_at The date and time that the object was created.
     * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
     *
     * @apiSuccessExample {json} Success: Objects
     *     HTTP/1.1 200 OK
     *     {
     *         "success": true,
     *         "result": [
     *           {
     *              "id": "1",
     *              "code": "STUDENT",
     *              "name": "Student",
     *              "created_at": "2015-10-21 13:29:11",
     *              "updated_at": "2015-10-21 13:29:11"
     *           },
     *           {
     *              "id": "2",
     *              "code": "EMPLOYEE",
     *              "name": "Employee",
     *              "created_at": "2015-10-21 13:29:11",
     *              "updated_at": "2015-10-21 13:29:11"
     *           },
     *           {
     *              "id": "3",
     *              "code": "FACULTY",
     *              "name": "Faculty",
     *              "created_at": "2015-10-21 13:29:11",
     *              "updated_at": "2015-10-21 13:29:11"
     *           },
     *           {
     *              "id": "4",
     *              "code": "ADJUNCT",
     *              "name": "Adjunct",
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
     * @api {get} /role/:limit Get: X amount
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Role
     * @apiDescription This method returns objects up to the limit specified.
     * @apiParam {Integer} limit The max number of objects returned.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/role/
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/role/2/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/role/2/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/role/2/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/role/2/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/role/2/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/role/2/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/role/2/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Objects} result The objects have been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {String} code The code assigned to the role by Informer.
     * @apiSuccess {String} name The common name associated with the role.
     * @apiSuccess {Timestamp} created_at The date and time that the object was created.
     * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
     *
     * @apiSuccessExample {json} Success: Objects
     *     HTTP/1.1 200 OK
     *     {
     *         "success": true,
     *         "result": [
     *           {
     *              "id": "1",
     *              "code": "STUDENT",
     *              "name": "Student",
     *              "created_at": "2015-10-21 13:29:11",
     *              "updated_at": "2015-10-21 13:29:11"
     *           },
     *           {
     *              "id": "2",
     *              "code": "EMPLOYEE",
     *              "name": "Employee",
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
     * @param Request $request
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(array("success" => true, 'result' => Role::all()->take($limit))) : json_encode(array("success" => true, 'result' => Role::all()));
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @api {get} /role/id/:id Get: by ID
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Role
     * @apiDescription This method returns an object with the specified ID.
     * @apiParam {Integer} id The id of a specific object.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/role/id/:id
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/role/id/2/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/role/id/2/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/role/id/2/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/role/id/2/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/role/id/2/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/role/id/2/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/role/id/2/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The object that has been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {String} code The code assigned to the role by Informer.
     * @apiSuccess {String} name The common name associated with the role.
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
     *              "code": "EMPLOYEE",
     *              "name": "Employee",
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
     * @param Request $request
     * @param $id
     * @return string
     */
    public function getById(Request $request, $id)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Role::where('id', $id)->get();
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
     * @api {get} /role/code/:code Get: by Code
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Role
     * @apiDescription This method returns an object with the specified Informer Code.
     * @apiParam {String} code The code assigned to an object by Informer.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/role/code/:code
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/role/code/STUDENT/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/role/code/STUDENT/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/role/code/STUDENT/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/role/code/STUDENT/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/role/code/STUDENT/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/role/code/STUDENT/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/role/code/STUDENT/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The object that has been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {String} code The code assigned to the role by Informer.
     * @apiSuccess {String} name The common name associated with the role.
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
     *              "code": "STUDENT",
     *              "name": "Student",
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
     * @param Request $request
     * @param $code
     * @return string
     */
    public function getByCode(Request $request, $code)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Role::where('code', $code)->get();
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
     * @api {post} /role/ Post: Create or Update
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Role
     * @apiDescription An application can create new role record or update existing records.
     * If the Informer code does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry.
     * If the Informer code does exist in the database, the data sent in the POST request will replace the data in that record.
     *
     * @apiParam {String} name The name of the role.
     * @apiParam {String} code The code assigned by Informer.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
     *
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "POST" \
     *      --data "name=Student Worker" \
     *      --data "code=STUDENTWORKER" \
     *      --url https://databridge.sage.edu/v1/role
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.post "https://databridge.sage.edu/v1/role",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
     *      parameters:{ :name => "Student Worker", :code => "STUDENTWORKER"}.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/role");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_POST, true);
     *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("name" => "Student Worker", "code" => "STUDENTWORKER"));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $uri = https://databridge.sage.edu/v1/role
     *      $body = @{ name = "Student Worker", code = "STUDENTWORKER" }
     *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.post("https://databridge.sage.edu/v1/role")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .body("{\"name\":\"Student Worker\", \"code\":\"STUDENTWORKER\"}")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.post("https://databridge.sage.edu/v1/role",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          },
     *          params={
     *              "name": "Student Worker",
     *              "code": "STUDENTWORKER"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/role")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .field("name", "Student Worker")
     *       .field("code", "STUDENTWORKER")
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
                'code' => 'string|required|max:50|min:3|unique:programs',
                'name' => 'string|required|max:50|min:3|unique:programs',

            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'message' => $validator->errors()->all()));
            }
            if (Role::where('code', $request->input('code'))->get()->first()) {
                if (Role::where('code', $request->input('code'))->update($request->input())) {
                    return json_encode(array('success' => true, 'message' => 'update'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not update'));
                }
            } else {
                $model = new Role();
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

    /**
     * @api {delete} /role/ Delete: by ID
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Role
     * @apiDescription Delete a role record.
     *
     * @apiParam {Integer} id The numeric API id of the role.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {String} result The action that was performed, this should be `delete`.
     *
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "DELETE" \
     *      --data "id=1" \
     *      --url https://databridge.sage.edu/v1/role
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.delete "https://databridge.sage.edu/v1/role",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
     *      parameters:{ :id => 1}.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/role");
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
     *      $uri = https://databridge.sage.edu/v1/role
     *      $body = @{ id = 1 }
     *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Delete -Body $body
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.delete("https://databridge.sage.edu/v1/role")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .body("{\"id\":1}")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.delete("https://databridge.sage.edu/v1/role",
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
     *       Task<HttpResponse<MyClass>> response = Unirest.delete("https://databridge.sage.edu/v1/role")
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

    /**
     * @param Request $request
     * @return string
     */
    public function del(Request $request)
    {
        $result = APIKey::testAPIKey($request, 'delete');
        if ($result[0]) {
            $validator = Validator::make($request->all(), [
                'id' => 'integer|required',
            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'message' => $validator->errors()->all()));
            }
            if ($model = Role::find($request->input('id'))) {
                if ($model->delete()) {
                    return json_encode(array('success' => true, 'message' => 'delete'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not delete.'));
                }
            } else {
                return json_encode(array('success' => false, 'message' => 'Object not found.'));
            }
        } else {
            return json_encode($result[1]);
        }
    }

}