<?php

namespace App\Events\Api\Account;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Account;
use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;


class AssignedRoom extends ApiRequestEvent
{
    /**
     * AddressCreated constructor.
     * @param Account $account
     */
    public function __construct(Account $account, Room $room)
    {

        parent::__construct();

        $logMessage = 'assigned account to room - ';
        $logContext = [
            'action' => 'assignment',
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
            'room_number' => $room->room_number,
            'room_building_label' => $room->building->label,
            'requester_id' => 0,
            'requester_name' => 'System',
            'requester_ip' => getRequestIP(),
            'request_proxy_ip' => getRequestIP(true),
            'request_method' => \Request::getMethod(),
            'request_url' => \Request::fullUrl(),
            'request_uri' => \Request::getRequestUri(),
            'request_scheme' => \Request::getScheme(),
            'request_host' => \Request::getHost()
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
                    'event' => 'assigned',
                    'type' => 'room',
                    'to' => 'account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Assignment',
                'assigned ' . $account->format_full_name() . ' room ' . $room->room_number . ' in ' . $room->building->label,
                $account->id,
                'building-o',
                'bg-olive'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
