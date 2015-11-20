<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/19/15
 * Time: 10:56 PM
 */
namespace App\UUD\Transformers;

class CommunityTransformer extends Transformer
{

    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'code' => $item['code'],
            'name' => $item['name']
        ];
    }

}