<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\MobilePhone;
use App\Http\Models\API\MobileCarrier;

class MobilePhoneTransformer extends TransformerAbstract
{

    /**
     * @param MobilePhone $item
     * @return array
     */
    public function transform(MobilePhone $item)
    {

        $carrierTrans = new MobileCarrierTransformer();

        $carrier = $carrierTrans->transform($item->mobileCarrier);

        return [
            'id' => (int)$item->id,
            'user_id' => (int)$item->account_id,
            'number' => $item->number,
            'country_code' => $item->country_code,
            'verified' => (bool)$item->verified,
            'verification_token' => $item->verification_token,
            'mobile_carrier' => $carrier
        ];
    }

}