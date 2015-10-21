<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:46 PM
 */

use App\Email;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\APIKey;

class EmailController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = APIKey::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(Email::all()->take($limit)) : json_encode(Email::all());
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
        $obj = Email::where('id', $id)->get();
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
     * @param $id
     * @return string
     */
    public function getByUser($id)
    {
        $obj = Email::where('user', $id)->get();
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
            'email' => 'email|required|max:60|min:7|unique:emails',
        ]);

        if ($validator->fails()) {
            return json_encode(array(
                'success' => false,
                'message' => $validator->errors()->all()
            ));
        }

        if (Email::where('email', $request->input('email'))->get()->first()) {
            if (Email::where('email', $request->input('email'))->update($request->input())) {
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
            $model = new Email();

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