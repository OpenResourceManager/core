<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 9:56 PM
 */
namespace App\UUD\Transformers;

class CountryTransformer extends Transformer
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
            'a3' => $item['code'],
            'a2' => $item['abbreviation']
        ];
    }

}