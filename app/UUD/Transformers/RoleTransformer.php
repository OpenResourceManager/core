<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/18/15
 * Time: 9:24 AM
 */
namespace App\UUD\Transformers;

class RoleTransformer extends Transformer
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