<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Course;
use Illuminate\Http\Request;

class CourseController extends ApiController
{
    /**
     * Show all Courses
     *
     * Get a paginated array of Courses.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Course::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new CourseController);
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
