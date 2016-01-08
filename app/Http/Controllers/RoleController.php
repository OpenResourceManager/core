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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Role::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
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
            'code' => 'string|required|min:3',
            'name' => 'string|required|max:25',
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Role::updateOrCreate(['code' => Input::get('code')], Input::all());
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
        $result = Role::findOrFail($id);
        return $this->respondWithSuccess($this->roleTransformer->transform($result));
    }

    /**
     * @param $code
     * @return mixed
     */
    public function showByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Role::where('code', $code)->firstOrFail();
        return $this->respondWithSuccess($this->roleTransformer->transform($result));
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
        Role::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $code
     * @return \Illuminate\Http\Response
     */
    public function destroyByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        Role::where('code', $code)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function userRoles($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->roles()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function userRolesByUserId($user_id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('user_identifier', $user_id)->firstOrFail()->roles()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userRolesByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->roles()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
    }

    /**
     * @param $roleID
     * @param Request $request
     * @return mixed
     */
    public function assignUserRole(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user' => 'integer|required|exists:users,id,deleted_at,NULL',
            'role' => 'integer|required|exists:roles,id,deleted_at,NULL'
        ]);
        $user_id = $request->input('user');
        $role_id = $request->input('role');
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($user_id);
        $role = Role::findOrFail($role_id);
        if (!$user->roles->contains($role_id)) {
            $user->roles()->attach($role);
            return $this->respondAssignSuccess($message = 'Assigned', $id = ['user' => $user_id, 'role' => $role_id]);
        } else {
            return $this->respondAssignSuccess($message = 'Assignment Already Present', $id = ['user' => intval($user_id), 'role' => intval($role_id)]);
        }
    }
}
