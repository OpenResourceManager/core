<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/20/15
 * Time: 3:15 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class APIKey extends Model
{
    use SoftDeletes;
    protected $table = 'apikeys';
    protected $dates = ['deleted_at'];

    /**
     * @param string $key
     * @return mixed
     */
    public static function getAPIKey($key = '')
    {
        return APIKey::where('key', $key)->get()->first();
    }

    /**
     * @param $request
     * @param $method
     * @return array
     */
    public static function testAPIKey($request, $method)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch ($method) {
                    case 'get' :
                        return $key->can_get ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    /* case 'put':
                         return $key->can_put ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges"));
                         break; */
                    case 'delete':
                        return $key->can_delete ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges"));
                        break;
                    default :
                        return array(false, array("success" => false, "error" => "Method not found."));
                }
            } else {
                return array(false, array("success" => false, "error" => "X-Authorization: API Key is not valid."));
            }
        } else {
            return array(false, array("success" => false, "error" => "X-Authorization: Header Option Not Found."));
        }
    }
}