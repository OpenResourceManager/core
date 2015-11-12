<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/12/15
 * Time: 9:00 AM
 */

namespace App\UUD\Transformers;

class BuildingTransformer extends Transformer
{
    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => (int)$item['id'],
            'campus_id' => (int)$item['campus_id'],
            'code' => $item['code'],
            'name' => $item['name']
        ];
    }

}