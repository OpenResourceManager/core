<?php

namespace App\Events\Api\Account;

use App\Events\Event;
use Illuminate\Support\Facades\Log;
use App\Http\Models\API\Account;
use Krucas\Settings\Facades\Settings;

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

            if (Settings::get('broadcast-events', false)) {
                // @todo broadcast view event
            }

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