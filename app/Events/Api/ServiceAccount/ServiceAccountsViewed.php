<?php

namespace App\Events\Api\ServiceAccount;

use App\Events\Api\ApiRequestEvent;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;

class ServiceAccountsViewed extends ApiRequestEvent
{
    /**
     * AliasAccountsViewed constructor.
     * @param array $accountIds
     */
    public function __construct($accountIds = [])
    {
        parent::__construct();

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                //@todo broadcast view event
            }

            history()->log(
                'ServiceAccount',
                'viewed ' . count($accountIds) . ' service accounts',
                $user->id,
                'fa-magic',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($accountIds) . ' accounts', $accountIds);
    }
}
