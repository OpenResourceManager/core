<?php
/**
 * @apiDefine AddressParameters
 * @apiParam (Address Parameters) {Integer} user_id The user who is associated with this address.
 * @apiParam (Address Parameters) {String} [addressee] The name of the addressee if different from the user's name.
 * @apiParam (Address Parameters) {String} [organization] The organization that the addressee belongs to.
 * @apiParam (Address Parameters) {String} line_1 The first address line.
 * @apiParam (Address Parameters) {String} [line_2] The second address line.
 * @apiParam (Address Parameters) {String} city The city line of the address.
 * @apiParam (Address Parameters) {Integer} state_id The id of the state or territory that the address resides in.
 * @apiParam (Address Parameters) {String} zip The zip code that the address resides in.
 * @apiParam (Address Parameters) {Integer} country_id The id of the country that the address resides in.
 * @apiParam (Address Parameters) {Float} [latitude] The latitude of the address.
 * @apiParam (Address Parameters) {Float} [longitude] The longitude of the address.
 */
/**
 * @apiDefine AddressSuccess
 * @apiSuccess (Success 2xx: Address) {Integer} id The numeric id assigned to the address by the database.
 * @apiSuccess (Success 2xx: Address) {Integer} user_id The user who is associated with this address.
 * @apiSuccess (Success 2xx: Address) {String} addressee The name of the addressee if different from the user's name.
 * @apiSuccess (Success 2xx: Address) {String} organization The organization that the addressee belongs to.
 * @apiSuccess (Success 2xx: Address) {String} line_1 The first address line.
 * @apiSuccess (Success 2xx: Address) {String} line_2 The second address line.
 * @apiSuccess (Success 2xx: Address) {String} city The city line of the address.
 * @apiSuccess (Success 2xx: Address) {Integer} state_id The id of the state or territory that the address resides in.
 * @apiSuccess (Success 2xx: Address) {String} zip The zip code that the address resides in.
 * @apiSuccess (Success 2xx: Address) {Integer} country_id The id of the country that the address resides in.
 * @apiSuccess (Success 2xx: Address) {Float} latitude The latitude of the address.
 * @apiSuccess (Success 2xx: Address) {Float} longitude The longitude of the address.
 */
/**
 * @apiDefine GetAddressesSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 80,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/addresses?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "user_id": 142,
 *                  "addressee": " Terrill Pfannerstill",
 *                  "organization": null,
 *                  "line_1": "8782 Ortiz Stravenue Apt. 102\nWest Hassiechester",
 *                  "line_2": null,
 *                  "city": "Rosaliaside",
 *                  "state_id": 38,
 *                  "zip": "80",
 *                  "country_id": 226,
 *                  "latitude": 0,
 *                  "longitude": 0
 *              },
 *              {
 *                  "id": 2,
 *                  "user_id": 106,
 *                  "addressee": " Yolanda Keenan Ullrich Mr.",
 *                  "organization": "Sipes, Smitham and Pollich",
 *                  "line_1": "17127 Leannon Trafficway Suite 727\nPort Nestormout",
 *                  "line_2": null,
 *                  "city": "Bechtelarland",
 *                  "state_id": 2,
 *                  "zip": "27837978",
 *                  "country_id": 226,
 *                  "latitude": 0,
 *                  "longitude": 0
 *              },
 *              {
 *                  "id": 3,
 *                  "user_id": 93,
 *                  "addressee": null,
 *                  "organization": null,
 *                  "line_1": "850 Karianne Crest Suite 374\nGabrielleberg, ID 654",
 *                  "line_2": null,
 *                  "city": "Nickolasmouth",
 *                  "state_id": 5,
 *                  "zip": "9905561",
 *                  "country_id": 226,
 *                  "latitude": 0,
 *                  "longitude": 999999.99
 *              },
 *              {
 *                  "id": 4,
 *                  "user_id": 117,
 *                  "addressee": "Prof. Cordia Iva Grant Dr.",
 *                  "organization": null,
 *                  "line_1": "8304 Bernadine Tunnel Apt. 583\nReeseport, NM 32332",
 *                  "line_2": "repellat",
 *                  "city": "West Kaliport",
 *                  "state_id": 17,
 *                  "zip": "0",
 *                  "country_id": 226,
 *                  "latitude": 0,
 *                  "longitude": 0
 *              },
 *              {
 *                  "id": 5,
 *                  "user_id": 4,
 *                  "addressee": "Mrs. Regan  Cruickshank ",
 *                  "organization": null,
 *                  "line_1": "1897 Ryan Cape\nPort Hobarttown, NV 87404",
 *                  "line_2": null,
 *                  "city": "Everetttown",
 *                  "state_id": 43,
 *                  "zip": "90",
 *                  "country_id": 226,
 *                  "latitude": 0,
 *                  "longitude": 0
 *              }
 *          ]
 *      }
 */
/**
 * @apiDefine GetAddressSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "user_id": 142,
 *              "addressee": " Terrill Pfannerstill",
 *              "organization": null,
 *              "line_1": "8782 Ortiz Stravenue Apt. 102\nWest Hassiechester",
 *              "line_2": null,
 *              "city": "Rosaliaside",
 *              "state_id": 38,
 *              "zip": "80",
 *              "country_id": 226,
 *              "latitude": 0,
 *              "longitude": 0
 *          }
 *      }
 */

namespace App\Http\Controllers;

