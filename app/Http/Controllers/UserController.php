<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Model\Building;
use App\Model\Campus;
use App\Model\Course;
use App\Model\Role;
use App\Model\User;
use App\UUD\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{

    /**
     * @apiDefine UsersSuccess
     * @apiSuccess {Boolean} success Tells the application if the request was successful.
     * @apiSuccess {Integer} status_code The HTTP status code of the request, this is also available in the header.
     * @apiSuccess {Object[]} result An array of User objects.
     */
    /**
     * @apiDefine UserSuccess
     * @apiSuccess (User Object) {Integer} id The numeric id assigned to the user by the database.
     * @apiSuccess (User Object) {String} user_identifier The user's unique identifier string.
     * @apiSuccess (User Object) {String} username The user's username string.
     * @apiSuccess (User Object) {String} name_prefix The user's name prefix, if there is one.
     * @apiSuccess (User Object) {String} name_first The user's fist name.
     * @apiSuccess (User Object) {String} name_middle The user's middle name or initial, if there is one.
     * @apiSuccess (User Object) {String} name_last The user's last name.
     * @apiSuccess (User Object) {String} name_postfix The user's name postfix, if there is one.
     * @apiSuccess (User Object) {String} name_phonetic The phonetic user's name, if there is one.
     */
    /**
     * @apiDefine GetUsersSuccessResult
     * @apiSuccessExample {json} Success Response:
     *      HTTP/1.1 200 OK
            {
                "success": true,
                "status_code": 200,
                "pagination": {
                    "total_pages": 6,
                    "current_page": 1,
                    "result_limit": 25,
                    "next_page": "api\/v1\/users?limit=25&page=2",
                    "previous_page": null
                },
                "result": [
                    {
                        "id": 1,
                        "user_identifier": "6223406",
                        "username": "Caitlyn62",
                        "name_prefix": "Ms.",
                        "name_first": "Robb",
                        "name_middle": "Irwin",
                        "name_last": "Fritsch",
                        "name_postfix": "Dr.",
                        "name_phonetic": null
                    },
                    {
                        "id": 2,
                        "user_identifier": "4027012",
                        "username": "Manley.Hirthe",
                        "name_prefix": "Mr.",
                        "name_first": "Eunice",
                        "name_middle": "Reva",
                        "name_last": "Pfeffer",
                        "name_postfix": "Dr.",
                        "name_phonetic": null
                    },
                    {
                        "id": 3,
                        "user_identifier": "2892039",
                        "username": "Tess39",
                        "name_prefix": "Ms.",
                        "name_first": "Franco",
                        "name_middle": null,
                        "name_last": "Kirlin",
                        "name_postfix": "Mr.",
                        "name_phonetic": "Jerald"
                    },
                    {
                        "id": 4,
                        "user_identifier": "9901344",
                        "username": "Sauer.Eulalia",
                        "name_prefix": null,
                        "name_first": "Karianne",
                        "name_middle": "Mollie",
                        "name_last": "Aufderhar",
                        "name_postfix": "Prof.",
                        "name_phonetic": "Shanna"
                    },
                    {
                        "id": 5,
                        "user_identifier": "4619979",
                        "username": "Lang.Sydnee",
                        "name_prefix": null,
                        "name_first": "Leopold",
                        "name_middle": "Nicholaus",
                        "name_last": "Lesch",
                        "name_postfix": "Dr.",
                        "name_phonetic": "Emanuel"
                    },
                    {
                        "id": 6,
                        "user_identifier": "9066187",
                        "username": "iReilly",
                        "name_prefix": null,
                        "name_first": "Ernie",
                        "name_middle": "Hiram",
                        "name_last": "Crooks",
                        "name_postfix": null,
                        "name_phonetic": "Ewell"
                    },
                    {
                        "id": 7,
                        "user_identifier": "7305798",
                        "username": "Emard.Emmie",
                        "name_prefix": null,
                        "name_first": "Elza",
                        "name_middle": null,
                        "name_last": "Homenick",
                        "name_postfix": "Mrs.",
                        "name_phonetic": "Ettie"
                    },
                    {
                        "id": 8,
                        "user_identifier": "5439215",
                        "username": "Wehner.Dale",
                        "name_prefix": "Mr.",
                        "name_first": "Billie",
                        "name_middle": null,
                        "name_last": "Predovic",
                        "name_postfix": null,
                        "name_phonetic": null
                    },
                    {
                        "id": 9,
                        "user_identifier": "5752942",
                        "username": "Koch.Kiana",
                        "name_prefix": null,
                        "name_first": "Alexandria",
                        "name_middle": "Ryan",
                        "name_last": "Weimann",
                        "name_postfix": null,
                        "name_phonetic": null
                    },
                    {
                        "id": 10,
                        "user_identifier": "3472187",
                        "username": "Alan26",
                        "name_prefix": "Miss",
                        "name_first": "Phoebe",
                        "name_middle": "Ryan",
                        "name_last": "Howell",
                        "name_postfix": "Prof.",
                        "name_phonetic": "Nils"
                    },
                    {
                        "id": 11,
                        "user_identifier": "2980379",
                        "username": "Haylie.Miller",
                        "name_prefix": null,
                        "name_first": "Eda",
                        "name_middle": null,
                        "name_last": "Glover",
                        "name_postfix": "Miss",
                        "name_phonetic": "Lamont"
                    },
                    {
                        "id": 12,
                        "user_identifier": "3352865",
                        "username": "Emerson80",
                        "name_prefix": "Prof.",
                        "name_first": "Jaylon",
                        "name_middle": null,
                        "name_last": "Farrell",
                        "name_postfix": "Mrs.",
                        "name_phonetic": null
                    },
                    {
                        "id": 13,
                        "user_identifier": "4150244",
                        "username": "Chaz.Predovic",
                        "name_prefix": null,
                        "name_first": "Davonte",
                        "name_middle": "Eudora",
                        "name_last": "Rolfson",
                        "name_postfix": "Prof.",
                        "name_phonetic": null
                    },
                    {
                        "id": 14,
                        "user_identifier": "4131977",
                        "username": "Daniella.Bosco",
                        "name_prefix": null,
                        "name_first": "Thaddeus",
                        "name_middle": "Felipe",
                        "name_last": "Weimann",
                        "name_postfix": null,
                        "name_phonetic": "Lionel"
                    },
                    {
                        "id": 15,
                        "user_identifier": "8964391",
                        "username": "Myrtie54",
                        "name_prefix": null,
                        "name_first": "Amya",
                        "name_middle": "Kristian",
                        "name_last": "Anderson",
                        "name_postfix": "Dr.",
                        "name_phonetic": "Maximillian"
                    },
                    {
                        "id": 16,
                        "user_identifier": "8088111",
                        "username": "Felix.Gaylord",
                        "name_prefix": "Prof.",
                        "name_first": "Dangelo",
                        "name_middle": null,
                        "name_last": "Schinner",
                        "name_postfix": "Mr.",
                        "name_phonetic": null
                    },
                    {
                        "id": 17,
                        "user_identifier": "2537465",
                        "username": "tDicki",
                        "name_prefix": "Prof.",
                        "name_first": "Albin",
                        "name_middle": null,
                        "name_last": "Waters",
                        "name_postfix": "Ms.",
                        "name_phonetic": null
                    },
                    {
                        "id": 18,
                        "user_identifier": "6093255",
                        "username": "Reese.Murazik",
                        "name_prefix": "Mr.",
                        "name_first": "Kay",
                        "name_middle": "Mabelle",
                        "name_last": "Reinger",
                        "name_postfix": "Mrs.",
                        "name_phonetic": null
                    },
                    {
                        "id": 19,
                        "user_identifier": "8351837",
                        "username": "Zulauf.Maybelle",
                        "name_prefix": null,
                        "name_first": "Violet",
                        "name_middle": "Adam",
                        "name_last": "Wisozk",
                        "name_postfix": null,
                        "name_phonetic": null
                    },
                    {
                        "id": 20,
                        "user_identifier": "7520298",
                        "username": "eRowe",
                        "name_prefix": "Mr.",
                        "name_first": "Delmer",
                        "name_middle": "Bertram",
                        "name_last": "Tremblay",
                        "name_postfix": "Dr.",
                        "name_phonetic": null
                    },
                    {
                        "id": 21,
                        "user_identifier": "3720241",
                        "username": "hFunk",
                        "name_prefix": null,
                        "name_first": "Conner",
                        "name_middle": "Marta",
                        "name_last": "Batz",
                        "name_postfix": "Dr.",
                        "name_phonetic": null
                    },
                    {
                        "id": 22,
                        "user_identifier": "8018599",
                        "username": "Rubie.Jacobson",
                        "name_prefix": "Prof.",
                        "name_first": "Stefan",
                        "name_middle": "Serena",
                        "name_last": "Champlin",
                        "name_postfix": "Prof.",
                        "name_phonetic": null
                    },
                    {
                        "id": 23,
                        "user_identifier": "1199050",
                        "username": "Danial.Medhurst",
                        "name_prefix": null,
                        "name_first": "Ova",
                        "name_middle": null,
                        "name_last": "Cruickshank",
                        "name_postfix": "Dr.",
                        "name_phonetic": "Josefina"
                    },
                    {
                        "id": 24,
                        "user_identifier": "9221453",
                        "username": "Schmeler.Alexanne",
                        "name_prefix": null,
                        "name_first": "Fredrick",
                        "name_middle": null,
                        "name_last": "Monahan",
                        "name_postfix": null,
                        "name_phonetic": "Alexzander"
                    },
                    {
                        "id": 25,
                        "user_identifier": "8716103",
                        "username": "Novella.Hauck",
                        "name_prefix": null,
                        "name_first": "Libby",
                        "name_middle": "Hailey",
                        "name_last": "Gutkowski",
                        "name_postfix": null,
                        "name_phonetic": null
                    }
                ]
            }
     */

    /**
     * @var UserTransformer
     */
    protected $userTransformer;

    /**
     * @param UserTransformer $userTransformer
     */
    function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }


    /**
     * @api {get} /users/ Get: Request Users
     * @apiVersion 1.1.1
     * @apiName GetUsers
     * @apiGroup Users
     *
     * @apiUse AuthorizationHeader
     * @apiUse PaginationParams
     *
     * @apiExample {curl} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/
     *
     * @apiUse PaginatedSuccess
     * @apiUse UsersSuccess
     * @apiUse UserSuccess
     * @apiUse GetUsersSuccessResult
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_identifier' => 'string|required|max:7|min:6',
            'name_prefix' => 'string|max:7',
            'name_first' => 'string|required|min:1',
            'name_middle' => 'string',
            'name_last' => 'string|required|min:1',
            'name_postfix' => 'string|max:7',
            'name_phonetic' => 'string',
            'username' => 'string|required|min:3|unique:users,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Building::updateOrCreate(['user_identifier' => Input::get('user_identifier')], Input::all());
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = User::findOrFail($id);
        return $this->respondWithSuccess($this->userTransformer->transform($result));
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function showByUserId($user_id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = User::where('user_identifier', $user_id)->firstOrFail();
        return $this->respondWithSuccess($this->userTransformer->transform($result));
    }

    /**
     * @param $username
     * @return mixed
     */
    public function showByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = User::where('username', $username)->firstOrFail();
        return $this->respondWithSuccess($this->userTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        User::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroyByUserId($user_id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        User::where('user_identifier', $user_id)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $username
     * @return \Illuminate\Http\Response
     */
    public function destroyByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        User::where('username', $username)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function campusUsers($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Campus::findOrFail($id)->users();
        return $this->respondWithSuccess($this->userTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function buildingUsers($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Building::findOrFail($id)->users();

        echo json_encode($result);

        //  return $this->respondWithSuccess($this->userTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function roleUsers($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Role::findOrFail($id)->users()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function courseUsers($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Course::findOrFail($id)->users()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
    }

    /**
     * @param $code
     * @param Request $request
     * @return mixed
     */
    public function courseUsersByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Course::where('code', $code)->firstOrFail()->users()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
    }
}
