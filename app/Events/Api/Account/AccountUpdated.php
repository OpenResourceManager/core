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
        $logMessage = 'updated account - ';
        $logContext = [
            'action' => 'update',
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
            'requester_name' => 'System'
        ];

        if (auth()->user()) {

            $logMessage = auth()->user()->name . ' ' . $logMessage;
            $logContext['requester_id'] = auth()->user()->id;
            $logContext['requester_name'] = auth()->user()->name;

            if (Settings::get('broadcast-events', false)) {

                $account->primary_duty = $account->primaryDuty;

                $trans = $account->toArray();
                $trans['name_full'] = $account->format_full_name(true);
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

        Log::info($logMessage, $logContext);
    }
}
