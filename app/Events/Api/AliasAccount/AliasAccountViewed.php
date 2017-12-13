<?php

namespace App\Events\Api\AliasAccount;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\AliasAccount;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class AliasAccountViewed extends ApiRequestEvent
{

    /**
     * AliasAccountViewed constructor.
     * @param AliasAccount $account
     */
    public function __construct(AliasAccount $account)
    {
        parent::__construct();

        $logMessage = 'viewed alias account - ';
        $logContext = [
            'action' => 'view',
            'model' => 'alias_account',
            'alias_account_id' => $account->id,
            'alias_account_username' => $account->username,
            'alias_account_created' => $account->created_at,
            'alias_account_updated' => $account->updated_at,
            'alias_account_owner_id' => $account->account->id,
            'alias_account_owner_name' => $account->account->format_full_name(true),
            'alias_account_owner_username' => $account->account->username,
            'alias_account_owner_identifier' => $account->account->identifier,
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
                'AliasAccount',
                'viewed ' . $account->account->format_full_name() . '\'s alias account [' . $account->username . ']',
                $account->id,
                'fa-id-card-o',
                'bg-aqua'
            );
        }

        Log::info($logMessage, $logContext);
    }
}