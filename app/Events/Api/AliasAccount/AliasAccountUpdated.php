<?php

namespace App\Events\Api\AliasAccount;

use App\Events\Event;
use Illuminate\Support\Facades\Log;
use App\Http\Models\API\AliasAccount;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class AliasAccountUpdated extends Event
{
    /**
     * AliasAccountUpdated constructor.
     * @param AliasAccount $account
     */
    public function __construct(AliasAccount $account)
    {
        Log::info('Alias Account Updated:', [
            'id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'owner' => $account->owner->format_full_name(true),
            'owner_username' => $account->owner->username
        ]);

        if (auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $account->primary_duty = $account->primaryDuty;

                $trans = $account->toArray();
                $trans['name_full'] = $account->format_full_name(true);
                if (array_key_exists('password', $trans)) {
                    $trans['password'] = decrypt($trans['password']);
                }
                $trans['username'] = strtolower($trans['username']);

                $data_to_secure = json_encode([
                    'data' => $trans,
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'updated',
                    'type' => 'account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'AliasAccount',
                'updated an alias account for ' . $account->owner->format_full_name() . ' ' . $account->owner->username . ' --> ' . $account->username,
                $account->id,
                'fa-id-card-o',
                'bg-lime'
            );
        }
    }
}
