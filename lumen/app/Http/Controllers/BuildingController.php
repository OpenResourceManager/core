<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 1:43 PM
 */

use App\Building;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\APIKey;

class BuildingController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get(Request $request, $limit = 0)
    {
        if ($request->header('X-Authorization')) {
            $key = APIKey::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                if ($key->get) {
                    if ($limit > 0) {
                        return json_encode(Building::all()->take($limit));
                    } else {
                        return json_encode(Building::all());
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

    /**
     * @param Request $request
     * @param $id
     * @return string
     */
    public function getById(Request $request, $id)
    {
        if ($request->header('X-Authorization')) {
            $key = APIKey::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                if ($key->get) {
                    $obj = Building::where('id', $id)->get();
                    if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                        return json_encode($obj);
                    } else {
                        return json_encode(
                            array(
                                "success" => false,
                                "error" => "NotFound"
                            )
                        );
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

    /**
     * @param $code
     * @return string
     */
    public function getByCode(Request $request, $code)
    {
        if ($request->header('X-Authorization')) {
            $key = APIKey::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                if ($key->get) {
                    $obj = Building::where('code', $code)->get();
                    if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                        return json_encode($obj);
                    } else {
                        return json_encode(
                            array(
                                "success" => false,
                                "error" => "NotFound"
                            )
                        );
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

    /**
     * @param $campusId
     * @return string
     */
    public function getByCampus(Request $request, $campusId)
    {
        if ($request->header('X-Authorization')) {
            $key = APIKey::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                if ($key->get) {
                    $obj = Building::where('campus', $campusId)->get();
                    if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
                        return json_encode($obj);
                    } else {
                        return json_encode(
                            array(
                                "success" => false,
                                "error" => "NotFound"
                            )
                        );
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

    /**
     * @param Request $request
     * @return string
     */
    public function post(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = APIKey::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                if ($key->post) {

                    $validator = Validator::make($request->all(), [
                        'campus' => 'integer|required|max:11|min:1',
                        'code' => 'string|required|max:10|min:3|unique:buildings',
                        'name' => 'string|required|max:30|min:3'
                    ]);

                    if ($validator->fails()) {
                        return json_encode(array(
                            'success' => false,
                            'message' => $validator->errors()->all()
                        ));
                    }

                    if (Building::where('code', $request->input('code'))->get()->first()) {
                        if (Building::where('code', $request->input('code'))->update($request->input())) {
                            return json_encode(array(
                                'success' => true,
                                'message' => 'update'
                            ));
                        } else {
                            return json_encode(array(
                                'success' => false,
                                'message' => 'Could not update'
                            ));
                        }

                    } else {
                        $model = new Building();

                        foreach ($request->input() as $key => $value) {
                            $model->$key = $value;
                        }

                        if ($model->save()) {
                            return json_encode(array(
                                'success' => true,
                                'message' => 'create'
                            ));
                        } else {
                            return json_encode(array(
                                'success' => false,
                                'message' => $model->errors()->all()
                            ));
                        }
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