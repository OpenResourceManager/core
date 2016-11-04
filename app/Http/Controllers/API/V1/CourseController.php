<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Course;
use App\Http\Transformers\CourseTransformer;
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
        return $this->response->paginator($accounts, new CourseTransformer);
    }

    /**
     * Show a Course
     *
     * Display a Course by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Course::findOrFail($id);
        return $this->response->item($item, new CourseTransformer);
    }

    /**
     * Show Course by Code
     *
     * Display a Course by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Course::where('code', $code)->firstOrFail();
        return $this->response->item($item, new CourseTransformer);
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
