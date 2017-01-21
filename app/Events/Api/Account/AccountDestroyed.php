<?php

namespace App\Events\Api\Account;

use Illuminate\Broadcasting\Channel;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use App\Http\Models\API\Account;
use Illuminate\Support\Facades\Log;

class AccountDestroyed extends Event
{
    /**
     * @var string
     */
    public $message;

    /**
     * AccountDestroyed constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        if (auth()->user()) {

            Log::info('Account Deleted:', [
                'id' => $account->id,
                'identifier' => $account->identifier,
                'username' => $account->username,
                'name' => $account->format_full_name(true)
            ]);

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

            history()->log(
                'Account',
                'deleted an account for ' . $account->format_full_name() . ' [' . $account->identifier . ']',
                $account->id,
                'user-circle',
                'bg-red'
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
