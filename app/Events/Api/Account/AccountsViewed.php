<?php

namespace App\Events\Api\Account;

use Illuminate\Broadcasting\Channel;
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
