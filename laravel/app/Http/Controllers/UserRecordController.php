<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/24/15
 * Time: 1:25 PM
 */

use App\Model\Record\Email;
use App\Model\Record\Phone;
use App\Model\Record\Room;
use App\Model\Record\User;
use App\Model\Record\APIKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class UserRecordController extends BaseController
{

    /**
     * @api {get} /user/ Get: All
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup User
     * @apiDescription This method returns all user objects.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/user/
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/user/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/user/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/user/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/user/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/user/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/user/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Objects} result The objects that have been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {String} sageid The sageid assigned to the user.
     * @apiSuccess {Boolean} active Boolean value that signifies if a user is active.
     * @apiSuccess {String} name_prefix A prefix for the user's name.
     * @apiSuccess {String} name_first The user's first name.
     * @apiSuccess {String} name_middle The user's middle name or middle initial.
     * @apiSuccess {String} name_last The user's last name.
     * @apiSuccess {String} name_phonetic The user's phonetic name.
     * @apiSuccess {String} username The username assigned to the user.
     * @apiSuccess {Timestamp} created_at The date and time that the object was created.
     * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
     *
     * @apiSuccessExample {json} Success: Objects
     *     HTTP/1.1 200 OK
     *     {
     *         "success": true,
     *         "result": [
     *           {
     *               "id": "1",
     *               "sageid": "970620",
     *               "active": "1",
     *               "name_prefix": "Mr.",
     *               "name_first": "Alex",
     *               "name_middle": "L",
     *               "name_last": "Markessinis",
     *               "name_phonetic": null,
     *               "username": "markea",
     *               "created_at": "2015-10-21 13:29:11",
     *               "updated_at": "2015-10-21 13:29:11",
     *           },
     *           {
     *               "id": "2",
     *               "sageid": "970621",
     *               "active": "1",
     *               "name_prefix": "Mr.",
     *               "name_first": "Adam",
     *               "name_middle": null,
     *               "name_last": "Starnes",
     *               "name_phonetic": null,
     *               "username": "starna",
     *               "created_at": "2015-10-21 13:29:11",
     *               "updated_at": "2015-10-21 13:29:11",
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
     * @api {get} /user/:limit Get: X amount
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup User
     * @apiDescription This method returns objects up to the limit specified.
     * @apiParam {Integer} limit The max number of objects returned.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/user/
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/user/2/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/user/2/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user/2/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/user/2/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/user/2/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/user/2/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/user/2/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Objects} result The objects that have been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {String} sageid The sageid assigned to the user.
     * @apiSuccess {Boolean} active Boolean value that signifies if a user is active.
     * @apiSuccess {String} name_prefix A prefix for the user's name.
     * @apiSuccess {String} name_first The user's first name.
     * @apiSuccess {String} name_middle The user's middle name or middle initial.
     * @apiSuccess {String} name_last The user's last name.
     * @apiSuccess {String} name_phonetic The user's phonetic name.
     * @apiSuccess {String} username The username assigned to the user.
     * @apiSuccess {Timestamp} created_at The date and time that the object was created.
     * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
     *
     * @apiSuccessExample {json} Success: Objects
     *     HTTP/1.1 200 OK
     *     {
     *         "success": true,
     *         "result": [
     *           {
     *               "id": "1",
     *               "sageid": "970620",
     *               "active": "1",
     *               "name_prefix": "Mr.",
     *               "name_first": "Alex",
     *               "name_middle": "L",
     *               "name_last": "Markessinis",
     *               "name_phonetic": null,
     *               "username": "markea",
     *               "created_at": "2015-10-21 13:29:11",
     *               "updated_at": "2015-10-21 13:29:11",
     *           },
     *           {
     *               "id": "2",
     *               "sageid": "970621",
     *               "active": "1",
     *               "name_prefix": "Mr.",
     *               "name_first": "Adam",
     *               "name_middle": null,
     *               "name_last": "Starnes",
     *               "name_phonetic": null,
     *               "username": "starna",
     *               "created_at": "2015-10-21 13:29:11",
     *               "updated_at": "2015-10-21 13:29:11",
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
            return $limit > 0 ? json_encode(array("success" => true, 'result' => User::all()->take($limit))) : json_encode(array("success" => true, 'result' => User::all()));
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @api {get} /user/id/:id Get: by ID
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup User
     * @apiDescription This method returns an object with a specified id.
     * @apiParam {Integer} id The id assigned to the target user.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/user/id/:id
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/user/id/1/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/user/id/1/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user/id/1/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/user/id/1/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/user/id/1/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/user/id/1/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/user/id/1/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The object that has been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {String} sageid The sageid assigned to the user.
     * @apiSuccess {Boolean} active Boolean value that signifies if a user is active.
     * @apiSuccess {String} name_prefix A prefix for the user's name.
     * @apiSuccess {String} name_first The user's first name.
     * @apiSuccess {String} name_middle The user's middle name or middle initial.
     * @apiSuccess {String} name_last The user's last name.
     * @apiSuccess {String} name_phonetic The user's phonetic name.
     * @apiSuccess {String} username The username assigned to the user.
     * @apiSuccess {Timestamp} created_at The date and time that the object was created.
     * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
     * @apiSuccess {Array} email An array of emails associated with the user.
     * @apiSuccess {Array} phone An array of phone records associated with the user.
     * @apiSuccess {Array} room An array of rooms associated with the user.
     * @apiSuccess {Array} program An array of programs associated with the user.
     * @apiSuccess {Array} role An array of roles associated with the user.
     *
     * @apiSuccessExample {json} Success: Objects
     *     HTTP/1.1 200 OK
     *     {
     *         "success": true,
     *         "result":
     *             {
     *               "id": "1",
     *               "sageid": "970620",
     *               "active": "1",
     *               "name_prefix": "Mr.",
     *               "name_first": "Alex",
     *               "name_middle": "L",
     *               "name_last": "Markessinis",
     *               "name_phonetic": null,
     *               "username": "markea",
     *               "created_at": "2015-10-21 13:29:11",
     *               "updated_at": "2015-10-21 13:29:11",
     *               "email": [
     *                  {
     *                      "email": "markea@sage.edu"
     *                  },
     *                  {
     *                      "email": "markea@gmail.com"
     *                  },
     *                  {
     *                      "email": "markea@yahoo.com"
     *                  }
     *               ],
     *               "phone": [
     *                  {
     *                      "number": "15182445765",
     *                      "ext": "4765"
     *                  },
     *                  {
     *                      "number": "15187032319",
     *                      "ext": null
     *                  }
     *               ],
     *               "room": [
     *                  {
     *                      "building": "17",
     *                      "floor_number": "0",
     *                      "floor_name": "Basement",
     *                      "room_number": "1",
     *                      "room_name": "Network Office"
     *                      }
     *                  ]
     *               }
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
            $obj = User::where('id', $id)->get()->first();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                $obj->email = Email::where('user', $obj->id)->get();
                $obj->phone = Phone::where('user', $obj->id)->get();
                $obj->room = Room::where('user', $obj->id)->get();
                return json_encode($obj);
            } else {
                return json_encode(
                    array("success" => false, "message" => "NotFound"));
            }
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @api {get} /user/sageid/:sageid Get: by SageID
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup User
     * @apiDescription This method returns an object with a specified sageid.
     * @apiParam {String} sageid The sageid assigned to the target user.
     *
     * @apiSampleRequest https://databridge.sage.edu/v1/user/sageid/:sageid
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/v1/user/sageid/0970620/
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/user/sageid/0970620/",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" }.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user/sageid/0970620/");
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $result = Invoke-RestMethod -Uri https://databridge.sage.edu/v1/user/sageid/0970620/ -Headers $headers
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/user/sageid/0970620/")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.get("https://databridge.sage.edu/v1/user/sageid/0970620/",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.get("https://databridge.sage.edu/v1/user/sageid/0970620/")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .asString();
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Object} result The object that has been returned.
     * @apiSuccess {Integer} id The numeric id of the object.
     * @apiSuccess {String} sageid The sageid assigned to the user.
     * @apiSuccess {Boolean} active Boolean value that signifies if a user is active.
     * @apiSuccess {String} name_prefix A prefix for the user's name.
     * @apiSuccess {String} name_first The user's first name.
     * @apiSuccess {String} name_middle The user's middle name or middle initial.
     * @apiSuccess {String} name_last The user's last name.
     * @apiSuccess {String} name_phonetic The user's phonetic name.
     * @apiSuccess {String} username The username assigned to the user.
     * @apiSuccess {Timestamp} created_at The date and time that the object was created.
     * @apiSuccess {Timestamp} updated_at The date and time that the object was updated.
     * @apiSuccess {Array} email An array of emails associated with the user.
     * @apiSuccess {Array} phone An array of phone records associated with the user.
     * @apiSuccess {Array} room An array of rooms associated with the user.
     * @apiSuccess {Array} program An array of programs associated with the user.
     * @apiSuccess {Array} role An array of roles associated with the user.
     * @apiSuccessExample {json} Success: Objects
     *     HTTP/1.1 200 OK
     *     {
     *         "success": true,
     *         "result":
     *             {
     *               "id": "1",
     *               "sageid": "970620",
     *               "active": "1",
     *               "name_prefix": "Mr.",
     *               "name_first": "Alex",
     *               "name_middle": "L",
     *               "name_last": "Markessinis",
     *               "name_phonetic": null,
     *               "username": "markea",
     *               "created_at": "2015-10-21 13:29:11",
     *               "updated_at": "2015-10-21 13:29:11",
     *               "email": [
     *                  {
     *                      "email": "markea@sage.edu"
     *                  },
     *                  {
     *                      "email": "markea@gmail.com"
     *                  },
     *                  {
     *                      "email": "markea@yahoo.com"
     *                  }
     *               ],
     *               "phone": [
     *                  {
     *                      "number": "15182445765",
     *                      "ext": "4765"
     *                  },
     *                  {
     *                      "number": "15187032319",
     *                      "ext": null
     *                  }
     *               ],
     *               "room": [
     *                  {
     *                      "building": "17",
     *                      "floor_number": "0",
     *                      "floor_name": "Basement",
     *                      "room_number": "1",
     *                      "room_name": "Network Office"
     *                      }
     *                  ]
     *               }
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
     * @param $sageid
     * @return string
     */
    public function getBySageID(Request $request, $sageid)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {

            $obj = User::where('sageid', $sageid)->get()->first();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                $obj->email = Email::where('user', $obj->id)->get();
                $obj->phone = Phone::where('user', $obj->id)->get();
                $obj->room = Room::where('user', $obj->id)->get();
                return json_encode($obj);
            } else {
                return json_encode(array("success" => false, "message" => "NotFound"));
            }
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @api {post} /user/ Post: Create or Update
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup User
     * @apiDescription An application can create new user record or update existing records.
     * If the Informer code does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry.
     * If the Informer code does exist in the database, the data sent in the POST request will replace the data in that record.
     *
     * @apiParam {String} sageid The user's Sage ID number.
     * @apiParam {Boolean} active A boolean that signifies that activity state of the user.
     * @apiParam {String} name_prefix A prefix for the user's name(Optional).
     * @apiParam {String} name_first The user's first name.
     * @apiParam {String} name_middle The user's middle name or initial(Optional).
     * @apiParam {String} name_last The user's last name.
     * @apiParam {String} name_phonetic A phonetic name for the user(Optional).
     * @apiParam {String} username The username assigned to the user.
     *
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
     *
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "POST" \
     *      --data "sageid=0979659" \
     *      --data "active=1" \
     *      --data "name_prefix=MR." \
     *      --data "name_first=Luke" \
     *      --data "name_last=Skywalker." \
     *      --data "username=skywal" \
     *      --url https://databridge.sage.edu/v1/user
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.post "https://databridge.sage.edu/v1/user",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
     *      parameters:{ :sageid => "0979659", :active => true, :name_prefix => "MR.", :name_first => "Luke", :name_last => "Skywalker", :username => "skywal"}.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_POST, true);
     *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("sageid" => "0979659", "active" => true, "name_prefix" => "MR.", "name_first" => "Luke", "name_last" => "Skywalker", "username" => "skywal"));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $uri = https://databridge.sage.edu/v1/user
     *      $body = @{ sageid = "0979659", active = $true, name_prefix = "MR.", name_first = "Luke", name_last = "Skywalker", username = "skywal" }
     *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.post("https://databridge.sage.edu/v1/user")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .body("{\"sageid\":\"0979659\", \"active\":1, \"name_prefix\":\"MR.\", \"name_first\":\"Luke\", \"name_last\":\"Skywalker\", \"username\":\"skywal\"}")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.post("https://databridge.sage.edu/v1/user",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          },
     *          params={
     *              "sageid" : "0979659",
     *              "active": true,
     *              "name_prefix": "MR.",
     *              "name_first": "Luke",
     *              "name_last": "Skywalker",
     *              "username": "skywal"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/user")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .field("sageid", "0979659")
     *       .field("active", true)
     *       .field("name_prefix", "MR.")
     *       .field("name_first", "Luke")
     *       .field("name_last", "Skywalker")
     *       .field("username", "skywal")
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
                'sageid' => 'integer|required|max:7|min:6|unique:users',
                'active' => 'boolean|required|max:5|min:1',
                'name_prefix' => 'string',
                'name_first' => 'string|required|min:1',
                'name_middle' => 'string',
                'name_last' => 'string|required|min:1',
                'name_phonetic' => 'string',
                'username' => 'string|required|max:11|min:3|unique:users'
            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'message' => $validator->errors()->all()));
            }
            if (User::where('sageid', $request->input('sageid'))->get()->first()) {
                if (User::where('sageid', $request->input('sageid'))->update($request->input())) {
                    return json_encode(array('success' => true, 'message' => 'update'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not update'));
                }
            } else {
                $model = new User();
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
     * @api {delete} /user/ Delete: by ID
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup User
     * @apiDescription Delete a user record. This also deletes any room, email, or phone records that are in that user.
     *
     * @apiParam {Integer} id The numeric API id of the user.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {String} result The action that was performed, this should be `delete`.
     *
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "DELETE" \
     *      --data "id=1" \
     *      --url https://databridge.sage.edu/v1/user
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.delete "https://databridge.sage.edu/v1/user",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
     *      parameters:{ :id => 1}.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/user");
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
     *      $uri = https://databridge.sage.edu/v1/user
     *      $body = @{ id = 1 }
     *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Delete -Body $body
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.delete("https://databridge.sage.edu/v1/user")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .body("{\"id\":1}")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.delete("https://databridge.sage.edu/v1/user",
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
     *       Task<HttpResponse<MyClass>> response = Unirest.delete("https://databridge.sage.edu/v1/user")
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
            if ($model = User::find($request->input('id'))) {
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
