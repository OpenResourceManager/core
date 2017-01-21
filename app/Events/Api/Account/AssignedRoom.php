<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;


class AssignedRoom extends Event
{
    /**
     * AddressCreated constructor.
     * @param Account $account
     */
    public function __construct(Account $account, Room $room)
    {
        if (auth()->user()) {

            $info = [
                'account_id' => $account->id,
                'identifier' => $account->identifier,
                'username' => $account->username,
                'name' => $account->format_full_name(true),
                '$room_id' => $room->id,
                'room_number' => $room->room_number,
                'building_label' => $room->building->label
            ];

            Log::info('Account assigned Room:', $info);

            $account->primary_duty = $account->primaryDuty;
            $trans = $account->toArray();
            $trans['name_full'] = $account->format_full_name(true);
            unset($trans['password']);
            $trans['username'] = strtolower($trans['username']);

            $data_to_secure = json_encode([
                'data' => [
                    'account' => $account,
                    'room' => $room->toArray()
                ],
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'assigned',
                'type' => 'room',
                'to' => 'account',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Assignment',
                'assigned ' . $account->format_full_name() . ' room ' . $room->room_number . ' in ' . $room->building->label,
                $account->id,
                'building-o',
                'bg-olive'
            );
        }
    }
}
