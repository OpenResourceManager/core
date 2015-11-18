<?php

namespace App\Http\Controllers;

use App\Model\Building;
use App\Model\Campus;
use App\Model\Room;
use App\Model\User;
use App\UUD\Transformers\RoomTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class RoomController extends ApiController
{
    /**
     * @var RoomTransformer
     */
    protected $roomTransformer;

    /**
     * @param RoomTransformer $roomRecordTransformer
     */
    function __construct(RoomTransformer $roomTransformer)
    {
        $this->roomTransformer = $roomTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        parent::index($request);
        $result = Room::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'building_id' => 'integer|required|exists:buildings,id,deleted_at,NULL',
            'floor_number' => 'integer',
            'floor_name' => 'string|max:20',
            'room_number' => 'integer|required',
            'room_name' => 'string|max:50'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Room::create(Input::all());
        return $this->respondCreateSuccess($id = $item->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Room::findOrFail($id);
        return $this->respondWithSuccess($this->roomTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function campusRooms($id, Request $request)
    {
        $result = Campus::findOrFail($id)->rooms()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function buildingRooms($id, Request $request)
    {
        $result = Building::findOrFail($id)->rooms()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function userRooms($id, Request $request)
    {
        $result = User::findOrFail($id)->rooms()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function userRoomsByUserId($user_id, Request $request)
    {
        $result = User::findOrFail(['user_identifier' => $user_id])->rooms()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }
}
