<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Country;

class CountryTransformer extends TransformerAbstract
{
    
    /**
     * @param Country $item
     * @return array
     */
    public function transform(Country $item)
    {
        return [
            'id' => (int)$item->id,
        ];
    }

}