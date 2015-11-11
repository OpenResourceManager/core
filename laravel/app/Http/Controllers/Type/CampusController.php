<?php namespace App\Http\Controllers\Type;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 1:42 PM
 */

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Model\Type\Campus;

class CampusController extends BaseController
{

    public function index()
    {
        return Campus::all();
    }

}
