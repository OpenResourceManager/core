<?php

namespace App\Events\Api\ServiceAccount;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\ServiceAccount;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;


class ServiceAccountCreated extends ApiRequestEvent
{
    /**
     * AliasAccountCreated constructor.
     * @param ServiceAccount $account
     */
    public function __construct(ServiceAccount $account)
    {
        parent::__construct();

        Log::info('Alias Account Created:', [
            'id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'owner' => $account->account->format_full_name(true),
            'owner_username' => $account->account->username
        ]);

        if (auth()->user()) {

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
                    'event' => 'created',
                    'type' => 'service-account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'ServiceAccount',
                'created a new service account for ' . $account->account->format_full_name() . ' - ' . $account->username,
                $account->id,
                'fa-magic',
                'bg-green'
            );
        }
    }
}
