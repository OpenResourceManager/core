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
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get($limit = 0)
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
        $obj = User::where('id', $id)->get();
        if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
            $obj->email = Email::where('user', $obj->id)->get();
            $obj->phone = Phone::where('user', $obj->id)->get();
            $obj->room = Room::where('user', $obj->id)->get();
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
     * @param $sageid
     * @return string
     */
    public function getBySageID($sageid)
    {
        $obj = User::where('sageid', $sageid)->get();
        if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
            $obj->email = Email::where('user', $obj->id)->get();
            $obj->phone = Phone::where('user', $obj->id)->get();
            $obj->room = Room::where('user', $obj->id)->get();
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
