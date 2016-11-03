<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Campus;

class CampusTransformer extends TransformerAbstract
{
    
    /**
     * @param Campus $item
     * @return array
     */
    public function transform(Campus $item)
    {
        return [
            'id' => (int)$item->id,
            'code' => $item->code,
            'label' => $item->label
        ];
    }

}