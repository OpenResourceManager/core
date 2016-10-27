<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Duty;
use App\Http\Transformers\DutyTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

/**
 * Class DutyController
 * @package App\Http\Controllers\API\V1
 *
 * @Resource("Duties", uri="/duties")
 */
class DutyController extends ApiController
{
    /**
     * @return \Dingo\Api\Http\Response
     *
     * @Get("/")
     */
    public function index()
    {
        $duties = Duty::paginate($this->resultLimit);

        return $this->response->paginator($duties, new DutyTransformer);
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response
     *
     * @Get("/{id}")
     */
    public function show($id)
    {
        $duty = Duty::findOrFail($id);

        return $this->response->item($duty, new DutyTransformer);
    }

    /**
     * @param $code
     * @return \Dingo\Api\Http\Response
     *
     * @Get("/code/{id}")
     */
    public function showFromCode($code)
    {
        $duty = Duty::where('code', $code)->firstOrFail();

        return $this->response->item($duty, new DutyTransformer);
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     *
     * @Post("/")
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'string|required|min:3|unique:duties,deleted_at,NULL',
            'name' => 'string|required|max:25',
        ]);

        if ($validator->fails()) throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store duty.', $validator->errors());

        Duty::where('code', Input::get('code'))->onlyTrashed()->restore();

        $data = [
            'label' => Input::get('name'),
            'code' => Input::get('code')
        ];

        $item = Duty::updateOrCreate(['code' => Input::get('code')], $data);

        return $this->response->created(route('api.duties.show', ['id' => $item->id]), $item);
    }

    /**
     * @param $id
     * @return mixed|void
     *
     * @Delete("/{id}")
     */
    public function destroy($id)
    {
        $duty = Duty::findOrFail($id);

        return ($duty->delete()) ? $this->destroySuccessResponse() : $this->destroyFailure('duty');
    }

    /**
     * @param $code
     * @return mixed|void
     *
     * @Delete("/code/{code}")
     */
    public function destroyFromCode($code)
    {
        $duty = Duty::where('code', $code)->firstOrFail();

        return ($duty->delete()) ? $this->destroySuccessResponse() : $this->destroyFailure('duty');
    }
}
