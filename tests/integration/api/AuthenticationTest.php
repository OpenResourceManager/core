<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->logIn();
    }

    /** @test */
    public function users_can_login_and_validate_jwt_over_api()
    {
        $this->get('/api/v1/auth/validate', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(202)
            ->seeJsonEquals([
                'user' => 'admin@example.com',
                'message' => 'success',
                'status_code' => 202
            ]);
    }

    /** @test */
    public function authentication_fails_with_wrong_credentials()
    {
        $this->post('/api/v1/auth/login', ['email' => 'admin@example.com', 'password' => 'Saz'])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
