<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Duty;
use App\Http\Transformers\DutyTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DutyController extends ApiController
{
    /**
     * Show all Duty resources
     *
     * Get a paginated array of Duties.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $duties = Duty::paginate($this->resultLimit);
        return $this->response->paginator($duties, new DutyTransformer);
    }

    /**
     * Show a Duty
     *
     * Display a Duty by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Duty::findOrFail($id);
        return $this->response->item($item, new DutyTransformer);
    }

    /**
     * Show Duty by Code
     *
     * Display a Duty by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Duty::where('code', $code)->firstOrFail();
        return $this->response->item($item, new DutyTransformer);
    }

    /**
     * Store/Save/Restore Duty
     *
     * Create or update duty information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required|min:3|unique:duties,deleted_at,NULL',
            'label' => 'string|required|max:25',
        ]);

        if ($validator->fails()) throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store duty.', $validator->errors());

        if ($toRestore = Duty::onlyTrashed()->where('code', $data['code'])->first()) {
            $toRestore->restore();
        }

        $trans = new DutyTransformer();

        $item = Duty::updateOrCreate(['code' => $data['code']], $data);

        $item = $trans->transform($item);

        return $this->response->created(route('api.duties.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Duty
     *
     * Deletes the specified Duty by it's ID or Code attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|min:3|exists:duties,deleted_at,NULL',
            'id' => 'integer|required_without:code|min:1|exists:duties,deleted_at,NULL'
        ]);
        /**
         * @todo fix validation
         */
        #if ($validator->fails()) throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy duty.', $validator->errors());

        $duty = (array_key_exists('id', $data)) ? Duty::findOrFail($data['id']) : Duty::where('code', $data['code'])->firstOrFail();

        return ($duty->delete()) ? $this->destroySuccessResponse() : $this->destroyFailure('duty');
    }
}
