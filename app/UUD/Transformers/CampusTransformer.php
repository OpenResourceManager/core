<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/11/15
 * Time: 9:01 PM
 */

namespace UUD\Transformers;

class CampusTransformer extends Transformer
{
    /**
     * @param $campus
     * @return array
     */
    public function transform($campus)
    {
        return [
            'code' => $campus['code'],
            'name' => $campus['name']
        ];
    }
}