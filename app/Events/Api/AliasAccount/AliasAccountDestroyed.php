<?php

namespace App\Events\Api\AliasAccount;

use App\Events\Api\ApiRequestEvent;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Redis;
use App\Http\Models\API\AliasAccount;
use Illuminate\Support\Facades\Log;

class AliasAccountDestroyed extends ApiRequestEvent
{

    /**
     * AliasAccountDestroyed constructor.
     * @param AliasAccount $account
     */
    public function __construct(AliasAccount $account)
    {
        parent::__construct();

        $logMessage = 'destroyed alias account - ';
        $logContext = [
            'action' => 'destroy',
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

        if (auth()->user()) {

            $logMessage = auth()->user()->name . ' ' . $logMessage;
            $logContext['requester_id'] = auth()->user()->id;
            $logContext['requester_name'] = auth()->user()->name;

            if (Settings::get('broadcast-events', false)) {

                $trans = $account->toArray();
                $trans['username'] = strtolower($trans['username']);

                $data_to_secure = json_encode([
                    'data' => $trans,
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'deleted',
                    'type' => 'alias-account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'AliasAccount',
                'deleted an alias account for ' . $account->account->format_full_name() . ' [' . $account->username . ']',
                $account->id,
                'fa-id-card-o',
                'bg-red'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
