<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 2:26 PM
 */

use App\Program;
use App\APIKey;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ProgramController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(Program::all()->take($limit)) : json_encode(Program::all());
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
            $obj = Program::where('id', $id)->get();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                return json_encode($obj);
            } else {
                return json_encode(array("success" => false, "error" => "NotFound"));
            }
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @param Request $request
     * @param $code
     * @return string
     */
    public function getByCode(Request $request, $code)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Program::where('code', $code)->get();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                return json_encode($obj);
            } else {
                return json_encode(array("success" => false, "error" => "NotFound"));
            }
        } else {
            return json_encode($result[1]);
        }
    }

    /**
     * @param Request $request
     * @param $departmentId
     * @return string
     */
    public function getByDepartment(Request $request, $departmentId)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            $obj = Program::where('department', $departmentId)->get();
            if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                return json_encode($obj);
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
        $result = APIKey::testAPIKey($request, 'post');
        if ($result[0]) {
            $validator = Validator::make($request->all(), [
                'department' => 'integer|required|max:11|min:1',
                'code' => 'string|required|max:50|min:3|unique:programs',
                'name' => 'string|required|max:50|min:3|unique:programs',

            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'message' => $validator->errors()->all()));
            }
            if (Program::where('code', $request->input('code'))->get()->first()) {
                if (Program::where('code', $request->input('code'))->update($request->input())) {
                    return json_encode(array('success' => true, 'message' => 'update'));
                } else {
                    return json_encode(array('success' => false, 'message' => 'Could not update'));
                }
            } else {
                $model = new Program();
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