<?php
/**
 * @apiDefine get
 * Grants access to GET requests on the object.
 */
/**
 * @apiDefine post
 * Grants access to POST requests on the object.
 */
/**
 * @apiDefine delete
 * Grants access to DELETE requests on the object.
 */
/**
 * @apiDefine ApiErrorFields
 * @apiError (Error: 4xx) {Boolean} success Tells the application if the request was successful.
 * @apiError (Error: 4xx) {Integer} status_code The HTTP status code of the request, this is also available in the header.
 * @apiError (Error: 4xx) {String[]} error An array containing a descriptions of each error.
 * @apiError (Error: 5xx) {Boolean} success Tells the application if the request was successful.
 * @apiError (Error: 5xx) {Integer} status_code The HTTP status code of the request, this is also available in the header.
 * @apiError (Error: 5xx) {String[]} error An array containing a descriptions of each error.
 */
/**
 * @apiDefine ApiSuccessFields
 * @apiSuccess (Success: 2xx) {Boolean} success Tells the application if the request was successful.
 * @apiSuccess (Success: 2xx) {Integer} status_code The HTTP status code of the request, this is also available in the header.
 * @apiSuccess (Success: 2xx) {Object_Or_Null} pagination A key to reference for paginated results, this may be null if only a single object has been returned.
 * @apiSuccess (Success: 2xx) {Object[]_Or_Object} result An array of objects or a single object.
 */
/**
 * @apiDefine ApiSuccessExampleDestroy
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": "Object Destroyed"
 *      }
 */
/**
 * @apiDefine AuthorizationHeader
 * @apiHeader {String} X-Authorization The application's unique access-key.
 */
/**
 * @apiError (Authorization Error: 4xx) {String} MissingHeaderOption The `X-Authorization` header option was not supplied to the API.
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "status_code": 400,
 *          "error": [
 *              "X-Authorization: Header Option Not Found."
 *          ]
 *      }
 * @apiError (Authorization Error: 4xx) {String} NotPrivileged The key supplied is not authorized to perform the requested operation.
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "status_code": 403,
 *          "error": [
 *              "X-Authorization: Insufficient privileges."
 *          ]
 *      }
 * @apiError (Authorization Error: 4xx) {String} InvalidApiKey The key that has been supplied to the API is not valid.
 * @apiErrorExample {json} Error: Invalid API Key
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "status_code": 403,
 *          "error": [
 *              "X-Authorization: API Key is not valid."
 *          ]
 *      }
 */
/**
 * @apiDefine PaginationParams
 * @apiParam {Integer} [limit=100] The max number of objects returned. The max that will be honored by the api is 1500.
 * @apiParam {Integer} [page=1] The page of results to return.
 */
/**
 * @apiDefine PaginatedSuccess
 * @apiSuccess (Pagination) {Integer} total_pages The total number of pages available.
 * @apiSuccess (Pagination) {Integer} current_page The currently selected page.
 * @apiSuccess (Pagination) {Integer} result_limit The max amount of results returned per request.
 * @apiSuccess (Pagination) {String} next_page The next page available in url form.
 * @apiSuccess (Pagination) {String} previous_page The previous page in url form.
 */
/**
 * @apiDefine UnprocessableEntityErrors
 * @apiError (Model Error: 4xx) {String} UnprocessableEntity The API unable to complete the request. This is generally caused by a violation of various constraints, such as maximum characters or missing a required data field.
 * @apiErrorExample {json} Error: Unprocessable Entity
 *      HTTP/1.1 422 Unprocessable Entity
 *      {
 *          "success": false,
 *          "status_code": 422,
 *          "error": [
 *              "The <Field Name> field is required.",
 *              "The <Field Name> must be at least <Minimum Number> characters.",
 *              "The <Field Name> may not be greater than <Maximum Number> characters."
 *          ]
 *      }
 */
/**
 * @apiDefine InternalServerErrors
 * @apiError (Model Error: 5xx) {String} InternalServerError There is a server side issue, there may or may not be an issue with your request.
 * @apiErrorExample {json} Error: Internal Server Error
 *      HTTP/1.1 500 Internal Server Error
 *      {
 *          "success": false,
 *          "status_code": 500,
 *          "error": [
 *              "There is an issue with the current LDAP configuration."
 *          ]
 *      }
 */
/**
 * @apiDefine CreateSuccessResultExample
 * @apiSuccessExample {json} Success Create:
 *      HTTP/1.1 201 Created
 *      {
 *          "success": true,
 *          "status_code": 201,
 *          "pagination": [],
 *          "result": {
 *              "message": "Created",
 *              "id": <ID of the new object.>
 *          }
 *      }
 */
/**
 * @apiDefine UpdateSuccessResultExample
 * @apiSuccessExample {json} Success Update:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Updated",
 *              "id": <ID of the object that was updated.>
 *          }
 *      }
 */
