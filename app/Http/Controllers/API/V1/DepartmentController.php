<?php

namespace App\Http\Controllers\API\V1;

use App\Events\Api\Department\DepartmentRestored;
use App\Events\Api\Department\DepartmentsViewed;
use App\Events\Api\Department\DepartmentViewed;
use App\Http\Models\API\Department;
use App\Http\Transformers\DepartmentTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends ApiController
{

    /**
     * DepartmentController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'department';
    }

    /**
     * Show all Departments
     *
     * Get a paginated array of Departments.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $departments = Department::paginate($this->resultLimit);
        event(new DepartmentsViewed($departments->pluck('id')->toArray()));
        return $this->response->paginator($departments, new DepartmentTransformer);
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
        event(new DepartmentViewed($item));
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
        event(new DepartmentViewed($item));
        return $this->response->item($item, new DepartmentTransformer);
    }

    /**
     * Store/Update/Restore Department
     *
     * Create or update Department information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'academic' => 'boolean|required',
            'code' => 'string|required|min:3',
            'label' => 'string|required|max:50|min:3',
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        if ($toRestore = Department::onlyTrashed()->where('code', $data['code'])->first()) {
            $toRestore->restore();
        }
        $trans = new DepartmentTransformer();
        $item = Department::updateOrCreate(['code' => $data['code']], $data);
        $item = $trans->transform($item);
        return $this->response->created(route('api.departments.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Department
     *
     * Deletes the specified Department by it's ID or Code attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|exists:departments,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:departments,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = (array_key_exists('id', $data)) ? Department::destroy($data['id']) : Department::where('code', $data['code'])->firstOrFail()->delete();

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
