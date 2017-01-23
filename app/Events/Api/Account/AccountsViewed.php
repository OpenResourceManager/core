<?php

namespace App\Events\Api\Account;

use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;
use App\Events\Event;

class AccountsViewed extends Event
{
    /**
     * AccountsViewed constructor.
     * @param array $accountIds
     */
    public function __construct($accountIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                //@todo broadcast view event
            }

            history()->log(
                'Account',
                'viewed ' . count($accountIds) . ' accounts',
                $user->id,
                'users',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($accountIds) . ' accounts', $accountIds);
    }
}
