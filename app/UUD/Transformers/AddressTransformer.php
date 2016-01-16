<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 9:55 PM
 */
namespace App\UUD\Transformers;

class AddressTransformer extends Transformer
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
            'addressee' => $item['addressee'],
            'organization' => $item['organization'],
            'line_1' => $item['line_1'],
            'line_2' => $item['line_2'],
            'city' => $item['city'],
            'state_id' => (int)$item['state_id'],
            'zip' => $item['zip'],
            'country_id' => (int)$item['country_id'],
            'latitude' => (float)$item['latitude'],
            'longitude' => (float)$item['longitude']
        ];
    }

}