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
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        if ($request->header('X-Authorization')) {
            $key = APIKey::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                if ($key->get) {
                    if ($limit > 0) {
                        return json_encode(User::all()->take($limit));
                    } else {
                        return json_encode(User::all());
                    }
                } else {
                    return json_encode(
                        array(
                            "success" => false,
                            "error" => "X-Authorization: Insufficient pillages"
                        )
                    );
                }
            } else {
                return json_encode(
                    array(
                        "success" => false,
                        "error" => "X-Authorization: API Key is not valid"
                    )
                );
            }
        } else {
            return json_encode(
                array(
                    "success" => false,
                    "error" => "Header Option Not Found: 'X-Authorization'"
                )
            );
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function getById($id)
    {
        $obj = User::where('id', $id)->get()->first();
        if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
            $obj->email = Email::where('user', $obj->id)->get(array('email'));
            $obj->phone = Phone::where('user', $obj->id)->get(array('number', 'ext'));
            $obj->room = Room::where('user', $obj->id)->get(array('building', 'floor_number', 'floor_name', 'room_number', 'room_name'));
            return json_encode($obj);
        } else {
            return json_encode(
                array(
                    "success" => false,
                    "message" => "NotFound"
                )
            );
        }
    }

    /**
     * @param $sageid
     * @return string
     */
    public function getBySageID($sageid)
    {
        $obj = User::where('sageid', $sageid)->get()->first();
        if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
            $obj->email = Email::where('user', $obj->id)->get(array('email'));
            $obj->phone = Phone::where('user', $obj->id)->get(array('number', 'ext'));
            $obj->room = Room::where('user', $obj->id)->get(array('building', 'floor_number', 'floor_name', 'room_number', 'room_name'));
            return json_encode($obj);
        } else {
            return json_encode(
                array(
                    "success" => false,
                    "message" => "NotFound"
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
            return json_encode(array(
                'success' => false,
                'message' => $validator->errors()->all()
            ));
        }

        if (User::where('sageid', $request->input('sageid'))->get()->first()) {
            if (User::where('sageid', $request->input('sageid'))->update($request->input())) {
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
            $model = new User();

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
