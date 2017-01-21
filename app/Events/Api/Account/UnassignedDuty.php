<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Duty;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use App\Events\Event;


class UnassignedDuty extends Event
{

    /**
     * @var String
     */
    public $info;

    /**
     * UnassignedDuty constructor.
     * @param Account $account
     * @param Duty $duty
     */
    public function __construct(Account $account, Duty $duty)
    {
        if (auth()->user()) {

            $info = [
                'account_id' => $account->id,
                'identifier' => $account->identifier,
                'username' => $account->username,
                'name' => $account->format_full_name(true),
                'duty_id' => $duty->id,
                'duty_code' => $duty->code,
                'duty_label' => $duty->label
            ];

            Log::info('Account unassigned Duty:', $info);

            $account->primary_duty = $account->primaryDuty;
            $trans = $account->toArray();
            $trans['name_full'] = $account->format_full_name(true);
            unset($trans['password']);
            $trans['username'] = strtolower($trans['username']);

            $data_to_secure = json_encode([
                'data' => [
                    'account' => $account,
                    'duty' => $duty->toArray()
                ],
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'unassigned',
                'type' => 'duty',
                'to' => 'account',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));


            history()->log(
                'Assignment',
                'unassigned ' . $account->format_full_name() . ' from duty: "' . $duty->label . '"',
                $account->id,
                'cube',
                'bg-yellow'
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
//        return new PrivateChannel('duty-membership');
//    }
}
