<?php

namespace App\Events\Api\ServiceAccount;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\ServiceAccount;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class ServiceAccountViewed extends ApiRequestEvent
{

    /**
     * ServiceAccountViewed constructor.
     * @param ServiceAccount $account
     */
    public function __construct(ServiceAccount $account)
    {
        parent::__construct();

        $logMessage = 'viewed alias account - ';
        $logContext = [
            'action' => 'view',
            'model' => 'alias_account',
            'alias_account_id' => $account->id,
            'alias_account_identifier' => $account->identifier,
            'alias_account_username' => $account->username,
            'owner_name' => $account->account->format_full_name(true),
            'owner_identifier' => $account->account->identifier,
            'owner_username' => $account->account->username,
            'alias_account_created' => $account->created_at,
            'alias_account_updated' => $account->updated_at,
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
                // @todo broadcast view event
            }

            history()->log(
                'ServiceAccount',
                'viewed service account: ' . $account->username,
                $account->id,
                'fa-magic',
                'bg-aqua'
            );
        }

        Log::info($logMessage, $logContext);
    }
}