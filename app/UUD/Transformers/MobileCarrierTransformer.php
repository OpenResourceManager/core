<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/29/16
 * Time: 1:47 PM
 */
namespace App\UUD\Transformers;

class MobileCarrierTransformer extends Transformer
{

    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => (int)$item['id'],
            'name' => $item['name'],
            'code' => $item['code']
        ];
    }

}