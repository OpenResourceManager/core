<?php

namespace App\Events\Api\Account;

use Illuminate\Broadcasting\Channel;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use App\Http\Models\API\Account;
use Illuminate\Support\Facades\Log;

class AccountRestored extends Event
{

    /**
     * @var
     */
    public $account;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Account $account)
    {
        if (auth()->user()) {

            Log::info('Account Restored:', [
                'id' => $account->id,
                'identifier' => $account->identifier,
                'username' => $account->username,
                'name' => $account->format_full_name(true)
            ]);

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
                'type' => 'account',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Account',
                'restored an account for ' . $account->format_full_name() . ' [' . $account->identifier . ']',
                $account->id,
                'user',
                'bg-lime'
            );
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('account-events');
//    }
}
