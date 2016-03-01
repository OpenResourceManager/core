<?php namespace App\UUD\Transformers;
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 3/1/16
 * Time: 12:49 PM
 */

class BirthDateTransformer extends Transformer
{

    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => (int)$item['id'],
            'user_id' => (int)$item['user_id'],
            'birth_date' => $item['birth_date'],
        ];
    }

}