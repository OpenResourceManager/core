<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/24/15
 * Time: 1:25 PM
 */

use App\Model\Record\Email_Record;
use App\Model\Record\Phone_Record;
use App\Model\Record\Room_Record;
use App\Model\Record\User_Record;
use App\Model\Record\API_Key_Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class UserRecordController extends BaseController
{

    /**
     * @param Request $request
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = API_Key_Record::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(array("success" => true, 'result' => User_Record::all()->take($limit))) : json_encode(array("success" => true, 'result' => User_Record::all()));
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
        $result = API_Key_Record::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = User_Record::where('id', $id)->get()->first();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                $obj->email = Email_Record::where('user', $obj->id)->get();
                $obj->phone = Phone_Record::where('user', $obj->id)->get();
                $obj->room = Room_Record::where('user', $obj->id)->get();
                return json_encode(array('success' => true, 'message' => $obj));
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
        $result = API_Key_Record::testAPIKey($request, 'get');
        if ($result[0]) {

            $obj = User_Record::where('sageid', $sageid)->get()->first();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                $obj->email = Email_Record::where('user', $obj->id)->get();
                $obj->phone = Phone_Record::where('user', $obj->id)->get();
                $obj->room = Room_Record::where('user', $obj->id)->get();
                return json_encode(array('success' => true, 'message' => $obj));
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
        $result = API_Key_Record::testAPIKey($request, 'post');
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
            if (User_Record::where('sageid', $request->input('sageid'))->get()->first()) {
                if (User_Record::where('sageid', $request->input('sageid'))->update($request->input())) {
                    return json_encode(array('success' => true, 'message' => 'update'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not update'));
                }
            } else {
                $model = new User_Record();
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

    /**
     * @param Request $request
     * @return string
     */
    public function del(Request $request)
    {
        $result = API_Key_Record::testAPIKey($request, 'delete');
        if ($result[0]) {
            $validator = Validator::make($request->all(), [
                'id' => 'integer|required',
            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'message' => $validator->errors()->all()));
            }
            if ($model = User_Record::find($request->input('id'))) {
                if ($model->delete()) {
                    return json_encode(array('success' => true, 'message' => 'delete'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not delete.'));
                }
            } else {
                return json_encode(array('success' => false, 'message' => 'Object not found.'));
            }
        } else {
            return json_encode($result[1]);
        }
    }
}
