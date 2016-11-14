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
        $campusTrans = new CampusTransformer();

        return [
            'id' => (int)$item->id,
            'code' => $item->code,
            'label' => $item->label,
            'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
            'campus' => $campusTrans->transform($item->campus),
        ];
    }

}