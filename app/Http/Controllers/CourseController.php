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
        parent::index($request);
        $result = Course::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
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
            'department_id' => 'integer|required|exists:departments,id,deleted_at,NULL',
            'code' => 'string|required|min:3|unique:courses,deleted_at,NULL',
            'name' => 'integer|required|min:5',

        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Course::create(Input::all());
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
        $result = Course::findOrFail($id);
        return $this->respondWithSuccess($this->courseTransformer->transform($result));
    }

    /**
     * Display a resource with a specific code
     *
     * @param $code
     * @return mixed
     */
    public function showByCode($code)
    {
        $result = Course::where('code', $code)->firstOrFail();
        return $this->respondWithSuccess($this->courseTransformer->transform($result));
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
        Course::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $code
     * @return \Illuminate\Http\Response
     */
    public function destroyByCode($code)
    {
        Course::where('code', $code)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function departmentCourses($id, Request $request)
    {
        $result = Department::findOrFail($id)->courses()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function departmentCoursesByCode($code, Request $request)
    {
        $result = Department::where('code', $code)->firstOrFail()->courses()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userCourses($id, Request $request)
    {
        $result = User::findOrFail($id)->courses()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function userCoursesByUserId($user_id, Request $request)
    {
        $result = User::where('user_identifier', $user_id)->firstOrFail()->courses()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userCoursesByUsername($username, Request $request)
    {
        $result = User::where('username', $username)->firstOrFail()->course()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->courseTransformer->transformCollection($result->all()));
    }
}
