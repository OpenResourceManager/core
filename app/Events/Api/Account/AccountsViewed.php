<?php

namespace App\Events\Api\Account;

use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;
use App\Events\Api\ApiRequestEvent;

class AccountsViewed extends ApiRequestEvent
{
    /**
     * AccountsViewed constructor.
     * @param array $accountIds
     */
    public function __construct($accountIds = [])
    {
        parent::__construct();

        $logMessage = 'viewed accounts - ';
        $logContext = [
            'action' => 'view',
            'model' => 'account',
            'account_ids' => $accountIds,
            'account_id_count' => count($accountIds),
            'requester_id' => 0,
            'requester_name' => 'System',
            'requester_ip' => getRequestIP(),
            'request_proxy_ip' => getRequestIP(true),
            'request_method' => \Request::getMethod(),
            'request_url' => \Request::fullUrl(),
            'request_uri' => \Request::getRequestUri(),
            'request_scheme' => \Request::getScheme(),
            'request_host' => \Request::getHost()
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
