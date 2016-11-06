<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Building;

class BuildingTransformer extends TransformerAbstract
{

    /**
     * @param Building $item
     * @return array
     */
    public function transform(Building $item)
    {
        return [
            'id' => (int)$item->id,
            'campus_id' => (int)$item->campus_id,
            'code' => $item->code,
            'label' => $item->label,
            'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
        ];
    }

}