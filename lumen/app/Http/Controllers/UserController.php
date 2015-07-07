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

    public function getUsers($limit = 0)
    {
        if ($limit > 0) {
            return json_encode(User::all()->take($limit));
        } else {
            return json_encode(User::all());
        }
    }

    public function getUser($id)
    {

    }


}