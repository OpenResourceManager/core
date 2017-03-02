<?php

namespace App\Http\Controllers\API\V1;

use App\Events\Api\Building\BuildingRestored;
use App\Events\Api\Building\BuildingsViewed;
use App\Events\Api\Building\BuildingViewed;
use App\Http\Models\API\Building;
use App\Http\Models\API\Campus;
use App\Http\Transformers\BuildingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\StoreResourceFailedException;

class BuildingController extends ApiController
{

    /**
     * BuildingController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
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
        $buildings = Building::paginate($this->resultLimit);
        event(new BuildingsViewed($buildings->pluck('id')->toArray()));
        return $this->response->paginator($buildings, new BuildingTransformer);
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
        event(new BuildingViewed($item));
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
        event(new BuildingViewed($item));
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
            'campus_id' => 'integer|required_without:campus_code|exists:campuses,id,deleted_at,NULL',
            'campus_code' => 'string|required_without:campus_id|exists:campuses,code,deleted_at,NULL',
            'code' => 'string|required|max:15|min:3',
            'label' => 'string|required|max:50|min:3'
        ]);

        if ($validator->fails())
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        if ($toRestore = Building::onlyTrashed()->where('code', $data['code'])->first()) {
            $toRestore->restore();
        }

        /**
         * Translate campus code to an id if needed
         */
        if (!array_key_exists('campus_id', $data)) {
            if (array_key_exists('campus_code', $data)) {
                $data['campus_id'] = Campus::where('code', $data['campus_code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not store ' . $this->noun, ['You must supply one of the following parameters "campus_id" or "campus_code".']);
            }
        }

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
            'code' => 'string|required_without:id|exists:buildings,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:buildings,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());
        $deleted = (array_key_exists('id', $data)) ? Building::destroy($data['id']) : Building::where('code', $data['code'])->firstOrFail()->delete();
        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
