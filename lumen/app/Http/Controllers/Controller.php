<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request as Request;
use App\APIKey;

class Controller extends BaseController
{
    /**
     * @param string $key
     * @return mixed
     */
    public function getAPIKey($key = '')
    {
        return APIKey::where('key', $key)->get()->first();
    }


}
