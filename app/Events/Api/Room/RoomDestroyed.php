<?php

namespace App\Events\Api\Room;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class RoomDestroyed extends ApiRequestEvent
{
    public function __construct(Room $room)
    {
        parent::__construct();

        $logMessage = 'destroyed room - ';
        $logContext = [
            'action' => 'destroy',
            'model' => 'room',
            'room_id' => $room->id,
            'room_code' => $room->code,
            'room_label' => $room->label,
            'room_number' => $room->number,
            'room_building_id' => $room->building->id,
            'room_building_code' => $room->building->code,
            'room_building_label' => $room->building->label,
            'room_created' => $room->created_at,
            'room_updated' => $room->updated_at,
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

            $building = $room->building;

            if (Settings::get('broadcast-events', false)) {

                $data_to_secure = json_encode([
                    'data' => $room->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'deleted',
                    'type' => 'room',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Room',
                'deleted room ' . (empty($room->label)) ? $room->code : $room->label . ' in ' . $building->label,
                $room->id,
                'building-o',
                'bg-red'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
