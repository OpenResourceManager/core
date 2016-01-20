<?php

namespace App\Http\Controllers;

use App\Model\Course;
use App\Model\Department;
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
            'name' => 'integer|required|min:5',

        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Course::updateOrCreate(['code' => Input::get('code')], Input::all());
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
}
