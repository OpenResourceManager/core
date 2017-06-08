<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Models\API\LoadStatus;
use App\Http\Transformers\LoadStatusTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Events\Api\LoadStatus\LoadStatusesViewed;
use App\Events\Api\LoadStatus\LoadStatusViewed;

class LoadStatusController extends ApiController
{
    /**
     * LoadStatusController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'load status';
    }

    /**
     * Show all Load Statuses
     *
     * Get a paginated array of Load Statuses.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $load_statuses = LoadStatus::paginate($this->resultLimit);
        event(new LoadStatusesViewed($load_statuses->pluck('id')->toArray()));
        return $this->response->paginator($load_statuses, new LoadStatusTransformer);
    }

    /**
     * Show a Load Status
     *
     * Display a Load Status by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = LoadStatus::findOrFail($id);
        event(new LoadStatusViewed($item));
        return $this->response->item($item, new LoadStatusTransformer);
    }

    /**
     * Show Load Status by Code
     *
     * Display a Load Status by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = LoadStatus::where('code', $code)->firstOrFail();
        event(new LoadStatusViewed($item));
        return $this->response->item($item, new LoadStatusTransformer);
    }

    /**
     * Store/Update/Restore Load Status
     *
     * Create or update Load Status information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'code' => 'alpha_dash|required|min:3|max:15',
            'label' => 'string|required|max:50|min:3',
        ]);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());
        }
        if ($toRestore = LoadStatus::onlyTrashed()->where('code', $data['code'])->first()) {
            $toRestore->restore();
        }
        $trans = new LoadStatusTransformer();
        $item = LoadStatus::updateOrCreate(['code' => $data['code']], $data);
        $item = $trans->transform($item);
        return $this->response->created(route('api.load-statuses.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Load Status
     *
     * Deletes the specified Load Status by it's ID or Code attribute.
     *
     * @return mixed
     */
    public function destroy(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|exists:load_statuses,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:load_statuses,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) {
            throw new DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());
        }
        $deleted = (array_key_exists('id', $data)) ? LoadStatus::destroy($data['id']) : LoadStatus::where('code', $data['code'])->firstOrFail()->delete();
        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
