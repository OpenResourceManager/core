<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/24/15
 * Time: 1:25 PM
 */

use App\Email;
use App\Phone;
use App\Room;
use App\User;
use App\APIKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    /**
     * @param Request $request
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(User::all()->take($limit)) : json_encode(User::all());
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return string
     */
    public function getById(Request $request, $id)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = User::where('id', $id)->get()->first();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                $obj->email = Email::where('user', $obj->id)->get(array('email'));
                $obj->phone = Phone::where('user', $obj->id)->get(array('number', 'ext'));
                $obj->room = Room::where('user', $obj->id)->get(array('building', 'floor_number', 'floor_name', 'room_number', 'room_name'));
                return json_encode($obj);
            } else {
                return json_encode(
                    array("success" => false, "message" => "NotFound"));
            }
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @param Request $request
     * @param $sageid
     * @return string
     */
    public function getBySageID(Request $request, $sageid)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {

            $obj = User::where('sageid', $sageid)->get()->first();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                $obj->email = Email::where('user', $obj->id)->get(array('email'));
                $obj->phone = Phone::where('user', $obj->id)->get(array('number', 'ext'));
                $obj->room = Room::where('user', $obj->id)->get(array('building', 'floor_number', 'floor_name', 'room_number', 'room_name'));
                return json_encode($obj);
            } else {
                return json_encode(array("success" => false, "message" => "NotFound"));
            }
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function post(Request $request)
    {
        $result = APIKey::testAPIKey($request, 'post');
        if ($result[0]) {
            $validator = Validator::make($request->all(), [
                'sageid' => 'integer|required|max:7|min:6|unique:users',
                'active' => 'boolean|required|max:5|min:1',
                'name_prefix' => 'string',
                'name_first' => 'string|required|min:1',
                'name_middle' => 'string',
                'name_last' => 'string|required|min:1',
                'name_phonetic' => 'string',
                'username' => 'string|required|max:11|min:3|unique:users'
            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'message' => $validator->errors()->all()));
            }
            if (User::where('sageid', $request->input('sageid'))->get()->first()) {
                if (User::where('sageid', $request->input('sageid'))->update($request->input())) {
                    return json_encode(array('success' => true, 'message' => 'update'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not update'));
                }
            } else {
                $model = new User();
                foreach ($request->input() as $key => $value) {
                    $model->$key = $value;
                }
                $save = $model->save() ? true : false;
                return json_encode(array('success' => $save, 'message' => $save ? 'create' : $model->errors()->all()));
            }
        } else {
            return json_encode($result[1]);
        }
    }
}
