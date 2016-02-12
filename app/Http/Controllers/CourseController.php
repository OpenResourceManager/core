<?php

namespace App\Http\Controllers;

use App\Model\Course;
use App\Model\Department;
use App\Model\User;
use App\UUD\Transformers\CourseTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CourseController extends ApiController
{
    /**
     * @var CourseTransformer
     */
    protected $courseTransformer;

    /**
     * @var string
     */
    protected $type = 'course';

    /**
     * @param CourseTransformer $courseTransformer
     */
    function __construct(CourseTransformer $courseTransformer)
    {
        $this->courseTransformer = $courseTransformer;
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
        $result = Course::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
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
            'department_id' => 'integer|required|exists:departments,id,deleted_at,NULL',
            'code' => 'string|required|min:3|unique:courses,deleted_at,NULL',
            'course_level' => 'integer|required',
            'name' => 'string|required|min:5',

        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Course::updateOrCreate(['code' => Input::get('code')], Input::all());
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeByDepartmentCode(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'department_code' => 'string|required|exists:departments,code,deleted_at,NULL',
            'code' => 'string|required|min:3|unique:courses,deleted_at,NULL',
            'course_level' => 'integer|required',
            'name' => 'string|required|min:5',

        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $department = new Department();
        $course = [
            'department_id' => $department->code2id(Input::get('department_code')),
            'code' => Input::get('code'),
            'course_level' => Input::get('course_level'),
            'name' => Input::get('name')
        ];
        $item = Course::updateOrCreate(['code' => Input::get('code')], $course);
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
        $result = Course::findOrFail($id);
        return $this->respondWithSuccess($this->courseTransformer->transform($result));
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
        $result = Course::where('code', $code)->firstOrFail();
        return $this->respondWithSuccess($this->courseTransformer->transform($result));
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
        Course::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $code
     * @return \Illuminate\Http\Response
     */
    public function destroyByCode(Request $request, $code)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        Course::where('code', $code)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function departmentCourses($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Department::findOrFail($id)->courses()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function departmentCoursesByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Department::where('code', $code)->firstOrFail()->courses()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userCourses($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->courses()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function userCoursesByUserId($user_id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('user_identifier', $user_id)->firstOrFail()->courses()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userCoursesByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->course()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
    }



    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserCourse(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'course_id' => 'integer|required|exists:courses,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $course = Course::findOrFail($request->input('course_id'));
        if (!$user->courses->contains($course->id)) {
            $user->courses()->attach($course);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserCourseByUserId(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_identifier' => 'string|required|exists:users,user_identifier,deleted_at,NULL',
            'course_id' => 'integer|required|exists:courses,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('user_identifier', $request->input('user_identifier'))->firstOrFail();
        $course = Course::findOrFail($request->input('course_id'));
        if (!$user->courses->contains($course->id)) {
            $user->courses()->attach($course);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserCourseByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'course_id' => 'integer|required|exists:courses,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $course = Course::findOrFail($request->input('course_id'));
        if (!$user->courses->contains($course->id)) {
            $user->courses()->attach($course);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserCourseCode(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'course_code' => 'string|required|exists:courses,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $course = Course::where('code', $request->input('course_code'))->firstOrFail();
        if (!$user->courses->contains($course->id)) {
            $user->courses()->attach($course);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserCourseCodeByUserId(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_identifier' => 'string|required|exists:users,user_identifier,deleted_at,NULL',
            'course_code' => 'string|required|exists:courses,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('user_identifier', $request->input('user_identifier'))->firstOrFail();
        $course = Course::where('code', $request->input('course_code'))->firstOrFail();
        if (!$user->courses->contains($course->id)) {
            $user->courses()->attach($course);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserCourseCodeByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'course_code' => 'string|required|exists:courses,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $course = Course::where('code', $request->input('course_code'))->firstOrFail();
        if (!$user->courses->contains($course->id)) {
            $user->courses()->attach($course);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserCourse(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'course_id' => 'integer|required|exists:courses,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        $course = Course::findOrFail($request->input('course_id'));
        if ($user->courses->contains($course->id)) {
            $user->courses()->detach($course);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserCourseByUserId(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_identifier' => 'string|required|exists:users,user_identifier,deleted_at,NULL',
            'course_id' => 'integer|required|exists:courses,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('user_identifier', $request->input('user_identifier'))->firstOrFail();
        $course = Course::findOrFail($request->input('course_id'));
        if ($user->courses->contains($course->id)) {
            $user->courses()->detach($course);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserCourseByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'course_id' => 'integer|required|exists:courses,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $course = Course::findOrFail($request->input('course_id'));
        if ($user->courses->contains($course->id)) {
            $user->courses()->detach($course);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserCourseCode(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'course_code' => 'string|required|exists:courses,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user'));
        $course = Course::where('code', $request->input('course_code'))->firstOrFail();
        if ($user->courses->contains($course->id)) {
            $user->courses()->detach($course);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserCourseCodeByUserId(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_identifier' => 'string|required|exists:users,user_identifier,deleted_at,NULL',
            'course_code' => 'string|required|exists:courses,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('user_identifier', $request->input('user_identifier'))->firstOrFail();
        $course = Course::where('code', $request->input('course_code'))->firstOrFail();
        if ($user->courses->contains($course->id)) {
            $user->courses()->detach($course);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserCourseCodeByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'course_code' => 'string|required|exists:courses,code,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $course = Course::where('code', $request->input('course_code'))->firstOrFail();
        if ($user->courses->contains($course->id)) {
            $user->courses()->detach($course);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user' => intval($user->id), 'course' => intval($course->id)]);
        }
    }
}
