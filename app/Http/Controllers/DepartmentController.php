<?php

namespace App\Http\Controllers;

use App\Model\Department;
use App\UUD\Transformers\DepartmentTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends ApiController
{
    /**
     * @var DepartmentTransformer
     */
    protected $departmentTransformer;

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
    public function index()
    {
        $result = Department::all();
        return $this->respondWithSuccess($this->departmentTransformer->transformCollection($result->all()));
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
            'academic' => 'boolean|required',
            'code' => 'string|required|min:3|unique:departments,deleted_at,NULL',
            'name' => 'integer|required|min:5',

        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Department::create(Input::all());
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
        $result = Department::find($id);
        if (!$result) return $this->respondNotFound();
        return $this->respondWithSuccess($this->departmentTransformer->transform($result));
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
}
