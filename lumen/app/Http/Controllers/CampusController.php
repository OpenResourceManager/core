<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 1:42 PM
 */


use App\Campus;
use Laravel\Lumen\Routing\Controller as BaseController;

class CampusController extends BaseController
{

    /**
     * @param int $limit
     * @return string
     */
    public function get($limit = 0)
    {
        if ($limit > 0) {
            return json_encode(Campus::all()->take($limit));
        } else {
            return json_encode(Campus::all());
        }
    }

}