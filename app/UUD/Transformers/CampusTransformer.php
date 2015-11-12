<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/11/15
 * Time: 9:01 PM
 */

namespace App\UUD\Transformers;

class CampusTransformer extends Transformer
{
    /**
     * @param $campus
     * @return array
     */
    public function transform($campus)
    {
        return [
            'id' => (int)$campus['id'],
            'code' => $campus['code'],
            'name' => $campus['name']
        ];
    }
}