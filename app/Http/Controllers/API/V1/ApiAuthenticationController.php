<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dingo\Api\Facade\API;

/**
 * Class ApiAuthenticationController
 * @package App\Http\Controllers\API\V1
 * @Resource("Authentication", uri="/auth")
 */
class ApiAuthenticationController extends ApiController
{
    /**
     * Login
     *
     * Endpoint for credentials to be posted. Returns a JWT.
     *
     * @return array
     *
     * @Post("/login")
     * @Transaction({
     *      @Request("username=foo&password=bar", contentType="application/x-www-form-urlencoded"),
     *      @Response(200, body={"token": "JWT"}),
     *      @Response(401, body={"error": {"UnauthorizedHttpException": {"Invalid credentials were supplied."}}}),
     *      @Response(500, body={"error": {"HttpException": {"Could not create new token."}}}),
     * })
     * @Parameters({
     *      @Parameter("username", type="string", required=true, description="The user's username to authenticate with."),
     *      @Parameter("password", type="string", required=true, description="The user's password to authenticate with.")
     * })
     */
    public function login()
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
     * Validate Session
     *
     * Validate JWT by hitting this end point.
     *
     * @return mixed
     *
     * @Get("/validate")
     * @Transaction({
     *      @Response(202, body={"user": "username", "message": "success", "status_code": 202}),
     *      @Response(401, body={"error": {"UnauthorizedHttpException": {"Invalid credentials were supplied."}}})
     * })
     */
    public function validateAuth()
    {
        $user = API::user();
        return $this->response->array([
            'user' => $user->username,
            'message' => 'success',
            'status_code' => 202
        ])->setStatusCode(202);
    }
}
