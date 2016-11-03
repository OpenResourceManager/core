<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Address;

class AddressTransformer extends TransformerAbstract
{
    
    /**
     * @param Address $item
     * @return array
     */
    public function transform(Address $item)
    {
        return [
            'id' => (int)$item->id,
        ];
    }

}