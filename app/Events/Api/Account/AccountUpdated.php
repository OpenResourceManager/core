<?php

namespace App\Events\Api\Account;

use App\Events\Event;
use Illuminate\Support\Facades\Log;
use App\Http\Models\API\Account;

class AccountUpdated extends Event
{
    /**
     * AccountUpdated constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        if (auth()->user()) {

            Log::info('Account Updated:', [
                'id' => $account->id,
                'identifier' => $account->identifier,
                'username' => $account->username,
                'name' => $account->format_full_name(true)
            ]);

            $trans = $account->toArray();
            $trans['name_full'] = $account->format_full_name(true);
            $trans['username'] = strtolower($trans['username']);
            $this->account = json_encode($trans);

            history()->log(
                'Account',
                'updated an account for ' . $account->format_full_name() . ' [' . $account->identifier . ']',
                $account->id,
                'user-circle',
                'bg-lime'
            );
        }
    }
}