use App\Model\Address;
use App\Model\User;
use App\UUD\Transformers\AddressTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends ApiController
{
    /**
     * @var string
     */
    protected $type = 'address';

    /**
     * @var AddressTransformer
     */
    protected $addressTransformer;

    /**
     * AddressController constructor.
     * @param AddressTransformer $addressTransformer
     */
    function __construct(AddressTransformer $addressTransformer)
    {
        $this->addressTransformer = $addressTransformer;
    }

    /**
     * @api {get} /addresses/ GET: Request Addresses
     * @apiVersion 1.0.0
     * @apiGroup Addresses
     * @apiPermission get
     * @apiDescription This method returns pages of Address objects.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiUse PaginationParams
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o addresses
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.domain.tld/api/v1/addresses/
     *
     * @apiUse PaginatedSuccess
     * @apiUse AddressSuccess
     * @apiUse GetAddressesSuccessResultExample
     */
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Address::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->addressTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        //
    }

    /**
     * @api {post} /addresses/ POST: Create Address
     * @apiVersion 1.0.0
     * @apiGroup Addresses
     * @apiPermission post
     * @apiDescription This method creates a new address.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiUse CreateSuccessResultExample
     * @apiUse UpdateSuccessResultExample
     * @apiUse UnprocessableEntityErrors
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o addresses -m post -d "user_id=142&addressee=Sir Luke Skywalker&organization=The Jedi Knight Academy&line_1=65 1st Street&line_2=Cowee Building&city=Troy&state=33&zip=12180&country_id=226&latitude=42.7274609&longitude=-73.6964327"
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "POST" \
     *      --data "user_id=142" \
     *      --data "addressee=Sir Luke Skywalker" \
     *      --data "organization=The Jedi Knight Academy" \
     *      --data "line_1=65 1st Street" \
     *      --data "line_2=Cowee Building" \
     *      --data "city=Troy" \
     *      --data "state=33" \
     *      --data "zip=12180" \
     *      --data "country_id=226" \
     *      --data "latitude=42.7274609" \
     *      --data "longitude=-73.6964327" \
     *      --url https://api.example.tld/api/v1/addresses/
     *
     * @apiUse AddressParameters
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
            'addressee' => 'string|max:50',
            'organization' => 'string|max:50',
            'line_1' => 'string|required|max:50',
            'line_2' => 'string|max:50',
            'city' => 'string|max:50',
            'state_id' => 'integer|required|exists:states,id,deleted_at,NULL',
            'zip' => 'numeric|max:11',
            'country_id' => 'integer|required|exists:countries,id,deleted_at,NULL',
            'latitude' => 'numeric',
            'longitude' => 'numeric'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Address::create(Input::all());
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
    }

    /**
     * @api {get} /addresses/:id GET: Request Address
     * @apiVersion 1.0.0
     * @apiGroup Addresses
     * @apiPermission get
     * @apiDescription This method returns a Address object, an id is supplied to the API.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {Integer} id The addresses' unique ID.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o addresses -p 2
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.domain.tld/api/v1/addresses/2
     *
     * @apiUse AddressSuccess
     * @apiUse GetAddressSuccessResultExample
     * @apiUse ModelNotFoundError
     */
    /**
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $result = Address::findOrFail($id);
        return $this->respondWithSuccess($this->addressTransformer->transform($result));
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
     * @api {delete} /addresses/:id DELETE: Destroy Address
     * @apiVersion 1.0.0
     * @apiGroup Addresses
     * @apiPermission delete
     * @apiDescription This method deletes a Address object, the database ID value is supplied to the API.
     * @apiUse ApiSuccessFields
     * @apiUse ApiSuccessExampleDestroy
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {Integer} id The addresses' unique ID.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o addresses -m delete -p 4
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" \
     *      -X "DELETE" \
     *      --url https://api.example.tld/api/v1/addresses/4
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
        Address::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }


    /**
     * @api {get} /addresses/user/:id GET: By user id
     * @apiVersion 1.0.0
     * @apiGroup Addresses
     * @apiPermission get
     * @apiDescription This method returns a Address objects, with the user's database id.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {Integer} id The users unique ID.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o addresses -p user/3
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/addresses/user/3
     *
     * @apiUse AddressSuccess
     * @apiUse GetAddressesSuccessResultExample
     * @apiUse ModelNotFoundError
     */
    /**
     * @param $id
     * @return mixed
     */
    public function userAddresses($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->addresses()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->addressTransformer->transformCollection($result->all()));
    }

    /**
     * @api {get} /addresses/username/:username GET: By Username
     * @apiVersion 1.0.0
     * @apiGroup Addresses
     * @apiPermission get
     * @apiDescription This method returns a Address objects, with the user's database id.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {String} id The username of the user.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o addresses -p username/skywal
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/addresses/username/skywal
     *
     * @apiUse AddressSuccess
     * @apiUse GetAddressesSuccessResultExample
     * @apiUse ModelNotFoundError
     */
    /**
     * @param $identifier
     * @param Request $request
     * @return mixed
     */
    public function userAddressesByIdentifier($identifier, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('identifier', $identifier)->firstOrFail()->addresses()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->addressTransformer->transformCollection($result->all()));
    }

    /**
     * @api {get} /addresses/identifier/:identifier GET: By User Identifier
     * @apiVersion 1.0.0
     * @apiGroup Addresses
     * @apiPermission get
     * @apiDescription This method returns a Address objects, with the user's database id.
     * @apiUse ApiSuccessFields
     * @apiUse ApiErrorFields
     * @apiUse AuthorizationHeader
     * @apiUse InternalServerErrors
     * @apiParam {String} identifier The user's unique identifier.
     * @apiExample {bash} UUD Client
     *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
     *      uud -o addresses -p identifier/9748523
     *
     * @apiExample {bash} Curl
     *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/addresses/identifier/9748523
     *
     * @apiUse AddressSuccess
     * @apiUse GetAddressesSuccessResultExample
     * @apiUse ModelNotFoundError
     */
    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userAddressesByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->addresses()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->addressTransformer->transformCollection($result->all()));
    }
}
