<?php

/**
 * @apiDefine BirthDateParameters
 * @apiParam (BirthDate Parameters) {Integer} user_id The user that this password belongs to.
 * @apiParam (BirthDate Parameters) {Date} birth_date The user's birth date. In strtotime format: (https://secure.php.net/manual/en/function.strtotime.php).
 */
/**
 * @apiDefine BirthDateSuccess
 * @apiSuccess (Success 2xx: BirthDate) {Integer} id The numeric id assigned to the password by the database.
 * @apiSuccess (Success 2xx: BirthDate) {Integer} user_id The user that this password belongs to.
 * @apiSuccess (Success 2xx: BirthDate) {Date} birth_date The user's birth date.
 */
/**
 * @apiDefine GetBirthDatesSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 20,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/birthdates?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "user_id": 1,
 *                  "birth_date": "1990-09-08"
 *              },
 *              {
 *                  "id": 2,
 *                  "user_id": 2,
 *                  "birth_date": "1929-10-29"
 *              },
 *              {
 *                  "id": 3,
 *                  "user_id": 3,
 *                  "birth_date": "1970-01-01"
 *              },
 *              {
 *                  "id": 4,
 *                  "user_id": 4,
 *                  "birth_date": "1992-01-05"
 *              },
 *              {
 *                  "id": 5,
 *                  "user_id": 5,
 *                  "birth_date": "1776-07-04"
 *              }
 *          ]
 *      }
 */
/**
 * @apiDefine GetBirthDateSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "user_id": 1,
 *              "birth_date": "1990-09-08"
 *          }
 *      }
 */

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\BirthDate;
use App\UUD\Transformers\BirthDateTransformer;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests;

class BirthDateController extends ApiController
{

    /**
     * @var BirthDateTransformer
     */
    protected $birthDateTransformer;

    /**
     * @var string
     */
    protected $type = 'birth_date';

    /**
     * BirthDateController constructor.
     * @param BirthDateTransformer $birthDateTransformer
     */
    function __construct(BirthDateTransformer $birthDateTransformer)
    {
        $this->birthDateTransformer = $birthDateTransformer;
    }

