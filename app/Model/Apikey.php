<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/20/15
 * Time: 3:15 PM
 */

use Illuminate\Http\Request;
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
        'can_delete',
        'can_get_address',
        'can_post_address',
        'can_delete_address',
        'can_get_building',
        'can_post_building',
        'can_delete_building',
        'can_get_campus',
        'can_post_campus',
        'can_delete_campus',
        'can_get_country',
        'can_post_country',
        'can_delete_country',
        'can_get_course',
        'can_post_course',
        'can_delete_course',
        'can_get_department',
        'can_post_department',
        'can_delete_department',
        'can_get_email',
        'can_post_email',
        'can_delete_email',
        'can_get_password',
        'can_post_password',
        'can_delete_password',
        'can_get_birth_date',
        'can_post_birth_date',
        'can_delete_birth_date',
        'can_get_phone',
        'can_post_phone',
        'can_delete_phone',
        'can_get_role',
        'can_post_role',
        'can_delete_role',
        'can_get_room',
        'can_post_room',
        'can_delete_room',
        'can_get_state',
        'can_post_state',
        'can_delete_state',
        'can_get_user',
        'can_post_user',
        'can_delete_user',
        'can_get_mobile_carrier',
        'can_post_mobile_carrier',
        'can_delete_mobile_carrier',
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
     * @param Request $request
     * @param $type
     */
    public static function testAPIKey(Request $request, $type)
    {
        $global = self::testGlobalPermission($request);
        if ($global[0]) {
            return $global;
        } else {
            switch ($type) {
                case 'address':
                    return self::testAddressPermissions($request);
                    break;
                case 'building':
                    return self::testBuildingPermissions($request);
                    break;
                case 'campus':
                    return self::testCampusPermissions($request);
                    break;
                case 'country':
                    return self::testCountryPermissions($request);
                    break;
                case 'course':
                    return self::testCoursePermissions($request);
                    break;
                case 'department':
                    return self::testDepartmentPermissions($request);
                    break;
                case 'email':
                    return self::testEmailPermissions($request);
                    break;
                case 'password':
                    return self::testPasswordPermissions($request);
                    break;
                case 'birth_date':
                    return self::testBirthDatePermissions($request);
                    break;
                case 'phone':
                    return self::testPhonePermissions($request);
                    break;
                case 'role':
                    return self::testRolePermissions($request);
                    break;
                case 'room':
                    return self::testRoomPermissions($request);
                    break;
                case 'state':
                    return self::testStatePermissions($request);
                    break;
                case 'user':
                    return self::testUserPermissions($request);
                    break;
                case 'mobile_carrier':
                    return self::testMobileCarrierPermissions($request);
                    break;
                default:
                    return array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                    break;
            }
        }
    }

    /**
     * @param $request
     * @return array
     */
    private static function testAddressPermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_address ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_address ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_address ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testBuildingPermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_building ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_building ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_building ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testCampusPermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_campus ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_campus ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_campus ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testCountryPermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_country ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_country ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_country ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testCoursePermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_course ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_course ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_course ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testDepartmentPermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_department ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_department ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_department ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testEmailPermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_email ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_email ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_email ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testPasswordPermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_password ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_password ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_password ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
     * @param Request $request
     * @return array
     */
    private static function testBirthDatePermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_birth_date ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_birth_date ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_birth_date ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testPhonePermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_phone ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_phone ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_phone ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testRolePermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_role ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_role ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_role ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testRoomPermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_room ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_room ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_room ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testStatePermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_state ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_state ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_state ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testUserPermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_user ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_user ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_user ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testMobileCarrierPermissions(Request $request)
    {
        if ($request->header('X-Authorization')) {
            $key = self::getAPIKey($request->header('X-Authorization'));
            if ($key) {
                switch (strtolower($request->method())) {
                    case 'get' :
                        return $key->can_get_mobile_carrier ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'post' :
                        return $key->can_post_mobile_carrier ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
                        break;
                    case 'delete' :
                        return $key->can_delete_mobile_carrier ? array(true) : array(false, array("success" => false, "error" => "X-Authorization: Insufficient privileges."));
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
    private static function testGlobalPermission(Request $request)
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