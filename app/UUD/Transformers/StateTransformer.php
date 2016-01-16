<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 9:56 PM
 */
namespace App\UUD\Transformers;

class StateTransformer extends Transformer
{
    
    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => (int)$item['id'],
            'country_id' => (int)$item['country_id'],
            'name' => $item['name'],
            'code' => $item['code']
        ];
    }

}