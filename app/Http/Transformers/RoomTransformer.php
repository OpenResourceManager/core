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
        $buildingTrans = new BuildingTransformer();

        return [
            'id' => (int)$item->id,
            'code' => $item->code,
            'floor_number' => (int)$item->floor_number,
            'floor_label' => $item->floor_label,
            'room_number' => (int)$item->room_number,
            'room_label' => $item->room_label,
            'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
            'building' => $buildingTrans->transform($item->building),
        ];
    }

}