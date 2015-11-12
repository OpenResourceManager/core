<?php namespace App\Http\Controllers\Record;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/11/15
 * Time: 4:58 PM
 */

use App\Model\Record\API_Key_Record;
use App\Model\Record\Community_Record;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class CommunityRecordController extends BaseController
{

    /**
     * @param Request $request
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        $result = API_Key_Record::testAPIKey($request, 'get');
        if ($result[0]) {
            return $limit > 0 ? json_encode(array("success" => true, 'result' => Community_Record::all()->take($limit))) : json_encode(array("success" => true, 'result' => Community_Record::all()));
        } else {
            return json_encode($result[1]);
        }
    }

}