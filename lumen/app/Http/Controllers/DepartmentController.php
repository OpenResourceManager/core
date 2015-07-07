<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 2:23 PM
 */

use App\Department;
use Laravel\Lumen\Routing\Controller as BaseController;


class DepartmentController extends BaseController
{

    /**
     * @param int $limit
     * @return string
     */
    public function get($limit = 0)
    {
        if ($limit > 0) {
            return json_encode(Department::all()->take($limit));
        } else {
            return json_encode(Department::all());
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function getById($id)
    {
        $obj = Department::where('id', $id)->get();
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
        $obj = Department::where('code', $code)->get();
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
}