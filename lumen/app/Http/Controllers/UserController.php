<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/24/15
 * Time: 1:25 PM
 */

namespace App\Http\Controllers;

use App\User;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{

    /**
     * @param int $limit
     * @return string
     */
    public function getUsers($limit = 0)
    {
        if ($limit > 0) {
            return json_encode(User::all()->take($limit));
        } else {
            return json_encode(User::all());
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function getById($id)
    {
        if ($user = User::where('id', $id)->get()) {
            return json_encode($user);
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
     * @param $sageid
     * @return string
     */
    public function getBySageID($sageid)
    {
        if ($user = User::where('sageid', $sageid)->get()) {
            return json_encode($user);
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