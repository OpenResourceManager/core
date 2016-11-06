<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Room;
use App\Http\Transformers\RoomTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends ApiController
{
    /**
     * RoomController constructor.
     */
    public function __construct()
    {
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
        $accounts = Room::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new RoomTransformer);
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
            'code' => 'string|required|min:3',
            'floor_number' => 'integer',
            'floor_name' => 'string|max:20',
            'room_number' => 'integer|required',
            'room_name' => 'string|max:50',
            'building_id' => 'integer|required_without:building_code|exists:buildings,id,deleted_at,NULL',
            'building_code' => 'integer|required_without:building_id|exists:buildings,code,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        if ($toRestore = Room::onlyTrashed()->where('code', $data['code'])->first()) $toRestore->restore();
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
            'code' => 'string|required_without:id|min:3|exists:rooms,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|min:1|exists:rooms,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = (array_key_exists('id', $data)) ? Room::destroy($data['id']) : Room::where('code', $data['code'])->firstOrFail()->delete();
        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
