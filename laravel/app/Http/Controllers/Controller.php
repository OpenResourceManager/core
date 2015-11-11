<?php namespace App\Http\Controllers;

use App\Model\Record\API_Key_Record;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get(Request $request)
    {
        $result = API_Key_Record::testAPIKey($request, 'get');
        if ($result[0]) {
            return json_encode(array(
                "success" => true,
                'result' => array(
                    'type',
                    'record'
                )
            ));
        } else {
            return json_encode($result[1]);
        }
    }
}
