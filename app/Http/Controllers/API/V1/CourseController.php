<?php

namespace App\Http\Controllers\API\V1;

use App\Events\Api\Course\CoursesViewed;
use App\Events\Api\Course\CourseViewed;
use App\Http\Models\API\Course;
use App\Http\Models\API\Department;
use App\Http\Transformers\CourseTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends ApiController
{

    /**
     * CourseController constructor
     */
    public function __construct()
    {
        $this->noun = 'course';
    }

    /**
     * Show all Courses
     *
     * Get a paginated array of Courses.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $courses = Course::paginate($this->resultLimit);
        event(new CoursesViewed($courses->pluck('id')->toArray()));
        return $this->response->paginator($courses, new CourseTransformer);
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
        event(new CourseViewed($item));
        return $this->response->item($item, new CourseTransformer);
    }

    /**
     * Show a Course from Code
     *
     * Display a Course by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Course::where('code', $code)->firstOrFail();
        event(new CourseViewed($item));
        return $this->response->item($item, new CourseTransformer);
    }

    /**
     * Store/Update/Restore Course
     *
     * Create or update Course information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'department_id' => 'integer|min:1|required_without:department_code|exists:departments,id,deleted_at,NULL',
            'department_code' => 'string|min:3|required_without:department_id|exists:departments,code,deleted_at,NULL',
            'code' => 'string|required|min:3',
            'course_level' => 'integer|required',
            'label' => 'string|required|min:5',
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        if (!array_key_exists('department_id', $data)) {
            if (array_key_exists('department_code', $data)) {
                $data['department_id'] = Department::where('code', $data['department_code'])->firstOrFail()->id;
            } else {
                throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', [
                    'No department_id was provided.',
                    'No department_code was provided.',
                    'You must supply either a department id or department code.'
                ]);
            }
        }

        if ($toRestore = Course::onlyTrashed()->where('code', $data['code'])->first()) $toRestore->restore();
        $trans = new CourseTransformer();
        $item = Course::updateOrCreate(['code' => $data['code']], $data);
        $item = $trans->transform($item);
        return $this->response->created(route('api.courses.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Course
     *
     * Deletes the specified Course by it's ID or Code attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|exists:courses,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:courses,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = (array_key_exists('id', $data)) ? Course::destroy($data['id']) : Course::where('code', $data['code'])->firstOrFail()->delete();

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
