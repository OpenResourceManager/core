<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Department;
use App\Http\Transformers\DepartmentTransformer;
use Illuminate\Http\Request;

class DepartmentController extends ApiController
{
    /**
     * Show all Departments
     *
     * Get a paginated array of Departments.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Department::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new DepartmentTransformer);
    }

    /**
     * Show a Department
     *
     * Display a Department by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Department::findOrFail($id);
        return $this->response->item($item, new DepartmentTransformer);
    }

    /**
     * Show Department by Code
     *
     * Display a Department by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Department::where('code', $code)->firstOrFail();
        return $this->response->item($item, new DepartmentTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
