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
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => (int)$item['id'],
            'code' => $item['code'],
            'name' => $item['name']
        ];
    }
}