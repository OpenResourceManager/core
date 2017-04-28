<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\Access\User\User;

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
     * The expected paginated structure
     *
     * @var array
     */
    protected $paginatedStructure = [
        'data' => [],
        'meta' => [
            'pagination' => [
                'total',
                'count',
                'per_page',
                'current_page',
                'total_pages',
                'links' => [
                    'next',
                    'previous'
                ]
            ]
        ]
    ];

    /**
     * @var array
     */
    protected $errorStructure = ['message', 'status_code'];

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
        Artisan::call('db:seed');
    }

    public function tearDown()
    {
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }

    /**
     * @param string $email
     * @param string $password
     * @return mixed
     */
    public function logIn($email = 'admin@example.com', $password = 'Cascade')
    {
        $response = $this->post('/api/v1/auth/login', ['email' => $email, 'password' => $password])
            ->seeStatusCode(200)
            ->decodeResponseJson();

        $this->assertArrayHasKey('token', $response);

        $this->bearer = $response['token'];

        return $response['token'];
    }

    /**
     * @return mixed
     */
    public function logInWithSecret()
    {
        $user = User::where('email', 'admin@example.com')->firstOrFail();

        $response = $this->post('/api/v1/auth', ['secret' => $user->api_secret])
            ->seeStatusCode(200)
            ->decodeResponseJson();

        $this->assertArrayHasKey('token', $response);

        $this->bearer = $response['token'];

        return $response['token'];
    }
}