/**
 * @apiDefine ModelNotFoundError
 * @apiError (Model Error: 4xx) {String} ModelNotFound The API was unable to find the requested model or the model type.
 * @apiErrorExample {json} Error: Not Found
 *      HTTP/1.1 404 Not Found
 *      {
 *          "success": false,
 *          "status_code": 404,
 *          "error": [
 *              "No query results for model <Model Name>"
 *          ]
 *      }
 */

namespace App\Http\Controllers;

use App\Model\Apikey;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var bool
     */
    protected $successStatus = true;

    /**
     * @var int
     */
    protected $limit = 100;


    /**
     * @var int
     */
    protected $max_limit = 1500;

    /**
     * @param $amount
     * @return $this
     */
    public function limit($amount)
    {
        $this->limit = is_null($amount) ? $this->limit : $amount;
        $this->limit = $this->limit > $this->max_limit ? $this->max_limit : $this->limit;
        return $this;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function max_limit($amount)
    {
        $this->max_limit = $amount;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getSuccessStatus()
    {
        return $this->successStatus;
    }

    /**
     * @param $successStatus
     * @return $this
     */
    public function setSuccessStatus($successStatus)
    {
        $this->successStatus = $successStatus;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $this->limit(Input::get('limit'));
    }

    /**
     * @param Request $request
     * @param $method
     * @return mixed
     */
    public function isAuthorized(Request $request, $type)
    {
        $key = Apikey::testAPIKey($request, $type);
        return $key[0];
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotAuthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondUnprocessableEntity($message = 'Unprocessable Entity')
    {
        return $this->setStatusCode(422)->respondWithError($message);
    }

    /**
     * @param string $message
     * @param int $id
     * @param null $verification_code
     * @return mixed
     */
    public function respondCreateSuccess($message = 'Created', $id = 0, $verification_code = null)
    {
        return $this->setStatusCode(201)->respondWithSuccess(['message' => $message, 'id' => intval($id), 'verification_code' => $verification_code]);
    }

    /**
     * @param string $message
     * @param int $id
     * @param string $type
     * @param null $verification_code
     * @return mixed
     */
    public function respondVerifySuccess($message = 'Verified', $id = 0, $type = '', $item = null, $verification_code = null)
    {
        return $this->setStatusCode(200)->respondWithSuccess(['message' => $message, 'id' => intval($id), 'type' => $type, 'verification_code' => $verification_code, 'item' => $item]);
    }

    /**
     * @param string $message
     * @param int $id
     * @param null $verification_code
     * @return mixed
     */
    public function respondUpdateSuccess($message = 'Updated', $id = 0, $verification_code = null)
    {
        return $this->setStatusCode(200)->respondWithSuccess(['message' => $message, 'id' => intval($id), 'verification_code' => $verification_code]);
    }

    /**
     * @param string $message
     * @param array $id
     * @return mixed
     */
    public function respondAssignmentSuccess($message = 'Assigned', $id = [])
    {
        return $this->setStatusCode(200)->respondWithSuccess(['message' => $message, 'id' => $id]);
    }

    /**
     * @param int $id
     * @param bool $recently
     * @param null $verification_code
     * @return mixed
     */
    public function respondCreateUpdateSuccess($id = 0, $recently = true, $verification_code = null)
    {
        if ($recently) {
            return $this->respondCreateSuccess('Created', $id, $verification_code);
        } else {
            return $this->respondUpdateSuccess('Updated', $id, $verification_code);
        }
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondDestroySuccess($message = 'Object Destroyed')
    {
        return $this->respondWithSuccess($message);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function respondWithError($message = 'An Error Has Occurred')
    {
        $this->setSuccessStatus(false);

        if (!is_array($message)) $message = [$message];

        return $this->respond([
            'success' => $this->getSuccessStatus(),
            'status_code' => $this->getStatusCode(),
            'error' => $message
        ]);
    }

    /**
     * @param Request $request
     * @param $limit
     * @param $result
     * @param $data
     * @return mixed
     */
    public function respondSuccessWithPagination(Request $request, LengthAwarePaginator $result, $data)
    {
        $next = $request->path();
        $next = $next . '?limit=' . $result->perPage() . '&page=' . strval(((int)$result->currentPage() + 1));
        $next = ((int)$result->currentPage() + 1) >= (int)$result->lastPage() ? null : $next;

        $previous = $request->path();
        $previous = $previous . '?limit=' . $result->perPage() . '&page=' . strval(((int)$result->currentPage() - 1));
        $previous = ((int)$result->currentPage() - 1) > 0 ? $previous : null;

        $paginator = [
            'total_pages' => $result->lastPage(),
            'current_page' => $result->currentPage(),
            'result_limit' => intval($result->perPage()),
            'next_page' => $next,
            'previous_page' => $previous
        ];

        return $this->respondWithSuccess($data, $paginator);
    }

    /**
     * @param $data
     * @param array $paginator
     * @return mixed
     */
    public function respondWithSuccess($data, $paginator = [])
    {
        return $this->respond([
            'success' => $this->getSuccessStatus(),
            'status_code' => $this->getStatusCode(),
            'pagination' => $paginator,
            'result' => $data
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }


}
