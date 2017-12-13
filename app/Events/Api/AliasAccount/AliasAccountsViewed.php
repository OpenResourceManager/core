<?php

namespace App\Events\Api\AliasAccount;

use App\Events\Api\ApiRequestEvent;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;

class AliasAccountsViewed extends ApiRequestEvent
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
                'AliasAccount',
                'viewed ' . count($accountIds) . ' alias accounts',
                $user->id,
                'fa-id-card-o',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($accountIds) . ' accounts', $accountIds);
    }
}
