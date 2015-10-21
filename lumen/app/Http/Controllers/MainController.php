<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\APIKey;

class MainController extends BaseController
{
    /**
     * @param $request
     * @param $limit
     * @param $model
     * @return string
     */
    public function get($request, $limit, $model)
    {
        if ($request->header('X-Authorization')) {
            $key = APIKey::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                if ($key->get) {
                    if ($limit > 0) {
                        return json_encode($model::all()->take($limit));
                    } else {
                        return json_encode($model::all());
                    }
                } else {
                    return json_encode(
                        array(
                            "success" => false,
                            "error" => "X-Authorization: Insufficient pillages"
                        )
                    );
                }
            } else {
                return json_encode(
                    array(
                        "success" => false,
                        "error" => "X-Authorization: API Key is not valid"
                    )
                );
            }
        } else {
            return json_encode(
                array(
                    "success" => false,
                    "error" => "Header Option Not Found: 'X-Authorization'"
                )
            );
        }
    }
}
