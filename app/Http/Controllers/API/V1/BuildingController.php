<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Building;
use App\Http\Transformers\BuildingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuildingController extends ApiController
{

    /**
     * BuildingController constructor.
     */
    public function __construct()
    {
        $this->noun = 'building';
    }

    /**
     * Show all Buildings
     *
     * Get a paginated array of Buildings.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Building::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new BuildingTransformer);
    }

    /**
     * Show a Building
     *
     * Display a Building by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Building::findOrFail($id);
        return $this->response->item($item, new BuildingTransformer);
    }

    /**
     * Show Building by Code
     *
     * Display a Building by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Building::where('code', $code)->firstOrFail();
        return $this->response->item($item, new BuildingTransformer);
    }

    /**
     * Store/Update/Restore Building
     *
     * Create or update Building information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'campus_id' => 'integer|required|exists:campuses,id,deleted_at,NULL',
            'code' => 'string|required|max:10|min:3',
            'label' => 'string|required|max:30|min:3'
        ]);

        if ($validator->fails()) throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        if ($toRestore = Building::onlyTrashed()->where('code', $data['code'])->first()) $toRestore->restore();

        $trans = new BuildingTransformer();

        $item = Building::updateOrCreate(['code' => $data['code']], $data);

        $item = $trans->transform($item);

        return $this->response->created(route('api.buildings.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Building
     *
     * Deletes the specified Building by it's ID or Code attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|min:3|exists:buildings,deleted_at,NULL',
            'id' => 'integer|required_without:code|min:1|exists:buildings,deleted_at,NULL'
        ]);

        if ($validator->fails()) throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $item = (array_key_exists('id', $data)) ? Building::findOrFail($data['id']) : Building::where('code', $data['code'])->firstOrFail();

        return ($item->delete()) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
