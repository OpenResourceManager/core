<?php

namespace App\Events\Api\AliasAccount;

use App\Events\Api\ApiRequestEvent;
use Illuminate\Support\Facades\Log;
use App\Http\Models\API\AliasAccount;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class AliasAccountUpdated extends ApiRequestEvent
{
    /**
     * AliasAccountUpdated constructor.
     * @param AliasAccount $account
     */
    public function __construct(AliasAccount $account)
    {
        parent::__construct();

        $logMessage = 'updated alias account - ';
        $logContext = [
            'action' => 'update',
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
                if (array_key_exists('password', $trans)) {
                    $trans['password'] = decrypt($trans['password']);
                }
                $trans['username'] = strtolower($trans['username']);
                $trans['expired'] = $account->expired();

                $data_to_secure = json_encode([
                    'data' => $trans,
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'updated',
                    'type' => 'alias-account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'AliasAccount',
                'updated an alias account for ' . $account->account->format_full_name() . ' ' . $account->account->username . ' --> ' . $account->username,
                $account->id,
                'fa-id-card-o',
                'bg-lime'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
