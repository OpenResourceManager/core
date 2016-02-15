<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/12/15
 * Time: 9:49 AM
 */

namespace App\UUD\Transformers;


use App\Model\Email;
use App\Model\Phone;
use App\Model\User;

class UserTransformer extends Transformer
{
    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
             /* $phones = Phone::all()->where('user_id',$item['id'])->toArray();
                $emails = Email::all()->where('user_id',$item['id'])->toArray();

                if ($phones) {
                    $phoneTrans = new PhoneTransformer;
                    $phones = $phoneTrans->transformCollection($phones);
                }

                if ($emails) {
                    $emailTrans = new EmailTransformer;
                    $emails = $emailTrans->transformCollection($emails);
                }*/

        return [
            'id' => (int)$item['id'],
            'user_identifier' => $item['user_identifier'],
            'username' => $item['username'],
            'name_prefix' => $item['name_prefix'],
            'name_first' => $item['name_first'],
            'name_middle' => $item['name_middle'],
            'name_last' => $item['name_last'],
            'name_postfix' => $item['name_postfix'],
            'name_phonetic' => $item['name_phonetic'],
            'primary_role' => $item['primary_role'],
            //  'emails' => $emails,
            //  'phones' => $phones
        ];
    }
}
