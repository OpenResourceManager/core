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
        $transformed = [
            'id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'name_prefix' => $account->name_prefix,
            'name_first' => $account->name_first,
            'name_middle' => $account->name_middle,
            'name_last' => $account->name_last,
            'name_postfix' => $account->name_postfix,
            'name_phonetic' => $account->name_phonetic,
            'primary_duty' => $account->primary_duty
        ];

        $user = auth()->user();

        if ($user->can(['read-classified', 'write-classified'])) {
            if (isset($account->ssn)) $transformed['created'] = decrypt($account->ssn);
            if (isset($account->password)) $transformed['password'] = decrypt($account->password);
            if (isset($account->birth_date)) $transformed['birth_date'] = decrypt($account->birth_date);
        }

        $transformed['created'] = date('Y-m-d - H:i:s', strtotime($account->created_at));
        $transformed['updated'] = date('Y-m-d - H:i:s', strtotime($account->updated_at));
        return $transformed;
    }

}