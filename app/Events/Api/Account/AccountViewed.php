<?php

namespace App\Events\Api\Account;

use App\Events\Event;
use Illuminate\Support\Facades\Log;
use App\Http\Models\API\Account;

class AccountViewed extends Event
{

    /**
     * AccountViewed constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Account',
                'viewed ' . $account->format_full_name() . '\'s account [' . $account->identifier . ']',
                $account->id,
                'user-circle',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $account->format_full_name() . '\'s account [' . $account->identifier . ']');

    }
}