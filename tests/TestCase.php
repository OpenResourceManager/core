<?php

use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * The JWT for the admin account
     *
     * @var string
     */
    protected $bearer = '';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'EntrustTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'UsersTableSeeder']);
    }

    public function tearDown()
    {
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }

    /**
     * @param string $username
     * @param string $password
     * @return string $token
     */
    public function logIn($username = 'admin', $password = 'Cascade')
    {
        $response = $this->post('/api/v1/auth/login', ['username' => $username, 'password' => $password])
            ->seeStatusCode(200)
            ->decodeResponseJson();

        $this->assertArrayHasKey('token', $response);

        $this->bearer = $response['token'];

        return $response['token'];
    }
}
