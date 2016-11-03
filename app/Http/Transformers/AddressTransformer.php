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
            'user_id' => (int)$item->account_id,
            'addressee' => $item->addressee,
            'organization' => $item->organization,
            'line_1' => $item->line_1,
            'line_2' => $item->line_2,
            'city' => $item->city,
            'state_id' => (int)$item->state_id,
            'zip' => $item->zip,
            'country_id' => (int)$item->country_id,
            'latitude' => (float)$item->latitude,
            'longitude' => (float)$item->longitude
        ];
    }

}