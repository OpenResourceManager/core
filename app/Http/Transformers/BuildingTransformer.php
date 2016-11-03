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
            'label' => $item->label
        ];
    }

}