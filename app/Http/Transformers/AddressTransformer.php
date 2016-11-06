<?php

namespace App\Http\Transformers;

use App\Http\Models\API\Country;
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
        $countryTrans = new CountryTransformer();
        $stateTrans = new StateTransformer();
        $country = $countryTrans->transform($item->country);
        $state = $stateTrans->transform($item->state);

        return [
            'id' => (int)$item->id,
            'user_id' => (int)$item->account_id,
            'addressee' => $item->addressee,
            'organization' => $item->organization,
            'line_1' => $item->line_1,
            'line_2' => $item->line_2,
            'city' => $item->city,
            'state' => $state,
            'zip' => $item->zip,
            'country_id' => $country,
            'latitude' => (float)$item->latitude,
            'longitude' => (float)$item->longitude,
            'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
        ];
    }

}