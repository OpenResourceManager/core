<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;


class AccountCreated extends Event
{

    /**
     * @var array
     */
    public $message;

    /**
     * AddressCreated constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        Log::info('Account Created:', [
            'id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'name' => $account->format_full_name(true)
        ]);

        $account->primary_duty = $account->primaryDuty;
        $trans = $account->toArray();
        $trans['name_full'] = $account->format_full_name(true);
        $trans['password'] = decrypt($trans['password']);
        $trans['username'] = strtolower($trans['username']);

        $data_to_secure = json_encode([
            'data' => $trans,
            'conf' => [
                'ldap' => ldap_config()
            ]
        ]);

        $secure_data = encrypt_broadcast_data($data_to_secure);

        $message = [
            'event' => 'created',
            'type' => 'account',
            'encrypted' => $secure_data
        ];

        Redis::publish('events', json_encode($message));

        if (auth()->user()) {
            history()->log(
                'Account',
                'created a new account for ' . $account->format_full_name() . ' [' . $account->identifier . ']',
                $account->id,
                'user',
                'bg-green'
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
//        return 'events';
//    }
}
