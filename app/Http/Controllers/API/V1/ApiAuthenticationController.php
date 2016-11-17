<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Access\User\User;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dingo\Api\Facade\API;
use Illuminate\Support\Facades\Hash;

class ApiAuthenticationController extends ApiController
{
    /**
     * Login
     *
     * Endpoint for credentials to be posted. Returns a JWT.
     *
     * @return array
     */
    public function login()
    {
        $credentials = Input::only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Invalid credentials were supplied.');
        } catch (JWTException $e) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException('Could not create new token.', $e);
        }
        // Return success.
        return compact('token');
    }

    /**
     * Login with an API key secret
     *
     * Endpoint for api secret to be posted. Returns a JWT.
     *
     * @return array
     */
    public function secretLogin()
    {
        $secret = Input::only('secret');
        $user = User::where('api_secret', strtoupper($secret['secret']))->firstOrFail();

        try {
            if (!$token = JWTAuth::fromUser($user)) throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Invalid credentials were supplied.');
        } catch (JWTException $e) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException('Could not create new token.', $e);
        }
        // Return success.
        return compact('token');

    }

    /**
     * Validate Session
     *
     * Validate JWT by hitting this end point.
     *
     * @return mixed
     */
    public function validateAuth()
    {
        $user = auth()->user();

        if (!$user) throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('You are not authorized.');

        return $this->response->array([
            'user' => $user->email,
            'message' => 'success',
            'status_code' => 202
        ])->setStatusCode(202);
    }
}
