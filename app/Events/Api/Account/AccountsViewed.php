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
        $logMessage = 'viewed accounts - ';
        $logContext = [
            'action' => 'restore',
            'model' => 'account',
            'account_ids' => $accountIds,
            'account_id_count' => count($accountIds),
            'requester_id' => 0,
            'requester_name' => 'System'
        ];

        if ($user = auth()->user()) {

            $logMessage = auth()->user()->name . ' ' . $logMessage;
            $logContext['requester_id'] = auth()->user()->id;
            $logContext['requester_name'] = auth()->user()->name;

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

        Log::info($logMessage, $logContext);
    }
}
