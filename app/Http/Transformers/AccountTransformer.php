<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/26/16
 * Time: 2:39 PM
 */

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Account;

class AccountTransformer extends TransformerAbstract
{
    /**
     * @param Account $account
     * @return array
     */
    public function transform(Account $account)
    {
        return [
            'id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'name_prefix' => $account->name_prefix,
            'name_first' => $account->name_first,
            'name_middle' => $account->name_middle,
            'name_last' => $account->name_last,
            'name_postfix' => $account->name_postfix,
            'name_phonetic' => $account->name_phonetic,
            'primary_role' => $account->primary_role,
            'waiting_for_password' => $account->waiting_for_password,
            'created' => date('Y-m-d', strtotime($account->created_at)),
            'updated' => date('Y-m-d', strtotime($account->updated_at)),
        ];
    }

}