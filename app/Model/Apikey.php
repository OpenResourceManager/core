<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/20/15
 * Time: 3:15 PM
 */

/**
 * @TODO: API Key control for addresses
 * @TODO: API Key control for buildings
 * @TODO: API Key control for campuses
 * @TODO: API Key control for countries
 * @TODO: API Key control for courses
 * @TODO: API Key control for departments
 * @TODO: API Key control for emails
 * @TODO: API Key control for phones
 * @TODO: API Key control for roles
 * @TODO: API Key control for rooms
 * @TODO: API Key control for state
 * @TODO: API Key control for users
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apikey extends Model
{
    use SoftDeletes;
    protected $table = 'api_keys';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'app_name',
        'key',
        'can_get',
        'can_post',
        'can_put',
        'can_delete',
        'can_view_password',
        'can_edit_password'
    ];

    /**
     * @param string $key
     * @return mixed
     */
    protected static function getAPIKey($key = '')
    {
        return Apikey::where('key', $key)->get()->first();
    }


    /**
     * @param $request
     * @return array
     */
    public static function testPasswordPermissions($request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_view_password ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_edit_password ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_edit_password ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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

    /**
     * @param $request
     * @return array
     */
    public static function testAPIKey($request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
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