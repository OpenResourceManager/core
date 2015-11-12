<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/11/15
 * Time: 8:58 PM
 */

namespace App\UUD\Transformers;


abstract class Transformer
{
    /**
     * @param $item
     * @return mixed
     */
    public abstract function transform($item);

    /**
     * @param array $collection
     * @return array
     */
    public function transformCollection(array $collection)
    {
        return array_map([$this, 'transform'], $collection->toArray());
    }

}