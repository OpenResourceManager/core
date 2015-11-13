<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/13/15
 * Time: 2:41 PM
 */

use Faker\Factory as Faker;

class ApiTester extends TestCase
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
     * @param $uri
     * @return string
     */
    protected function getJson($uri)
    {
        return json_encode($this->call('GET', $uri)->getContent());

    }

}
