<?php

namespace App\Events\Api\Account;

use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Redis;
use App\Http\Models\API\Account;
use Illuminate\Support\Facades\Log;
use App\Events\Api\ApiRequestEvent;

class AccountDestroyed extends ApiRequestEvent
{

    /**
     * AccountDestroyed constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        parent::__construct();

        $logMessage = 'destroyed account - ';
        $logContext = [
            'action' => 'destroy',
            'model' => 'account',
            'account_id' => $account->id,
            'account_identifier' => $account->identifier,
            'account_username' => $account->username,
            'account_name_first' => $account->name_first,
            'account_name_last' => $account->name_last,
            'account_name' => $account->format_full_name(true),
            'account_created' => $account->created_at,
            'account_updated' => $account->updated_at,
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
                $trans['name_full'] = $account->format_full_name(true);
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
                    'type' => 'account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Account',
                'deleted an account for ' . $account->format_full_name() . ' [' . $account->identifier . ']',
                $account->id,
                'user-circle',
                'bg-red'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
