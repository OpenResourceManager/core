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
        ];
    }

}