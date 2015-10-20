<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 1:43 PM
 */

use App\Building;
use Laravel\Lumen\Routing\Controller as BaseController;

class BuildingController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get($limit = 0)
    {
        if ($limit > 0) {
            return json_encode(Building::all()->take($limit));
        } else {
            return json_encode(Building::all());
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function getById($id)
    {
        $obj = Building::where('id', $id)->get();
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
        $obj = Building::where('code', $code)->get();
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
     * @param $campusId
     * @return string
     */
    public function getByCampus($campusId)
    {
        $obj = Building::where('campus', $campusId)->get();
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
            'campus' => 'integer|required|max:11|min:1',
            'code' => 'string|required|max:10|min:3|unique:buildings',
            'name' => 'string|required|max:30|min:3'
        ]);

        if ($validator->fails()) {
            return json_encode(array(
                'success' => false,
                'message' => $validator->errors()->all()
            ));
        }

        if (Building::where('code', $request->input('code'))->get()->first()) {
            if (Building::where('code', $request->input('code'))->update($request->input())) {
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
            $model = new Building();

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