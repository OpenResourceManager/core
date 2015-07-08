<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:46 PM
 */

use App\Email;
use Laravel\Lumen\Routing\Controller as BaseController;

class EmailController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get($limit = 0)
    {
        if ($limit > 0) {
            return json_encode(Email::all()->take($limit));
        } else {
            return json_encode(Email::all());
        }
    }

}