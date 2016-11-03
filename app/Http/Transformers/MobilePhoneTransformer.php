<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\MobilePhone;

class MobilePhoneTransformer extends TransformerAbstract
{
    
    /**
     * @param MobilePhone $item
     * @return array
     */
    public function transform(MobilePhone $item)
    {
        return [
            'id' => (int)$item->id,
        ];
    }

}