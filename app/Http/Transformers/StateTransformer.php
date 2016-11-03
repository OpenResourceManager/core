<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\State;

class StateTransformer extends TransformerAbstract
{
    
    /**
     * @param State $item
     * @return array
     */
    public function transform(State $item)
    {
        return [
            'id' => (int)$item->id,
        ];
    }

}