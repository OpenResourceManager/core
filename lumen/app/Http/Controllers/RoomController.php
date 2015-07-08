<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:45 PM
 */

use App\Room;
use Laravel\Lumen\Routing\Controller as BaseController;

class RoomController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get($limit = 0)
    {
        if ($limit > 0) {
            return json_encode(Room::all()->take($limit));
        } else {
            return json_encode(Room::all());
        }
    }

}