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

        $logMessage = 'viewed alias accounts - ';
        $logContext = [
            'action' => 'view',
            'model' => 'alias_account',
            'alias_account_ids' => $accountIds,
            'alias_account_id_count' => count($accountIds),
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
                'AliasAccount',
                'viewed ' . count($accountIds) . ' alias accounts',
                $user->id,
                'fa-id-card-o',
                'bg-aqua'
            );

        }

        Log::info($logMessage, $logContext);
    }
}
