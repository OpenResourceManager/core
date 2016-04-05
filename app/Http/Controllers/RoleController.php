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
     * @var string
     */
    protected $type = 'role';

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
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
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
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $result = Role::findOrFail($id);
        return $this->respondWithSuccess($this->roleTransformer->transform($result));
    }

    /**
     * @param $code
     * @return mixed
     */
    public function showByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
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
    public function destroy($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        Role::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $code
     * @return \Illuminate\Http\Response
     */
    public function destroyByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
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
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->roles()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return mixed
     */
    public function userRolesByIdentifier($identifier, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('identifier', $identifier)->firstOrFail()->roles()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userRolesByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->roles()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roleTransformer->transformCollection($result->all()));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserRole(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'role_id' => 'integer|required|exists:roles,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $role = Role::findOrFail($request->input('role_id'));
        if (!$user->roles->contains($role->id)) {
            $user->roles()->attach($role);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserRoleByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'role_id' => 'integer|required|exists:roles,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        $role = Role::findOrFail($request->input('role_id'));
        if (!$user->roles->contains($role->id)) {
            $user->roles()->attach($role);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserRoleByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'role_id' => 'integer|required|exists:roles,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $role = Role::findOrFail($request->input('role_id'));
        if (!$user->roles->contains($role->id)) {
            $user->roles()->attach($role);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserRoleCode(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'role_code' => 'string|required|exists:roles,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $role = Role::where('code', $request->input('role_code'))->firstOrFail();
        if (!$user->roles->contains($role->id)) {
            $user->roles()->attach($role);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserRoleCodeByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'role_code' => 'string|required|exists:roles,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        $role = Role::where('code', $request->input('role_code'))->firstOrFail();
        if (!$user->roles->contains($role->id)) {
            $user->roles()->attach($role);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserRoleCodeByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'role_code' => 'string|required|exists:roles,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $role = Role::where('code', $request->input('role_code'))->firstOrFail();
        if (!$user->roles->contains($role->id)) {
            $user->roles()->attach($role);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserRole(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'role_id' => 'integer|required|exists:roles,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $role = Role::findOrFail($request->input('role_id'));
        if ($user->roles->contains($role->id)) {
            $user->roles()->detach($role);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserRoleByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'role_id' => 'integer|required|exists:roles,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        $role = Role::findOrFail($request->input('role_id'));
        if ($user->roles->contains($role->id)) {
            $user->roles()->detach($role);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserRoleByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'role_id' => 'integer|required|exists:roles,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $role = Role::findOrFail($request->input('role_id'));
        if ($user->roles->contains($role->id)) {
            $user->roles()->detach($role);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserRoleCode(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'role_code' => 'string|required|exists:roles,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $role = Role::where('code', $request->input('role_code'))->firstOrFail();
        if ($user->roles->contains($role->id)) {
            $user->roles()->detach($role);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserRoleCodeByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'role_code' => 'string|required|exists:roles,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        $role = Role::where('code', $request->input('role_code'))->firstOrFail();
        if ($user->roles->contains($role->id)) {
            $user->roles()->detach($role);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserRoleCodeByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'role_code' => 'string|required|exists:roles,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $role = Role::where('code', $request->input('role_code'))->firstOrFail();
        if ($user->roles->contains($role->id)) {
            $user->roles()->detach($role);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'role_id' => intval($role->id)]);
        }
    }
}
