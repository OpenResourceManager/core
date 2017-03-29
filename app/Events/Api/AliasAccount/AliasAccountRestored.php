<?php

namespace App\Events\Api\AliasAccount;

use Krucas\Settings\Facades\Settings;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use App\Http\Models\API\AliasAccount;
use Illuminate\Support\Facades\Log;

class AliasAccountRestored extends Event
{

    /**
     * AliasAccountRestored constructor.
     * @param AliasAccount $account
     */
    public function __construct(AliasAccount $account)
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
                $trans['name_full'] = $account->format_full_name(true);
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
                    'type' => 'alias-account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'AliasAccount',
                'restored an alias account for ' . $account->account->format_full_name() . ' ' . $account->account->username  . ' --> ' . $account->username,
                $account->id,
                'fa-id-card-o',
                'bg-lime'
            );
        }
    }
}
