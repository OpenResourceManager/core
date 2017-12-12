<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;


class UnassignedRoom extends Event
{
    /**
     * UnassignedRoom constructor.
     * @param Account $account
     * @param Room $room
     */
    public function __construct(Account $account, Room $room)
    {
        $logMessage = 'unassigned account from room - ';
        $logContext = [
            'action' => 'unassignment',
            'model' => 'account',
            'pivot' => 'room',
            'account_id' => $account->id,
            'account_identifier' => $account->identifier,
            'account_username' => $account->username,
            'account_name_first' => $account->name_first,
            'account_name_last' => $account->name_last,
            'account_name' => $account->format_full_name(true),
            'account_created' => $account->created_at,
            'account_updated' => $account->updated_at,
            'room_id' => $room->id,
            'room_code' => $room->code,
            'room_label' => $room->label,
            'requester_id' => 0,
            'requester_name' => 'System',
            'requester_ip' => getRequestIP(),
            'proxy_ip' => getRequestIP(true)
        ];

        if ($user = auth()->user()) {

            $logMessage = auth()->user()->name . ' ' . $logMessage;
            $logContext['requester_id'] = auth()->user()->id;
            $logContext['requester_name'] = auth()->user()->name;

            if (Settings::get('broadcast-events', false)) {

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
                    'event' => 'unassigned',
                    'type' => 'room',
                    'to' => 'account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Assignment',
                'unassigned ' . $account->format_full_name() . ' room ' . $room->room_number . ' in ' . $room->building->label,
                $account->id,
                'building-o',
                'bg-yellow'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
