<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/11/15
 * Time: 4:17 PM
 */

use App\Model\Record\API_Key_Record;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class RecordController extends BaseController
{

    public function get(Request $request)
    {
        $result = API_Key_Record::testAPIKey($request, 'get');
        if ($result[0]) {
            return json_encode(array(
                "success" => true,
                'result' => array(
                    'room',
                    'email',
                    'phone',
                    'community',
                    'course',
                    'department',
                    'role',
                    'user'
                )
            ));
        } else {
            return json_encode($result[1]);
        }
    }

}