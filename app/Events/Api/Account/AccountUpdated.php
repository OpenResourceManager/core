<?php

namespace App\Events\Api\Account;

use App\Events\Event;
use Illuminate\Support\Facades\Log;
use App\Http\Models\API\Account;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class AccountUpdated extends Event
{
    /**
     * AccountUpdated constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        Log::info('Account Updated:', [
            'id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'name' => $account->format_full_name(true)
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
                'Account',
                'updated an account for ' . $account->format_full_name() . ' [' . $account->identifier . ']',
                $account->id,
                'user-circle',
                'bg-lime'
            );
        }
    }
}
