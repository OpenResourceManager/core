<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Duty;
use App\Http\Transformers\DutyTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DutyController extends ApiController
{

    /**
     * DutyController constructor.
     */
    public function __construct()
    {
        $this->noun = 'duty';
    }

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
     * Store/Update/Restore Duty
     *
     * Create or update Duty information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required|min:3',
            'label' => 'string|required|max:25',
        ]);

        if ($validator->fails()) throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        if ($toRestore = Duty::onlyTrashed()->where('code', $data['code'])->first()) $toRestore->restore();

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
            'code' => 'string|required_without:id|min:3|exists:duties,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|min:1|exists:duties,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors()->all());

        $deleted = (array_key_exists('id', $data)) ? Duty::destroy($data['id']) : Duty::where('code', $data['code'])->firstOrFail()->delete();

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
