<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Department;
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
        return $this->response->paginator($accounts, new DepartmentController);
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
