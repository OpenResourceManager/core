<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/12/15
 * Time: 4:46 PM
 */
namespace App\UUD\Transformers;

use Illuminate\Support\Facades\Crypt;

class PasswordTransformer extends Transformer
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
            'password' => Crypt::decrypt($item['password'])
        ];
    }
}
