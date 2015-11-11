<?php namespace App\Http\Controllers\Type;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 1:42 PM
 */

use App\Model\Campus;
use App\Model\Record\API_Key_Record;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class CampusController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = API_Key_Record::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(array("success" => true, 'result' => Campus::all()->take($limit))) : json_encode(array("success" => true, 'result' => Campus::all()));
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function getById(Request $request, $id)
    {
        $result = API_Key_Record::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Campus::where('id', $id)->get();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                return json_encode(array('success' => true, 'message' => $obj));
            } else {
                return json_encode(array("success" => false, "error" => "NotFound"));
            }
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @param $code
     * @return string
     */
    public function getByCode(Request $request, $code)
    {
        $result = API_Key_Record::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Campus::where('code', $code)->get();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                return json_encode(array('success' => true, 'message' => $obj));
            } else {
                return json_encode(array("success" => false, "error" => "NotFound"));
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
                'code' => 'string|required|max:10|min:3|unique:campuses',
                'name' => 'string|required|max:30|min:3'
            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'message' => $validator->errors()->all()));
            }
            if (Campus::where('code', $request->input('code'))->get()->first()) {
                if (Campus::where('code', $request->input('code'))->update($request->input())) {
                    return json_encode(array('success' => true, 'message' => 'update'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not update'));
                }
            } else {
                $model = new Campus();
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
            if ($model = Campus::find($request->input('id'))) {
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
