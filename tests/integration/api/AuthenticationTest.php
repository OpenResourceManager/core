<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticationTestCase extends TestCase
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
                'user' => 'admin',
                'message' => 'success',
                'status_code' => 202
            ]);
    }
}
