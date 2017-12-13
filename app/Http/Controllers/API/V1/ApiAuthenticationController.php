<?php

namespace App\Http\Controllers\API\V1;


use App\Events\Api\Authentication\AuthenticationFailure;
use App\Events\Api\Authentication\AuthenticationSuccess;
use App\Events\Api\Authentication\AuthenticationValidate;
use Dingo\Api\Http\Request;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiAuthenticationController extends ApiController
{

    /**
     * ApiAuthenticationController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Login
     *
     * Endpoint for credentials to be posted. Returns a JWT.
     *
     * @return array
     */
    public function login(Request $request)
    {
        $credentials = Input::only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                event(new AuthenticationFailure($request));
                throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Invalid credentials were supplied.');
            }
        } catch (JWTException $e) {
            event(new AuthenticationFailure($request));
            throw new \Symfony\Component\HttpKernel\Exception\HttpException('Could not create new token.', $e);
        }
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            event(new AuthenticationFailure($request));
            throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Invalid credentials were supplied.');
        }
        event(new AuthenticationSuccess($user));
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
    public function secretLogin(Request $request)
    {
        $secret = Input::only('secret');
        try {
            $user = User::where('api_secret', strtoupper($secret['secret']))->first();
            if (!$user) {
                event(new AuthenticationFailure($request));
                throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Invalid credentials were supplied.');
            }
            if (!$token = JWTAuth::fromUser($user)) {
                event(new AuthenticationFailure($request));
                throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Invalid credentials were supplied.');
            }
        } catch (JWTException $e) {
            event(new AuthenticationFailure($request));
            throw new \Symfony\Component\HttpKernel\Exception\HttpException('Could not create new token.', $e);
        }
        event(new AuthenticationSuccess($user));
        // Return success.
        return compact('token');

    }

    /**
     * Validate Session
     *
     * Validate JWT by hitting this end point.
     *
     * @param Request $request
     * @return mixed
     */
    public function validateAuth(Request $request)
    {
        $user = auth()->user();

        if (!$user) throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('You are not authorized.');

        event(new AuthenticationValidate($user));

        return $this->response->array([
            'user' => $user->email,
            'message' => 'success',
            'status_code' => 202
        ])->setStatusCode(202);
    }
}
