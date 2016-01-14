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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Room::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
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
    public function show($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Room::findOrFail($id);
        return $this->respondWithSuccess($this->roomTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        Room::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function campusRooms($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Campus::findOrFail($id)->rooms()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * @param $code
     * @param Request $request
     * @return mixed
     */
    public function campusRoomsByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Campus::where('code', $code)->firstOrFail()->rooms()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function buildingRooms($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Building::findOrFail($id)->rooms()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * @param $code
     * @param Request $request
     * @return mixed
     */
    public function buildingRoomsByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Building::where('code', $code)->firstOrFail()->rooms()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function userRooms($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->rooms()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function userRoomsByUserId($user_id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('user_identifier', $user_id)->firstOrFail()->rooms()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userRoomsByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->rooms()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->roomTransformer->transformCollection($result->all()));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserRoom(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user' => 'integer|required|exists:users,id,deleted_at,NULL',
            'room' => 'integer|required|exists:room,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user'));
        $room = Room::findOrFail($request->input('room'));
        if (!$user->roles->contains($room->id)) {
            $user->rooms()->attach($room);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserRoomByUserId(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'string|required|exists:users,user_identifier,deleted_at,NULL',
            'room' => 'integer|required|exists:rooms,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('user_identifier', $request->input('user_id'))->firstOrFail();
        $room = Room::findOrFail($request->input('room'));
        if (!$user->rooms->contains($room->id)) {
            $user->rooms()->attach($room);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUserRoomByUsername(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'room' => 'integer|required|exists:rooms,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $room = Room::findOrFail($request->input('room'));
        if (!$user->rooms->contains($room->id)) {
            $user->rooms()->attach($room);
            return $this->respondAssignmentSuccess($message = 'Assigned', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Already Present', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        }
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserRoom(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user' => 'integer|required|exists:users,id,deleted_at,NULL',
            'room' => 'integer|required|exists:rooms,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user'));
        $room = Room::findOrFail($request->input('room'));
        if ($user->rooms->contains($room->id)) {
            $user->rooms()->detach($room);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserRoomByUserId(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'string|required|exists:users,user_identifier,deleted_at,NULL',
            'room' => 'integer|required|exists:rooms,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('user_identifier', $request->input('user_id'))->firstOrFail();
        $room = Room::findOrFail($request->input('room'));
        if ($user->rooms->contains($room->id)) {
            $user->rooms()->detach($room);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unassignUserRoomByUsername(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'room' => 'integer|required|exists:rooms,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $room = Room::findOrFail($request->input('room'));
        if ($user->rooms->contains($room->id)) {
            $user->rooms()->detach($room);
            return $this->respondAssignmentSuccess($message = 'Unassigned', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        } else {
            return $this->respondAssignmentSuccess($message = 'Assignment Not Present', $id = ['user' => intval($user->id), 'room' => intval($room->id)]);
        }
    }
}
