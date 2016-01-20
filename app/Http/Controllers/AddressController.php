<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 6:00 PM
 */

namespace App\Http\Controllers;

use App\Model\Address;
use App\Model\User;
use App\UUD\Transformers\AddressTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->isAuthorized($request, $this-type)) return $this->respondNotAuthorized();
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
     * Store a newly created resource in storage.
     *
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
     * Display the specified resource.
     *
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
     * Remove the specified resource from storage.
     *
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
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function userAddressesByUserId($user_id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('user_identifier', $user_id)->firstOrFail()->addresses()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->addressTransformer->transformCollection($result->all()));
    }

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
