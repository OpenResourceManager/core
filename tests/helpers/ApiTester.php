<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/13/15
 * Time: 2:41 PM
 */

use Illuminate\Support\Facades\Artisan;
use Faker\Factory as Faker;

abstract class ApiTester extends TestCase
{

    /**
     * @var Faker
     */
    protected $fake;

    /**
     * ApiTester constructor.
     * @param $fake
     */
    public function __construct()
    {
        $this->fake = Faker::create();
    }

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate:refresh');
    }

    /**
     * @param $uri
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    protected function getJson($uri, $method = 'GET', $parameters = [])
    {
        return json_decode($this->call($method, $uri, $parameters)->getContent());

    }

    protected function assertObjectHasAttributes()
    {
        $args = func_get_args();
        $object = array_shift($args);
        foreach ($args as $attribute) {
            $this->assertObjectHasAttribute($attribute, $object);
        }
    }
}
