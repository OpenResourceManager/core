<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Room;

class RoomTransformer extends TransformerAbstract
{
    
    /**
     * @param Room $item
     * @return array
     */
    public function transform(Room $item)
    {
        return [
            'id' => (int)$item->id,
            'code' => $item->code,
            'building_id' => (int)$item->building_id,
            'floor_number' => (int)$item->floor_number,
            'floor_label' => $item->floor_label,
            'room_number' => (int)$item->room_number,
            'room_label' => $item->room_label
        ];
    }

}