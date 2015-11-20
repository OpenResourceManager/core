<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/12/15
 * Time: 2:23 PM
 */
namespace App\UUD\Transformers;

class RoomTransformer extends Transformer
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
            'building_id' => (int)$item['building_id'],
            'floor_number' => (int)$item['floor_number'],
            'floor_name' => $item['floor_name'],
            'room_number' => (int)$item['room_number'],
            'room_name' => $item['room_name']
        ];
    }
}