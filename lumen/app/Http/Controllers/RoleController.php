<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 1:41 PM
 */

use App\Role;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\APIKey;

class RoleController extends BaseController
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
                        return json_encode(Role::all()->take($limit));
                    } else {
                        return json_encode(Role::all());
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
        $obj = Role::where('id', $id)->get();
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
     * @param $code
     * @return string
     */
    public function getByCode($code)
    {
        $obj = Role::where('code', $code)->get();
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
            'code' => 'string|required|max:50|min:3|unique:programs',
            'name' => 'string|required|max:50|min:3|unique:programs',

        ]);

        if ($validator->fails()) {
            return json_encode(array(
                'success' => false,
                'message' => $validator->errors()->all()
            ));
        }

        if (Role::where('code', $request->input('code'))->get()->first()) {
            if (Role::where('code', $request->input('code'))->update($request->input())) {
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
            $model = new Role();

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