<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/12/15
 * Time: 4:47 PM
 */
namespace App\UUD\Transformers;

class PhoneTransformer extends Transformer
{

    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'user_id' => $item['user_id'],
            'number' => $item['number'],
            'ext' => $item['ext'],
        ];
    }

}