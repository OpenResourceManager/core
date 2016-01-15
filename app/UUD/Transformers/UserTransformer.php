<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/12/15
 * Time: 9:49 AM
 */

namespace App\UUD\Transformers;


class UserTransformer extends Transformer
{
    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => (int)$item['id'],
            'user_identifier' => $item['user_identifier'],
            'username' => $item['username'],
            'name_prefix' => $item['name_prefix'],
            'name_first' => $item['name_first'],
            'name_middle' => $item['name_middle'],
            'name_last' => $item['name_last'],
            'name_postfix' => $item['name_postfix'],
            'name_phonetic' => $item['name_phonetic']
        ];
    }
}
