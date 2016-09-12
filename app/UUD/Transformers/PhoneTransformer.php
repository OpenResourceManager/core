<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/12/15
 * Time: 4:47 PM
 */
namespace App\UUD\Transformers;

use App\Model\MobileCarrier;
use App\Model\Phone;


class PhoneTransformer extends Transformer
{

    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        $carrier = null;

        if ((bool)$item['is_cell']) {
            $mobileCarrierTransformer = new MobileCarrierTransformer;
            $carrier = $mobileCarrierTransformer->transform(MobileCarrier::find((object)$item->carrier));
        }

        return [
            'id' => (int)$item['id'],
            'user_id' => (int)$item['user_id'],
            'number' => $item['number'],
            //'country_code' => $item['country_code'],
            'ext' => $item['ext'],
            'is_cell' => (bool)$item['is_cell'],
            'carrier' => $carrier
        ];
    }

}