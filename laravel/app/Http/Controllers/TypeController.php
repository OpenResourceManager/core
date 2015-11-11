<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/11/15
 * Time: 4:22 PM
 */

use App\Model\Record\API_Key_Record;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class TypeController
{

    public function get(Request $request)
    {
        $result = API_Key_Record::testAPIKey($request, 'get');
        if ($result[0]) {
            return json_encode(array(
                "success" => true,
                'result' => array(
                    'community',
                    'campus',
                    'building',
                    'department',
                    'course',
                    'role',
                    'user'
                )
            ));
        } else {
            return json_encode($result[1]);
        }
    }

}