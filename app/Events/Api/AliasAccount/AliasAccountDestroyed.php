<?php

namespace App\Events\Api\AliasAccount;

use Krucas\Settings\Facades\Settings;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use App\Http\Models\API\AliasAccount;
use Illuminate\Support\Facades\Log;

class AliasAccountDestroyed extends Event
{

    /**
     * AliasAccountDestroyed constructor.
     * @param AliasAccount $account
     */
    public function __construct(AliasAccount $account)
    {
        Log::info('Alias Account Deleted:', [
            'id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'owner' => $account->account->format_full_name(true),
            'owner_username' => $account->account->username
        ]);

        if (auth()->user()) {

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
    }
}
