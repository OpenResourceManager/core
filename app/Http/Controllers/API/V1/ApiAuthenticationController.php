<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dingo\Api\Facade\API;

class ApiAuthenticationController extends ApiController
{
    /**
     * @return array
     */
    public function authenticate()
    {
        $credentials = Input::only('username', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Invalid credentials were supplied.');
        } catch (JWTException $e) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException('Could not create new token.', $e);
        }
        // Return success.
        return compact('token');
    }

    /**
     * @return mixed
     */
    public function validateToken()
    {
        $user = API::user();
        return $this->response->array([
            'user' => $user->username,
            'message' => 'success',
            'status_code' => 200
        ])->setStatusCode(200);
    }
}