    /**
     * @api {get} /birthdates GET: Request BirthDates
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission
     * @apiDescription This method returns pages of BirthDate objects.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiUse PaginationParams
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/birthdates/
     *
     * @apiUse PaginatedSuccess
     * @apiUse BirthDateSuccess
     * @apiUse GetBirthDatesSuccessResultExample
     */
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = BirthDate::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->birthDateTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
    }

    /**
     * @api {post} /birthdates POST: Create/Modify BirthDate
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission post
     * @apiDescription This method creates a new password, or updates an password object with the specified user database id.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -m post -d "user_id=151&birth_date=1992-01-05"
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "POST" \
     *      --data "user_id=151" \
     *      --data "birth_date=1992-01-05" \
     *      --url https://api.example.tld/api/v1/birthdates/
     *
     * @apiUse CreateSuccessResultExample
     * @apiUse UpdateSuccessResultExample
     * @apiUse UnprocessableEntityErrors
     * @apiUse BirthDateParameters
     */
    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'birth_date' => 'date|required',
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $date = date('Y-m-d', strtotime(Input::get('birth_date')));
        BirthDate::where('user_id', Input::get('user_id'))->onlyTrashed()->restore();
        $item = BirthDate::updateOrCreate(['user_id' => Input::get('user_id')], ['user_id' => Input::get('user_id'), 'birth_date' => $date]);
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
    }

    /**
     * @api {get} /birthdates/:id GET: Request BirthDate
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission get
     * @apiDescription This method returns a BirthDate object, an id is supplied to the API.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {Integer} id The password's unique ID.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -p 501
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/birthdates/501
     *
     * @apiUse BirthDateSuccess
     * @apiUse GetBirthDateSuccessResultExample
     * @apiUse ModelNotFoundError
     */
    /**
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $result = BirthDate::findOrFail($id);
        return $this->respondWithSuccess($this->birthDateTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        //
    }

    /**
     * @api {delete} /birthdates/:id DELETE: Destroy BirthDate
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission delete
     * @apiDescription This method deletes a BirthDate object, the database ID value is supplied to the API.
     * @apiUse ApiSuccessFields
     * @apiUse ApiSuccessExampleDestroy
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {Integer} id The password's unique ID.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -m delete -p 501
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "DELETE" \
     *      --url https://api.example.tld/api/v1/birthdates/501
     *
     * @apiUse ModelNotFoundError
     */
    /**
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        BirthDate::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @api {get} /birthdates/user/:id GET: By User ID
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission get
     * @apiDescription This method returns BirthDate objects associated with the user's database id.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {Integer} id The users unique ID.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -p user/153
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/birthdates/user/153
     *
     * @apiUse BirthDateSuccess
     * @apiUse GetBirthDateSuccessResultExample
     * @apiUse ModelNotFoundError
     */
    /**
     * @param $id
     * @return mixed
     */
    public function userBirthDates($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->birth_date()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->birthDateTransformer->transformCollection($result->all()));
    }

    /**
     * @api {get} /birthdates/identifier/:identifier GET: By User Identifier
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission get
     * @apiDescription This method returns BirthDate objects associated with the Identifier that was supplied.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {String} identifier The user's unique identifier string.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -p identifier/979659
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/birthdates/identifier/979659
     *
     * @apiUse BirthDateSuccess
     * @apiUse GetBirthDateSuccessResultExample
     * @apiUse ModelNotFoundError
     */
    /**
     * @param $identifier
     * @param Request $request
     * @return mixed
     */
    public function userBirthDatesByIdentifier($identifier, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('identifier', $identifier)->firstOrFail()->birth_date()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->birthDateTransformer->transformCollection($result->all()));
    }

    /**
     * @api {get} /birthdates/username/:username GET: By Username
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission get
     * @apiDescription This method returns BirthDate objects associated with the Username that was supplied.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {String} username The users unique username.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -p username/skywal
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/birthdates/username/skywal
     *
     * @apiUse BirthDateSuccess
     * @apiUse GetBirthDateSuccessResultExample
     * @apiUse ModelNotFoundError
     */
    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userBirthDatesByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->birth_date()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->birthDateTransformer->transformCollection($result->all()));
    }

    /**
     * @api {post} /birthdates/identifier POST: Create/Update BirthDate by User Identifier
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission post
     * @apiDescription This method creates a new password, or updates an password object with the specified user identifier.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -m post -p identifier -d "identifier=04986732&birth_date=1992-01-05"
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "POST" \
     *      --data "identifier=04986732" \
     *      --data "birth_date=1992-01-05" \
     *      --url https://api.example.tld/api/v1/birthdates/identifier
     *
     * @apiUse CreateSuccessResultExample
     * @apiUse UpdateSuccessResultExample
     * @apiUse UnprocessableEntityErrors
     * @apiParam (BirthDate Parameters) {String} identifier The user's unique identifier string.
     * @apiParam (BirthDate Parameters) {Date} birth_date The user's birth date. In strtotime format: (https://secure.php.net/manual/en/function.strtotime.php).
     */
    /**
     * @param Request $request
     * @return mixed
     */
    public function storeUserBirthDateByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'birth_date' => 'date|required',
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $date = date('Y-m-d', strtotime(Input::get('birth_date')));
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        BirthDate::where('user_id', $user->id)->onlyTrashed()->restore();
        $item = BirthDate::updateOrCreate(['user_id' => $user->id], ['user_id' => $user->id, 'birth_date' => $date]);
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
    }

    /**
     * @api {post} /birthdates/username POST: Create/Update BirthDate by Username
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission post
     * @apiDescription This method creates a new password, or updates an password object with the specified username.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -m post -p username -d "username=skywal&birth_date=1992-01-05"
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "POST" \
     *      --data "username=skywal" \
     *      --data "birth_date=1992-01-05" \
     *      --url https://api.example.tld/api/v1/birthdates/username
     *
     * @apiUse CreateSuccessResultExample
     * @apiUse UpdateSuccessResultExample
     * @apiUse UnprocessableEntityErrors
     * @apiParam (BirthDate Parameters) {String} username The user's unique username string.
     * @apiParam (BirthDate Parameters) {Date} birth_date The user's birth date. In strtotime format: (https://secure.php.net/manual/en/function.strtotime.php).
     */
    /**
     * @param Request $request
     * @return mixed
     */
    public function storeUserBirthDateByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'birth_date' => 'date|required',
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $date = date('Y-m-d', strtotime(Input::get('birth_date')));
        $user = User::where('username', $request->input('username'))->firstOrFail();
        BirthDate::where('user_id', $user->id)->onlyTrashed()->restore();
        $item = BirthDate::updateOrCreate(['user_id' => $user->id], ['user_id' => $user->id, 'birth_date' => $date]);
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
    }

    /**
     * @api {delete} /birthdates/user DELETE: Destroy by User
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission delete
     * @apiDescription This method deletes a BirthDate object, the database ID value of the user is supplied to the API.
     * @apiUse ApiSuccessFields
     * @apiUse ApiSuccessExampleDestroy
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {Integer} user The user's unique ID.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -m delete -p user -d "user=151"
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "DELETE" \
     *      --data "user=151" \
     *      --url https://api.example.tld/api/v1/birthdates/user
     *
     * @apiUse ModelNotFoundError
     */
    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteUserBirthDate(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        BirthDate::where('user_id', $user->id)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @api {delete} /birthdates/identifier DELETE: Destroy by User Identifier
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission delete
     * @apiDescription This method deletes a BirthDate object, a user's unique identifier string is supplied.
     * @apiUse ApiSuccessFields
     * @apiUse ApiSuccessExampleDestroy
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {String} identifier The user's unique identifier string.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -m delete -p identifier -d "identifier=04986732"
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "DELETE" \
     *      --data "identifier=04986732" \
     *      --url https://api.example.tld/api/v1/birthdates/identifier
     *
     * @apiUse ModelNotFoundError
     */
    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteUserBirthDateByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        BirthDate::where('user_id', $user->id)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @api {delete} /birthdates/username DELETE: Destroy by Username
     * @apiVersion 1.0.0
     * @apiGroup BirthDates
     * @apiPermission delete
     * @apiDescription This method deletes a BirthDate object, a user's unique username string is supplied.
     * @apiUse ApiSuccessFields
     * @apiUse ApiSuccessExampleDestroy
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {String} username The user's unique username string.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o birthdates -m delete -p username -d "username=skywal"
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "DELETE" \
     *      --data "username=skywal" \
     *      --url https://api.example.tld/api/v1/birthdates/username
     *
     * @apiUse ModelNotFoundError
     */
    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteUserBirthDateByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        BirthDate::where('user_id', $user->id)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

}