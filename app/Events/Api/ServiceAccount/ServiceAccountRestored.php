<?php

namespace App\Events\Api\ServiceAccount;

use Krucas\Settings\Facades\Settings;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use App\Http\Models\API\ServiceAccount;
use Illuminate\Support\Facades\Log;

class ServiceAccountRestored extends Event
{

    /**
     * AliasAccountRestored constructor.
     * @param ServiceAccount $account
     */
    public function __construct(ServiceAccount $account)
    {
        Log::info('Alias Account Restored:', [
            'id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'owner' => $account->account->format_full_name(true),
            'owner_username' => $account->account->username
        ]);

        if (auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $account->primary_duty = $account->primaryDuty;
                $trans = $account->toArray();

                if (array_key_exists('password', $trans)) {
                    $trans['password'] = decrypt($trans['password']);
                }
                $trans['username'] = strtolower($trans['username']);
                if (empty($trans['name_middle'])) unset($trans['name_middle']);

                $data_to_secure = json_encode([
                    'data' => $trans,
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'restored',
                    'type' => 'service-account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'ServiceAccount',
                'restored a service account for ' . $account->account->format_full_name() . ' - ' . $account->username,
                $account->id,
                'fa-magic',
                'bg-lime'
            );
        }
    }
}
