<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Room;
use App\Http\Transformers\RoomTransformer;
use Illuminate\Http\Request;

class RoomController extends ApiController
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
}
