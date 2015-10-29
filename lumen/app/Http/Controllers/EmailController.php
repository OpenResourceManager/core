<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:46 PM
 */

use App\Email;
use App\APIKey;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class EmailController extends BaseController
{
    /**
     * @param Request $request
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(array("success" => true, 'result' => Email::all()->take($limit))) : json_encode(array("success" => true, 'result' => Email::all()));
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return string
     */
    public function getById(Request $request, $id)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Email::where('id', $id)->get();
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
     * @param Request $request
     * @param $id
     * @return string
     */
    public function getByUser(Request $request, $id)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Email::where('user', $id)->get();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                return json_encode($obj);
            } else {
                return json_encode(
                    array("success" => false, "error" => "NotFound"));
            }
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @api {post} /email/ Post to Email
     * @apiVersion 1.1.1
     * @apiHeader {String} X-Authorization The application's unique access-key.
     * @apiGroup Email
     * @apiDescription An application can create new email record or update existing records.
     * If the email does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry.
     * If the email does exist in the database, the data sent in the POST request will replace the data in that record.
     *
     * @apiParam {Integer} user The id of a user to associate the email with.
     * @apiParam {String} email The email for this record.
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {String} result The action that was performed. This may be `update` or `create`.
     *
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      --data "id=3" \
     *      --data "email=NFF" \
     *      --url https://databridge.sage.edu/v1/email
     *
     * @apiExample {ruby} Ruby
     *      # This code snippet uses an open-source library. http://unirest.io/ruby
     *      response = Unirest.get "https://databridge.sage.edu/v1/email",
     *      headers:{ "X-Authorization" => "<Your-API-Key>", "Accept" => "application/json" },
     *      parameters:{ :id => 3, :email => "NFF"}.to_json
     *
     * @apiExample {php} PHP
     *      $ch = curl_init("https://databridge.sage.edu/v1/email");
     *      curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));
     *      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     *      curl_setopt($ch, CURLOPT_POST, true);
     *      curl_setopt($ch, CURLOPT_POSTFIELDS, array("id" => 3, "email" => "NFF"));
     *      $result = curl_exec($ch);
     *      curl_close($ch);
     *
     * @apiExample {powershell} PowerShell
     *      # PowerShell v3 and above
     *      $headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
     *      $headers.Add("X-Authorization", '<Your-API-Key>')
     *      $uri = https://databridge.sage.edu/v1/email
     *      $body = @{ id = "3", email = "NFF" }
     *      $result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body
     *
     * @apiExample {java} Java
     *      # This code snippet uses an open-source library. http://unirest.io/java
     *      HttpResponse <String> response = Unirest.get("https://databridge.sage.edu/v1/email")
     *      .header("X-Authorization", "<Your-API-Key>")
     *      .header("Accept", "application/json")
     *      .body("{ \"id\":\"3\", \"email\":\"NFF\"}")
     *      .asString();
     *
     * @apiExample {python} Python
     *      # This code snippet uses an open-source library http://unirest.io/python
     *      response = unirest.post("https://databridge.sage.edu/v1/email",
     *          headers={
     *              "X-Authorization": "<Your-API-Key>",
     *              "Accept": "application/json"
     *          },
     *          params={
     *              "id": 3,
     *              "email": "NFF"
     *          }
     *      )
     *
     * @apiExample {.net} .NET
     *      // This code snippet uses an open-source library http://unirest.io/net
     *       Task<HttpResponse<MyClass>> response = Unirest.post("https://databridge.sage.edu/v1/email")
     *       .header("X-Authorization", "<Your-API-Key>")
     *       .header("Accept", "application/json")
     *       .field("id", "3")
     *       .field("email", "NFF")
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
                'user' => 'integer|required|max:11|min:1',
                'email' => 'email|required|max:60|min:7|unique:emails',
            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'message' => $validator->errors()->all()));
            }
            if (Email::where('email', $request->input('email'))->get()->first()) {
                if (Email::where('email', $request->input('email'))->update($request->input())) {
                    return json_encode(array('success' => true, 'message' => 'update'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not update'));
                }
            } else {
                $model = new Email();
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