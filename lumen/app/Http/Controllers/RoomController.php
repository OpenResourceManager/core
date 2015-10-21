<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:45 PM
 */

use App\Room;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\APIKey;

class RoomController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(Room::all()->take($limit)) : json_encode(Room::all());
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function getById($id)
    {
        $obj = Room::where('id', $id)->get();
        if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
            return json_encode($obj);
        } else {
            return json_encode(
                array(
                    "success" => false,
                    "error" => "NotFound"
                )
            );
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function post(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user' => 'integer|required|max:11|min:1',
            'building' => 'integer|required|max:11|min:1',
            'floor_number' => 'integer|max:4|min:1',
            'floor_name' => 'string|max:50|min:1',
            'room_number' => 'integer|required|max:4|min:1',
            'room_name' => 'integer|max:50|min:1',
        ]);

        if ($validator->fails()) {
            return json_encode(array(
                'success' => false,
                'message' => $validator->errors()->all()
            ));
        }

        if (Room::where('room_number', $request->input('room_number'))->where('building', $request->input('building'))->get()->first() ) {
            if (Room::where('room_number', $request->input('room_number'))->where('building', $request->input('building'))->update($request->input())) {
                return json_encode(array(
                    'success' => true,
                    'message' => 'update'
                ));
            } else {
                return json_encode(array(
                    'success' => false,
                    'message' => 'Could not update'
                ));
            }

        } else {
            $model = new Room();

            foreach ($request->input() as $key => $value) {
                $model->$key = $value;
            }

            if ($model->save()) {
                return json_encode(array(
                    'success' => true,
                    'message' => 'create'
                ));
            } else {
                return json_encode(array(
                    'success' => false,
                    'message' => $model->errors()->all()
                ));
            }
        }
    }

}