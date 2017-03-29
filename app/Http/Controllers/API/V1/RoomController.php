<?php

namespace App\Http\Controllers\API\V1;

use App\Events\Api\Room\RoomRestored;
use App\Events\Api\Room\RoomsViewed;
use App\Events\Api\Room\RoomViewed;
use App\Http\Models\API\Building;
use App\Http\Models\API\Room;
use App\Http\Transformers\RoomTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\StoreResourceFailedException;

class RoomController extends ApiController
{
    /**
     * RoomController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'room';
    }

    /**
     * Show all Rooms
     *
     * Get a paginated array of Rooms.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $rooms = Room::paginate($this->resultLimit);
        event(new RoomsViewed($rooms->pluck('id')->toArray()));
        return $this->response->paginator($rooms, new RoomTransformer);
    }

    /**
     * Show a Room
     *
     * Display a Room by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Room::findOrFail($id);
        event(new RoomViewed($item));
        return $this->response->item($item, new RoomTransformer);
    }

    /**
     * Show Room by Code
     *
     * Display a Room by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Room::where('code', $code)->firstOrFail();
        event(new RoomViewed($item));
        return $this->response->item($item, new RoomTransformer);
    }

    /**
     * Store/Update/Restore Room
     *
     * Create or update Room information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'alpha_dash|required|min:3|max:15',
            'floor_number' => 'integer',
            'floor_label' => 'string|max:50|min:3',
            'room_number' => 'integer|required',
            'room_label' => 'string|max:50|min:3',
            'building_id' => 'integer|required_without:building_code|exists:buildings,id,deleted_at,NULL',
            'building_code' => 'string|required_without:building_id|exists:buildings,code,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        /**
         * Translate building code to an id if needed
         */
        if (!array_key_exists('building_id', $data)) {
            if (array_key_exists('building_code', $data)) {
                $data['building_id'] = Building::where('code', $data['building_code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not store ' . $this->noun, ['You must supply one of the following parameters "building_id" or "building_code".']);
            }
        }

        if ($toRestore = Room::onlyTrashed()->where('code', $data['code'])->first()) {
            $toRestore->restore();
        }
        $trans = new RoomTransformer();
        $item = Room::updateOrCreate(['code' => $data['code']], $data);
        $item = $trans->transform($item);
        return $this->response->created(route('api.rooms.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Room
     *
     * Deletes the specified Room by it's ID or Code attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|exists:rooms,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:rooms,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = (array_key_exists('id', $data)) ? Room::destroy($data['id']) : Room::where('code', $data['code'])->firstOrFail()->delete();
        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
