<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 4/5/16
 * Time: 5:48 PM
 */
namespace App\UUD\Transformers;

use Illuminate\Support\Facades\Crypt;

class SocialSecurityNumberTransformer extends Transformer
{

    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => (int)$item['id'],
            'user_id' => (int)$item['user_id'],
            'ssn' => Crypt::decrypt($item['social_security_number'])
        ];
    }

}