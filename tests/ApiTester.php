<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/13/15
 * Time: 2:41 PM
 */

use \Illuminate\Support\Facades\Artisan;
use Faker\Factory as Faker;

abstract class ApiTester extends TestCase
{

    /**
     * @var Faker
     */
    protected $fake;

    /**
     * @var int
     */
    protected $times = 1;

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
     * @param $count
     * @return $this
     */
    public function times($count)
    {
        $this->times = $count;
        return $this;
    }

    /**
     * @param $type
     * @param array $fields
     */
    protected function make($type, array $fields = [])
    {
        while ($this->times--) {
            $stub = array_merge($this->getStub(), $fields);
            $type::create($stub);
        }
    }

    protected function getStub()
    {
        throw new BadMethodCallException('Create your own getStub method to declare your fields.');
    }

    /**
     * @param string $uri
     * @return string
     */
    protected function getJson($uri)
    {
        return json_decode($this->call('GET', $uri)->getContent());

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
