<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 2:26 PM
 */

use App\Program;
use App\APIKey;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ProgramController extends BaseController
{

    /**
     * @api {get} /program/ Get all Programs
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Program
     * @apiDescription This method returns all program objects.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/program/
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/program/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/program/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/program/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/program/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/program/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/program/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/program/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Objects} result The objects that have been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {Integer} department The numeric id of the corresponding department.
     * @apiSuccess {String} code The code assigned to the program by Informer.
     * @apiSuccess {String} name The common name associated with the program.
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
     *              "department": "1",
     *              "code": "CE.NONMATRIC",
     *              "name": "CONTINUING EDUCATION NONMATRIC",
     *              "created_at": "2015-10-21 13:29:11",
     *              "updated_at": "2015-10-21 13:29:11"
     *           },
     *           {
     *              "id": "2",
     *              "department": "2",
     *              "code": "JCA.AA.INS",
     *              "name": "INDIVIDUAL STUDIES",
     *              "created_at": "2015-10-21 13:29:11",
     *              "updated_at": "2015-10-21 13:29:11"
     *           },
     *           {
     *              "id": "3",
     *              "department": "3",
     *              "code": "RSC.BA.AMS",
     *              "name": "AMERICAN STUDIES",
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
     * @api {get} /program/:limit Get X amount of Programs
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Program
     * @apiDescription This method returns objects up to the limit specified.
     * @apiParam {Integer} limit The max number of objects returned.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/program/
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/program/2/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/program/2/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/program/2/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/program/2/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/program/2/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/program/2/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/program/2/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Objects} result The objects that have been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {Integer} department The numeric id of the corresponding department.
     * @apiSuccess {String} code The code assigned to the program by Informer.
     * @apiSuccess {String} name The common name associated with the program.
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
     *              "department": "1",
     *              "code": "CE.NONMATRIC",
     *              "name": "CONTINUING EDUCATION NONMATRIC",
     *              "created_at": "2015-10-21 13:29:11",
     *              "updated_at": "2015-10-21 13:29:11"
     *           },
     *           {
     *              "id": "2",
     *              "department": "2",
     *              "code": "JCA.AA.INS",
     *              "name": "INDIVIDUAL STUDIES",
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
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(array("success" => true, 'result' => Program::all()->take($limit))) : json_encode(array("success" => true, 'result' => Program::all()));
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @api {get} /program/id/:id Get Program by ID
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Program
     * @apiDescription This method returns an object with the specified ID.
     * @apiParam {Integer} id The id of a specific object.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/program/id/:id
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/program/id/1/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/program/id/1/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/program/id/1/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/program/id/1/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/program/id/1/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/program/id/1/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/program/id/1/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The object that has been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {Integer} department The numeric id of the corresponding department.
     * @apiSuccess {String} code The code assigned to the program by Informer.
     * @apiSuccess {String} name The common name associated with the program.
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
     *              "department": "1",
     *              "code": "CE.NONMATRIC",
     *              "name": "CONTINUING EDUCATION NONMATRIC",
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
            $obj = Program::where('id', $id)->get();
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
     * @api {get} /program/code/:code Get Program by Informer Code
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Program
     * @apiDescription This method returns an object with the specified Informer Code.
     * @apiParam {String} code The code assigned to an object by Informer.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/program/code/:code
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/program/code/CE.NONMATRIC/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/program/code/CE.NONMATRIC/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/program/code/CE.NONMATRIC/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/program/code/CE.NONMATRIC/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/program/code/CE.NONMATRIC/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/program/code/CE.NONMATRIC/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/program/code/CE.NONMATRIC/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The object that has been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {Integer} department The numeric id of the corresponding department.
     * @apiSuccess {String} code The code assigned to the program by Informer.
     * @apiSuccess {String} name The common name associated with the program.
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
     *              "department": "1",
     *              "code": "CE.NONMATRIC",
     *              "name": "CONTINUING EDUCATION NONMATRIC",
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
            $obj = Program::where('code', $code)->get();
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
     * @api {get} /program/department/:department Get Programs by Department ID
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Program
     * @apiDescription This method returns objects with the specified Department ID.
     * @apiParam {Integer} department The ID of a Department.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/program/department/:department
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/program/department/1/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/program/department/1/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/program/department/1/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/program/department/1/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/program/department/1/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/program/department/1/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/program/department/1/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The object that has been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {Integer} department The numeric id of the corresponding department.
     * @apiSuccess {String} code The code assigned to the program by Informer.
     * @apiSuccess {String} name The common name associated with the program.
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
     *              "department": "1",
     *              "code": "CE.NONMATRIC",
     *              "name": "CONTINUING EDUCATION NONMATRIC",
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
     * @param $departmentId
     * @return string
     */
    public function getByDepartment(Request $request, $departmentId)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Program::where('department', $departmentId)->get();
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
     * @api {post} /program/ Post to Program
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Program
     * @apiDescription An application can create new program record or update existing records.
     * If the Informer code does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry.
     * If the Informer code does exist in the database, the data sent in the POST request will replace the data in that record.
     *
     * @apiParam {Integer} department The API ID assigned to a department that is associated with this program.
     * @apiParam {String} name The name of the program.
     * @apiParam {String} code The code assigned by Informer.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
     *
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "POST" \
     *      --data "department=1" \
     *      --data "name=CONTINUING EDUCATION NONMATRIC" \
     *      --data "code=CE.NONMATRIC" \
     *      --url https://databridge.sage.edu/v1/program
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.post "https://databridge.sage.edu/v1/program",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
     *      parameters:{ :department => true, :name => "CONTINUING EDUCATION NONMATRIC", :code => "CE.NONMATRIC"}.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/program");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_POST, true);
     *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("department" => 1, "name" => "CONTINUING EDUCATION NONMATRIC", "code" => "CE.NONMATRIC"));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $uri = https://databridge.sage.edu/v1/program
     *      $body = @{ department = 1, name = "CONTINUING EDUCATION NONMATRIC", code = "CE.NONMATRIC" }
     *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.post("https://databridge.sage.edu/v1/program")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .body("{\"department\":1, \"name\":\"CONTINUING EDUCATION NONMATRIC\", \"code\":\"CE.NONMATRIC\"}")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.post("https://databridge.sage.edu/v1/program",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          },
     *          params={
     *              "department" : 1,
     *              "name": "CONTINUING EDUCATION NONMATRIC",
     *              "code": "CE.NONMATRIC"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/program")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .field("department", 1)
     *       .field("name", "CONTINUING EDUCATION NONMATRIC")
     *       .field("code", "CE.NONMATRIC")
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
                'department' => 'integer|required|max:11|min:1',
                'code' => 'string|required|max:50|min:3|unique:programs',
                'name' => 'string|required|max:50|min:3|unique:programs',

            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'message' => $validator->errors()->all()));
            }
            if (Program::where('code', $request->input('code'))->get()->first()) {
                if (Program::where('code', $request->input('code'))->update($request->input())) {
                    return json_encode(array('success' => true, 'message' => 'update'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not update'));
                }
            } else {
                $model = new Program();
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