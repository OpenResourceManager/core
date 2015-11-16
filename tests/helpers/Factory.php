<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/16/15
 * Time: 11:47 AM
 */

namespace tests\helpers;


trait Factory
{

    /**
     * @var int
     */
    protected $times = 1;

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
}