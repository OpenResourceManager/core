<?php

namespace App\Http\Controllers;

use App\Model\Course;
use App\Model\Department;
use App\Model\PivotAction;
use App\Model\User;
use App\UUD\Transformers\DepartmentTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends ApiController
{
    /**
     * @var DepartmentTransformer
     */
    protected $departmentTransformer;

    /**
     * @var string
     */
    protected $type = 'department';

    /**
     * @param DepartmentTransformer $departmentTransformer
     */
    function __construct(DepartmentTransformer $departmentTransformer)
    {
        $this->departmentTransformer = $departmentTransformer;
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
        $result = Department::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->departmentTransformer->transformCollection($result->all()));
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
            'academic' => 'integer|required|max:1',
            'code' => 'string|required|min:3',
            'name' => 'string|required|min:3',

        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Department::updateOrCreate(['code' => Input::get('code')], Input::all());
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
        $result = Department::findOrFail($id);
        return $this->respondWithSuccess($this->departmentTransformer->transform($result));
    }

    /**
     * Display a resource with a specific code
     *
     * @param $code
     * @return mixed
     */
    public function showByCode(Request $request, $code)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $result = Department::where('code', $code)->firstOrFail();
        return $this->respondWithSuccess($this->departmentTransformer->transform($result));
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
        Department::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $code
     * @return \Illuminate\Http\Response
     */
    public function destroyByCode(Request $request, $code)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        Department::where('code', $code)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function courseDepartment($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Course::findOrFail($id)->department()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->departmentTransformer->transformCollection($result->all()));
    }

    /**
     * @param $code
     * @param Request $request
     * @return mixed
     */
    public function courseDepartmentByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Course::where('code', $code)->firstOrFail()->department()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->departmentTransformer->transformCollection($result->all()));
    }


    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function userDepartments($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->departments()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->departmentTransformer->transformCollection($result->all()));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return mixed
     */
    public function userDepartmentsByIdentifier($identifier, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('identifier', $identifier)->firstOrFail()->departments()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->departmentTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userDepartmentsByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->departments()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->departmentTransformer->transformCollection($result->all()));
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserDepartment(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'department_id' => 'integer|required|exists:departments,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $department = Department::findOrFail($request->input('department_id'));
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'assign']);
        if (!$user->departments->contains($department->id)) {
            $user->departments()->attach($department);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserDepartmentByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'department_id' => 'integer|required|exists:departments,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        $department = Department::findOrFail($request->input('department_id'));
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'assign']);
        if (!$user->departments->contains($department->id)) {
            $user->departments()->attach($department);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserDepartmentByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'department_id' => 'integer|required|exists:departments,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $department = Department::findOrFail($request->input('department_id'));
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'assign']);
        if (!$user->departments->contains($department->id)) {
            $user->departments()->attach($department);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserDepartmentCode(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'department_code' => 'string|required|exists:departments,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $department = Department::where('code', $request->input('department_code'))->firstOrFail();
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'assign']);
        if (!$user->departments->contains($department->id)) {
            $user->departments()->attach($department);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserDepartmentCodeByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'department_code' => 'string|required|exists:departments,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        $department = Department::where('code', $request->input('department_code'))->firstOrFail();
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'assign']);
        if (!$user->departments->contains($department->id)) {
            $user->departments()->attach($department);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserDepartmentCodeByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'department_code' => 'string|required|exists:departments,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $department = Department::where('code', $request->input('department_code'))->firstOrFail();
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'assign']);
        if (!$user->departments->contains($department->id)) {
            $user->departments()->attach($department);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserDepartment(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'department_id' => 'integer|required|exists:departments,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $department = Department::findOrFail($request->input('department_id'));
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'unassign']);
        if ($user->departments->contains($department->id)) {
            $user->departments()->detach($department);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserDepartmentByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'department_id' => 'integer|required|exists:departments,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        $department = Department::findOrFail($request->input('department_id'));
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'unassign']);
        if ($user->departments->contains($department->id)) {
            $user->departments()->detach($department);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserDepartmentByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'department_id' => 'integer|required|exists:departments,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $department = Department::findOrFail($request->input('department_id'));
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'unassign']);
        if ($user->departments->contains($department->id)) {
            $user->departments()->detach($department);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserDepartmentCode(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'department_code' => 'string|required|exists:departments,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $department = Department::where('code', $request->input('department_code'))->firstOrFail();
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'unassign']);
        if ($user->departments->contains($department->id)) {
            $user->departments()->detach($department);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserDepartmentCodeByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'department_code' => 'string|required|exists:departments,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        $department = Department::where('code', $request->input('department_code'))->firstOrFail();
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'unassign']);
        if ($user->departments->contains($department->id)) {
            $user->departments()->detach($department);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserDepartmentCodeByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'department_code' => 'string|required|exists:departments,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $department = Department::where('code', $request->input('department_code'))->firstOrFail();
        PivotAction::create(['id_1' => $department->id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'action' => 'unassign']);
        if ($user->departments->contains($department->id)) {
            $user->departments()->detach($department);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user_id' => intval($user->id), 'department_id' => intval($department->id)]);
        }
    }
}
