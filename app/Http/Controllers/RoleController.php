<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\Model\User;
use App\UUD\Transformers\RoleTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class RoleController extends ApiController
{

    /**
     * @var RoleTransformer
     */
    protected $roleTransformer;

    /**
     * @param RoleTransformer $userTransformer
     */
    function __construct(RoleTransformer $roleTransformer)
    {
        $this->roleTransformer = $roleTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        parent::index($request);
        $result = Role::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $validator = Validator::make($request->all(), [
            'code' => 'string|required|min:3|unique:roles,deleted_at,NULL',
            'name' => 'string|max:25',
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Role::create(Input::all());
        return $this->respondCreateSuccess($id = $item->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Role::findOrFail($id);
        return $this->respondWithSuccess($this->roleTransformer->transform($result));
    }

    /**
     * @param $code
     * @return mixed
     */
    public function showByCode($code)
    {
        $result = Role::where('code', $code)->firstOrFail();
        return $this->respondWithSuccess($this->roleTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function userRoles($id, Request $request)
    {
        $result = User::findOrFail($id)->roles()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function userRolesByUserId($user_id, Request $request)
    {
        $result = User::where('user_identifier', $user_id)->firstOrFail()->roles()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userRolesByUsername($username, Request $request)
    {
        $result = User::where('username', $username)->firstOrFail()->roles()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
    }
}
