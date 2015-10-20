<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/20/15
 * Time: 3:15 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class APIKey extends Model
{
    protected $table = 'apikeys';

    /**
     * @param string $key
     * @return mixed
     */
    public static function getAPIKey($key = '')
    {
        return APIKey::where('key', $key)->get()->first();
    }
}